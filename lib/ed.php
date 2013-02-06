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

	// kept for backward compatibility
	public static function load( $module )
	{
		// sanity
		// NO * ALLOWED!!
		if( (strlen($module) < 1) || strstr($module,"*") ) { return false; }

		// split the path on "."
		$path = dirname(__FILE__)."/".join("/", explode(".", $module)).".php";

		// check to see if this path is in our included files already
		if( in_array($path, get_included_files()) ) { return false; }

		// make sure file exists
		if( !file_exists($path) ) { return false; }

		// get the file!
		require_once($path);
	}	
}
?>