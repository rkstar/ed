<?php
// SQLResult.php
// written by: David Fudge [ rkstar@mac.com ]
// created on: November 2, 2008
// last modified: October 21, 2012
//
// description:
// this class receives a database result and allows us to easily manipulate and
// retrieve info from it.
ed::load("Core.Object");

class SQLResult extends Object
{
	private $_data;
	private $_private_properties;

	public function __construct( $sth, $raw_query, $pdo )
	{
		$this->_private_properties = new Object(array(
			"pdo"	=> $pdo,
			"sth"	=> $sth,
			"query"	=> $raw_query,
			"action"=> strtolower(substr($raw_query,0,(strpos($raw_query, " ")+1)))
		));
		$this->_private_properties->numrows = ($this->_private_properties->action == "select")
												? count($this->_private_properties->sth->fetchAll())
												: (int)$this->_private_properties->sth->rowCount();

		$this->_data = new Object();
	}

	// override the "magic" methods
	public function __set( $key, $value ) { $this->_data->$key = $value; }
	public function __get( $key )
	{
		switch( strtolower($key) )
		{
			// get the query that was run
			case "query":			return $this->_private_properties->query;	break;
			// get the number of rows
			case "numrows":
			case "rowcount":
			case "affectedrows":	return $this->_private_properties->numrows;	break;
			// get the last insert id
			case "insertid":
			case "lastinsertid":	return (int)$this->_private_properties->pdo->lastInsertId();	break;
		}

		// no conditions met in our switch above...
		return (property_exists($this->_data, $key)) ? $this->_data->$key : null;
	}
	// allows us to get field values from the record even if they are named the same as publicly accessible "private" attributes
	public function getData( $key ) { return (property_exists($this->_data, $key)) ? $this->_data->$key : null; }

	public function next()
	{
		$this->_data = $this->_private_properties->sth->fetch();
		return ($this->_data);
	}
}
?>