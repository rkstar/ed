<?php
// ed.php
// written by: David Fudge [rkstar@mac.com]
// created on: November 1, 2008
// updated on: January 30, 2013

// "ed" is a static class only used to require data...
class ed
{
	// added "import" command for usability
	public static function import( $module ) { ed::load($module); }

	// added "local" function for differentiation
	public static function local( $module ) { ed::load($module,true); }

	// kept for backward compatibility
	public static function load( $module , $local = false )
	{
		// sanity
		// NO * ALLOWED!!
		if( (strlen($module) < 1) || strstr($module,"*") ) { return false; }

		// option to load based on current working directory where ed is loaded instead of the default relative to this file.
		$libDirectory 	=	(!$local)
							? dirname(__FILE__)
							: getcwd();

		$path 			=	(strstr($module, "/") !== false)
							? $module
							: $libDirectory."/".join("/", explode(".", $module)).".php";

		// check to see if this path is in our included files already
		if( in_array($path, get_included_files()) ) { return false; }

		// get the file!
		require_once($path);
	}	
}
?>