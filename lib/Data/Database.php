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
	
	private function buildRawQuery( $query, $bind_params=null )
	{
		if( is_null($bind_params) ) { return $query; }

		while( list($k,$v) = each($bind_params) )
		{
			$value = ((substr($v,0,1)==="/") && (substr($v,-1)==="/")) ? substr($v,1,-1) : "\"".$v."\"";
			$query = str_replace(":".$k, $value, $query);
		}

		return $query;
	}
	
	// execute the query
	public function execute( $qobject, $query, $bind_params=null )
	{
		// sanity
		if( strlen($query) < 1 ) { return false; }
		// more sanity
		$this->reconnect();

		// check for and act on bind_params
		if( !is_null($bind_params) && is_array($bind_params) )
		{
			$bp = array();
			while( list($k,$v) = each($bind_params) )
			{
				// check for mysql functions
				$isLiteral = ((substr($v,0,1)==="/") && (substr($v,-1)==="/"));
				if( !$isLiteral ) { continue; }

				$check_value = preg_replace('/[a-z_]/i', "", substr($v,1,-1));
				if( (substr($check_value,0,1)==="(") && (substr($check_value,-1)===")") )
				{
					$query = str_replace(":".$k, substr($v,1,-1), $query);
					unset($bind_params[$k]);
				}
			}
			reset($bind_params);
		}

		$sth = $this->pdo->prepare($query);
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
			while( list($k,$v) = each($bind_params) )
			{
				// push through the correct type of value
				((substr($v,0,1)==="/") && (substr($v,-1)==="/"))
					? $sth->bindValue(":".$k, substr($v,1,-1), PDO::PARAM_INT)
					: $sth->bindValue(":".$k, $v, PDO::PARAM_STR);
			}
		}

		// execute the statement!
		$successful = $sth->execute();
		$raw_query  = $this->buildRawQuery($sth->queryString, $bind_params);
		if( !$successful )
		{
			$err = $sth->errorInfo();
			$qobject->errorInfo = new Object(array(
				"state"		=> $err[0],
				"errorcode"	=> $err[1],
				"message"	=> $err[2]
			));
			$qobject->query = $raw_query;
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

		list($auth_string, $bind_params) = $qobject->getCondition();
		// start the query
		$q  = "select ";
		$q .= $qobject->fields." from ".$qobject->table;
		$q .= (strlen($auth_string) > 0) ? " where ".$auth_string : "";
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
		$qobject->bind_params = $bind_params;
		return $this->execute($qobject, $q, $bind_params);
	}

	// insert a record into our database
	public function insert( $qobject ) { return $this->insertOrReplace($qobject, true); }
	public function replace( $qobject ) { return $this->insertOrReplace($qobject, false); }
	private function insertOrReplace( $qobject, $is_insert=true )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }
		
		// start the query
		$q  = ($is_insert) ? "insert" : "replace";
		$q .= " into ".$qobject->table." ";
		// get the values and query string from query object
		list($queryString, $bind_params) = $qobject->getInsertValues();
		$q .= $queryString;

		// execute the query
		if( !($r = $this->execute($qobject, $q, $bind_params)) ) { return false; }
		// return the insert id
		return ($r->lastInsertId === 0) ? true : $r->lastInsertId;
	}
	
	// update database record/s
	public function update( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }

		// start the query
		list($queryValues, $values_bind_params) = $qobject->getUpdateValues();
		list($queryCondition, $condition_bind_params) = $qobject->getCondition();
		$q  = "update ".$qobject->table." set ";
		$q .= $queryValues;
		$q .= " where ";
		$q .= $queryCondition;
		$bind_params = array_merge($values_bind_params, $condition_bind_params);

		// set a limit on our query
		if( $qobject->limit > 0 ) { $q .= " limit ".$qobject->limit; }

		// execute the query which will allow us to automatically insert
		// if the update does not work...
		$r = $this->execute($qobject, $q, $bind_params);
		return ($r) ? $r : $this->insert($qobject);
	}
	
	// delete a record from the database
	public function delete( $qobject )
	{
		// sanity
		if( !is_object($qobject) ) { return false; }
		
		// set up the query
		$q  = "delete from ".$qobject->table." ";
		$q .= "where ";
		list($queryString, $bind_params) = $qobject->getCondition();
		$q .= $queryString;
		// set the limit
		if( $qobject->limit > 0 ) { $q .= " limit ".$qobject->limit; }
		
		// execute the query
		return ($this->execute($qobject, $q, $bind_params)) ? true : false;
	}
}
?>