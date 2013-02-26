<?php
// Object.php
// written by: David Fudge [rkstar@mac.com]
// created on: November 3, 2008
// updated on: October 21, 2012
//
// description:
// this is really basic and just allows us to create instantiate a customized object.
// this class is primarily for use with the SQLQuery and Form classes.
class Object
{
	// NOTE: the __construct and __call functions are from a JSObject
	// example to allow use of this object in the same fashion as a javascript
	// object.
	public function __construct( $properties=array() )
	{
		while( list($k,$v) = each($properties) ) { $this->$k = $v; }
	}

	// override the "magic" methods!
	public function __set( $key, $value ) { if( isset($key) ) { $this->$key = $value; } }
	public function __get( $key ) { return (isset($this->$key)) ? $this->$key : null; }
	public function __call( $name, $args )
	{
		if( is_callable($this->$name) )
		{
			array_unshift($args, $this);
			return call_user_func_array($this->$name, $args);
		}
	}
	
	/**
	* Prints out the contents of the object when used as a string
	*
	* @return string
	*/
	public function __toString()
	{
		$args = func_get_args();
		$method = ( ! empty($args)) ? $args[0] : "print_r";
		
		$output = "<pre>";
		
		if($method == "var_dump")
		{
			ob_start();
			var_dump($this);
			$output .= ob_get_contents();
			ob_end_clean();
		}
		else if($method == "var_export")
		{
			ob_start();
			var_export($this);
			$output .= ob_get_contents();
			ob_end_clean();
		}
		else
		{
			$output .= print_r($this, TRUE);
		}
		
		return $output . "</pre>";
	}

	public function json( $exceptions=NULL, $callback=NULL ) { return $this->jsonize($exceptions, $callback); }
	public function jsonize( $exceptions=NULL, $callback=NULL )
	{
		$exceptions = ($exceptions) ? $exceptions : array();
		$object = new Object();
		foreach ($this as $key => $value)
		{
			if( in_array($key, $exceptions) ) { continue; }
			$object->$key = $value;
		}
		$json_string = json_encode($object);
		return ($callback) ? $callback."(".$json_string.")" : $json_string;
	}
}
?>