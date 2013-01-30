<?php
// Form.php
// written by: David Fudge [rkstar@mac.com]
// created on: September 9, 2009  (hey! 9/9/9... spooky)
// updated on: September 24, 2012
//
// description:
// this static class will allow us to access any form submission vars through
// a globally available static class making it easier in syntax than $_POST["varname"].
// the syntax for accessing a form var, whether through $_POST, $_GET, or
// php://input (ie. XML submission) will be Form::varname
// easy right?
//
// NOTE: about form submission...
// we can accept both regular form submission through GET or POST but we can also
// accept XML form submission through the php://input data.
// if XML data is posted to our form, it will take precedence over regular form
// submission data.  HOWEVER, we will load form data first, then the XML data,
// so if there is a combination of data submitted and the variable names are all
// unique, ALL DATA will be available in our application.
ed::load("Core.Object");

class Form
{
	public static function raw()
	{
		global $_REQUEST, $_POST, $_GET;
		$vars = array_merge($_REQUEST, $_GET, $_POST);
		
		return $vars;
	}
	
	public static function data()
	{
		global $_REQUEST, $_POST, $_GET;
		$vars = array_merge($_REQUEST, $_GET, $_POST);
		
		return new Object($vars);
	}
	
	public static function xml()
	{
		$xmlstring = @file_get_contents("php://input");
		return @simplexml_load_string($xmlstring);
	}
	
	public static function json()
	{
		$jsonstring = @file_get_contents("php://input");
		return @json_decode($jsonstring);
	}
	
	public static function sanitized( $vars=array() )
	{
		$vars	= (count($vars) < 1) ? Form::raw() : $vars;
		$f		= array();
		while( list($k,$v) = each($vars) )
		{
			//
			// NOTE:
			// we used to also check for strlen() < 1 but there are times when
			// you might want to post a blank string to update a field to "nothing".
			//
			if( is_string($v) && (strtolower($v) === "null") ) { $v = ""; }
			if( is_null($v) ) { continue; }
				
			$f[$k] = $v;
		}

		return new Object($f);
	}
}
?>