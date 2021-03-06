<?php
// SQLQuery.php
// written by: David Fudge [ rkstar@mac.com ]
// created on: November 1, 2008
// last modified: October 21, 2012
//
// description:
// this file contains functions used for building an SQL query for our database API

ed::load("Core.Object");
ed::load("Data.Database");
ed::load("Data.XML");

class SQLQuery extends Object
{
	private $Database;
	private $_public_properties;
	private $_private_properties;
	private $_field_values;

	public function __construct( $members=array() )
	{
		parent::__construct($members);
		$this->init();
	}
	
	public function __set( $key, $value )
	{
		if( property_exists($this->_public_properties, $key) )
		{
			$this->_public_properties->$key = $value;
			return;
		}
	}
	public function __get( $key )
	{
		return (property_exists($this->_public_properties, $key))
				? $this->_public_properties->$key
				: null;
	}
	
	private function init()
	{
		$this->reset();
		// connect to the db!
		if( !$this->Database )
		{
			if( !($this->Database = new Database()) ) { die(); }
			// mysql allows us to override the password() functionality....
			if( defined("MYSQL_PASSWORD_OVERRIDE") && (DB_TYPE == "MYSQL") )
			{
				$q = null;
				switch( MYSQL_PASSWORD_OVERRIDE )
				{
					case CURRENT_MYSQL_PASSWORD:	$q = "set session old_passwords=0";		break;
					case OLD323_MYSQL_PASSWORD:		$q = "set session old_passwords=1";		break;
				}
				if( $q ) { $this->Database->execute($q); }
			}
		}
	}
	
	public function reset()
	{
		$this->_public_properties = new Object(array(
			"table"		=> "",
			"limit"		=> null,
			"fields"	=> "*",
			"orderBy"	=> null,
			"groupBy"	=> null,
			"direction"	=> null,
			"record"	=> null,
			"query"		=> "",
			"errorInfo"	=> null
		));
		
		$this->_private_properties = new Object(array(
			"authMethod"	=> null,
			"authGroups"	=> null,
		));

		$this->_field_values = new Object();
	}
	
	public function ascending() { $this->ascend(); }
	public function ascend()
	{
		$this->direction = "ASCEND";
	}
	public function descending() { $this->descend(); }
	public function descend()
	{
		$this->direction = "DESCEND";
	}
	
	// open a new auth group
	public function openAuthGroup( $linkage="and" )
	{
		// sanity
		if( is_null($this->_private_properties->authMethod) )
		{
			$this->_private_properties->authMethod = new XML("<query/>");
		}
		// group sanity
		if( !is_array($this->_private_properties->authGroups) )
		{
			$this->_private_properties->authGroups = array();
			$linkage = null;
		}
		// check if there is an open auth group
		$addto = (count($this->_private_properties->authGroups) > 0)
				 ? $this->_private_properties->authGroups[count($this->_private_properties->authGroups) - 1]
				 : $this->_private_properties->authMethod;
		// add a group to the authMethod xml
		$group = $addto->addChild("authGroup");
		if( !is_null($linkage) && ($linkage!="none") && ($linkage!="") ) { $group->addAttribute("linkage",$linkage); }
		// push the xml reference on to the authGroups array
		array_push($this->_private_properties->authGroups, $group);
	}
	// close auth group based on LIFO
	public function closeAuthGroup()
	{
		// sanity
		if( count($this->_private_properties->authGroups) < 1 ) { return; }
		// pop the last element off the array
		array_pop($this->_private_properties->authGroups);
	}
	public function clearAuthGroups() { unset($this->_private_properties->authGroups); }
	
	// accept singular values or take an OBJECT argument and easily loop through the indicies and values
	// to add them to the SQLQuery object and create the auth method for our query without having to
	// have a bunch of $db->setAuthMethod() calls
	public function setAuthMethod( $field, $value, $operator="=", $linkage="and" )
	{
		// check for an object in the field var
		if( is_object($field) ) { $this->addToAuthMethod($field); return; }

		// sanity
		if( !is_object($this->_private_properties->authMethod) )
		{
			$this->_private_properties->authMethod = new XML("<query/>");
		}
		// value sanity
		$value = (strtolower($operator)=="like") ? "%".str_replace(" ","%",$value)."%" : $value;

		// check for open groups to add this child to
		$addto = (count($this->_private_properties->authGroups) > 0)
				 ? $this->_private_properties->authGroups[count($this->_private_properties->authGroups) - 1]
				 : $this->_private_properties->authMethod;
		// add the field child
		$child = $addto->addChild($field,$value);
		$child->addAttribute("operator",$operator);
		$child->addAttribute("linkage",$linkage);
	}
	private function addToAuthMethod( $objectOrArray )
	{
		// make sure we're getting the object vars unless it's already an array
		$vars = (is_object($objectOrArray)) ? get_object_vars($objectOrArray) : $objectOrArray;
		while( list($k,$v) = each($vars) )
		{
			if( is_object($v) || is_array($v) ) { $this->addToAuthMethod($v); }
			else { $this->setAuthMethod($k,$v); }
		}
	}
	public function clearAuthMethod() { $this->_private_properties->authMethod = null; }

	// take an OBJECT argument and easily loop through the indices and values to add them to the SQLQuery object
	// and create our query without having to have a bunch of "db->setValue()" and db->setAuthMethod statements
	// in the calling code
	// NOTE:
	// argument sent to these functions must be an OBJECT keyed as follows:
	// <field name> = <field value>
	public function setValues( $objectOrArray ) { $this->addToValues($objectOrArray); }
	public function addToValues( $objectOrArray )
	{
		// make sure we're getting the object vars unless it's already an array
		$vars = (is_object($objectOrArray)) ? get_object_vars($objectOrArray) : $objectOrArray;
		while( list($k,$v) = each($vars) )
		{
			if( is_object($v) || is_array($v) ) { continue; } // not sure why THIS was here... --->> $this->addToValues($v); }
			else { $this->setValue($k,$v); }
		}
	}
	public function setValue( $key, $value ) { $this->_field_values->$key = $value; }
	public function getValues() { return $this->_field_values; }
	
	// automatic update fields
	public function autoUpdate()
	{
		// auto update field names are defined in our database config file
		// check for the field in our auto update field name
		if( defined("LASTMODIFIED") ) { $this->setValue(LASTMODIFIED, "/now()/"); }
		if( defined("IPADDRESS") ) { $this->setValue(IPADDRESS, getenv("REMOTE_ADDR")); }
	}
	
	// generate a safe query string condition from our auth methods for use
	// in "select, update, and delete" queries
	public function getCondition( $node = false )
	{
		// sanity
		if( !is_object($node) ) { $node = $this->_private_properties->authMethod; }
		// make sure to reset our auth groups array at this point
		$this->_private_properties->authGroups = array();
		
		$authString = "";
		// sanity
		if( !$node || !$node->children() ) { return $authString; }
		// loop thru the child nodes of our authMethod XML object
		$i=0;
		foreach( $node->children() as $child )
		{
			// special case for "authGroup" nodes
			if( $child->getName() == "authGroup" )
			{
				$authString .= $child->attributes()->linkage." ( ";
				$authString .= $this->getCondition($child);
				$authString .= ")";
			}
			else
			{
				// linkage...
				$authString .= ($i > 0) ? $child->attributes()->linkage." " : "";
				// add the name of the field
				$authString .= $child->getName()." ".$child->attributes()->operator." ";
				// check for literal field values
				$authString .= ((substr($child,0,1)=="/") && (substr($child,-1)=="/")) ? substr($child,1,-1) : "\"".$child."\"";
			}
			$authString .= " ";
			
			// increment i
			$i++;
		}
		
		return substr($authString,0,-1);	// get rid of trailing space...
	}

	public function raw( $q ) { return $this->rawQuery($q); }
	public function rawQuery( $q ) { return $this->Database->execute($this, $q); }
	public function select() { return $this->Database->select($this); }
	public function delete() { return $this->Database->delete($this); }
	public function insert()
	{
		$this->autoUpdate();
		return $this->Database->insert($this);
	}
	public function replace()
	{
		$this->autoUpdate();
		return $this->Database->replace($this);
	}
	public function update()
	{
		$this->autoUpdate();
		return $this->Database->update($this);
	}
}
?>