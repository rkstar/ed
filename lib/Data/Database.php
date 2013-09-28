<?php
// Database.php
// written by: David Fudge [rkstar@mac.com]
// created on: November 1, 2008
// updated on: October 21, 2012
//
// description:
// this file gives us a simple and familiar interface to PDO

// load dependencies here
ed::import("Core.Object");
ed::import("Data.SQLQuery");
ed::import("Data.SQLResult");

class Database extends Object
{
	private $dbhost;		// database host name
	private $dbuser;		// database user name
	private $dbpass;		// database password
	private $dbname;		// database name
	private $dbtype;		// database type
	private $dsn;			// dsn for pdo access
	private $pdo;			// the pdo connection object
	private $errorInfo;		// PDO::errorInfo as an object instead of indexed array

	// constructor
	public function __construct( $dbhost=DB_HOST, $dbuser=DB_USER, $dbpass=DB_PASS,
								 $dbname=DB_NAME, $dbtype=DB_TYPE, $dsn=PDO_DSN )
	{
		parent::__construct();
		// set vars
		$this->host     = $dbhost;
		$this->username = $dbuser;
		$this->password = $dbpass;
		$this->database = $dbname;
		$this->dbtype   = $dbtype;
		$this->dsn      = $dsn;
		// connect to the db
		return $this->connect();
	}

	// check connection status
	public function isConnected() { return (isset($this->pdo) && !is_null($this->pdo)); }
	
	// connect to the database
	public function connect()
	{
		// use PDO to connect!
		try
		{
			$this->pdo = new PDO($this->dsn, $this->username, $this->password);
			// check to see if we're forcing new passwords
			$forced = (FORCE_OLD_MYSQL_PASSWORDS) ? 1 : 0;
			@$this->pdo->exec("set session old_passwords=".$forced);
			// it works.
			return true;
		}
		catch( PDOException $e )
		{
			print "ERROR: ".$e->getMessage();
			die();
		}
	}
	
	// reconnect to the db
	public function reconnect()
	{
		if( !$this->isConnected() ) { return $this->connect(); }
		return true;
	}
	
	// disconnect from database
	public function disconnect()
	{
		// does nothing... PDO does not have a disconnect method
	}
	
	// get the available fields in a table
	public function getTableFieldList( $table )
	{
		$fieldList = array();

		$sql = new SQLQuery();
		$q   = "show fields from ".$table;
		if( !($r = $sql->rawQuery($q)) ) { return $fieldList; }
		// we have fields... continue
		while( $r->next() ) { array_push($fieldList,$r->Field); }
		
		return $fieldList;
	}
	
	// execute the query
	public function execute( $qobject, $raw_query, $bind_params=null )
	{
		// sanity
		if( strlen($raw_query) < 1 ) { return false; }
		// more sanity
		$this->reconnect();

		$sth = $this->pdo->prepare($raw_query);
		if( !$sth )
		{
			$err = $this->pdo->errorInfo();
			$qobject->errorInfo = new Object(array(
				"state"		=> $err[0],
				"errorcode"	=> $err[1],
				"message"	=> $err[2]
			));
			return null;
		}

		// check for and act on bind_params
		if( !is_null($bind_params) && is_array($bind_params) )
		{
			while( list($k,$v) = each($bind_params) ) { $sth->bindParam($k,$v); }
		}

		// execute the statement!
		if( !$sth->execute() )
		{
			$err = $sth->errorInfo();
			$qobject->errorInfo = new Object(array(
				"state"		=> $err[0],
				"errorcode"	=> $err[1],
				"message"	=> $err[2]
			));
			return null;
		}

		// set the fetch mode and go ahead!  woot.
		$sth->setFetchMode(PDO::FETCH_OBJ);
		
		// instantiate an SQLResult object
		$sqlResult = new SQLResult( $sth, $raw_query, $this->pdo );
		// some housekeeping to make sure we send back a FALSE if the query failed...
		// this only applies to SELECT and INSERT queries. DELETE and INSERT queries
		// would have failed with a FALSE response before this point.
		return ($sqlResult->numrows < 1) ? null : $sqlResult;
	}
	
	// select data from a database
	public function select( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }
		
		// start the query
		$q  = "select ";
		$q .= $qobject->fields." from ".$qobject->table;
		$q .= (strlen($qobject->getCondition()) > 0) ? " where ".$qobject->getCondition() : "";
		$q .= (strlen($qobject->groupBy) > 0) ? " group by ".$qobject->groupBy : "";
		$q .= (strlen($qobject->orderBy) > 0) ? " order by ".$qobject->orderBy : "";
		// condition by which we'll add the asd/desc delimiter
		if( ((strlen($qobject->groupBy) > 0) || (strlen($qobject->orderBy) > 0)) && $qobject->direction )
		{
			$q .= ($qobject->direction=="DESC") ? " DESC" : " ASC";
		}
		// limit conditions
		if( $qobject->limit ) { $q .= " limit ".$qobject->limit; }

		// set and execute the query
		$qobject->query = $q;
		//$qobject->setQuery($q);
		return $this->execute($qobject, $q);
	}

	// insert a record into our database
	public function insert( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }
		
		// get the available fields
		$fieldList = $this->getTableFieldList($qobject->table);
		
		// start the query
		$q = "insert into ".$qobject->table." ";
		// loop thru the fields and prepare them for the insert query
		$field_values = $qobject->getValues();
		$bind_params  = array();
		$fields = "(";
		$values = "(";
		while( list($k,$v) = each($field_values) )
		{
			// sanity :: make sure the field we're updating is available in the table
			if( !in_array($k, $fieldList) ) { continue; }
			// continue to build the query
			$bind_params[$k] = $v;
			// continue to set up the query
			$fields .= $k.",";
			$values .= ((substr($v,0,1)=="/") && (substr($v,-1)=="/"))
						? substr($v,1,-1)."," : "\"".$v."\",";
		}
		$fields = substr($fields,0,-1).")";
		$values = substr($values,0,-1).")";
		$q = $q.$fields." values ".$values;

		// set and execute the query
		$qobject->query = $q;
		if( !($r = $this->execute($qobject, $q, $bind_params)) ) { return false; }
		// return the insert id
		return ($r->lastInsertId === 0) ? true : $r->lastInsertId;
	}
	
	// replace database record/s
	public function replace( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }
		
		// get the available fields
		$fieldList = $this->getTableFieldList($qobject->table);
		
		// start the query
		$q = "replace into ".$qobject->table." ";
		// loop thru the fields and prepare them for the insert query
		$field_values = $qobject->getValues();
		$bind_params  = array();
		$fields = "(";
		$values = "(";
		while( list($k,$v) = each($field_values) )
		{
			// sanity :: make sure the field we're updating is available in the table
			if( !in_array($k, $fieldList) ) { continue; }
			// continue to build the query
			$bind_params[$k] = $v;
			// continue to set up the query
			$fields .= $k.",";
			$values .= ((substr($v,0,1)=="/") && (substr($v,-1)=="/"))
						? substr($v,1,-1)."," : "\"".$v."\",";
		}
		$fields = substr($fields,0,-1).")";
		$values = substr($values,0,-1).")";
		$q = $q.$fields." values ".$values;

		// set and execute the query
		$qobject->query = $q;
		return $this->execute($qobject, $q, $bind_params);
	}
	
	// update database record/s
	public function update( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }

		// get the available fields
		$fieldList = $this->getTableFieldList($qobject->table);
		
		// start the query
		$q  = "update ".$qobject->table." set ";
		// loop thru the fields and prepare them for the update query
		$field_values = $qobject->getValues();
		$bind_params  = array();
		$field_update = "";
		while( list($k,$v) = each($field_values) )
		{
			// sanity :: make sure the field we're updating is available in the table
			if( !in_array($k, $fieldList) ) { continue; }
			// continue to build the query
			$bind_params[$k] = $v;
			// continue to set up the query
			$field_update .= $k."=";
			$field_update .= ((substr($v,0,1)=="/") && (substr($v,-1)=="/"))
								? substr($v,1,-1)."," : "\"".$v."\",";
		}
		$field_update = substr($field_update,0,-1);
		$q .= $field_update." where ".$qobject->getCondition();
		// set a limit on our query
		if( $qobject->limit > 0 ) { $q .= " limit ".$qobject->limit; }
		
		// set and execute the query
		$qobject->query = $q;
		// set and execute the query which will allow us to automatically insert
		// if the update does not work...
		$r = $this->execute($qobject, $q,$bind_params);
		return ($r) ? $r : $this->insert($qobject);
	}
	
	// delete a record from the database
	public function delete( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }
		
		// set up the query
		$q  = "delete from ".$qobject->table." ";
		$q .= "where ".$qobject->getCondition();
		// set the limit
		if( $qobject->limit > 0 ) { $q .= " limit ".$qobject->limit; }
		
		// set and execute the query
		$qobject->query = $q;
		return ($this->execute($qobject, $q)) ? true : false;
	}
}
?>