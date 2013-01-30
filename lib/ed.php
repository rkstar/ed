<?php
// ed.php
// written by: David Fudge [rkstar@mac.com]
// created on: November 1, 2008
// updated on: January 30, 2013

// "ed" is a static class only used to require data...
class ed
{
	// added "import" command for usability
	public static function import( $pkg ) { ed::load($pkg); }

	// kept for backward compatibility
	public static function load( $pkg )
	{
		// sanity
		if( strlen($pkg) < 1 ) { return false; }

		// we'll replace the "."s with "/"s
		$path = (strstr($pkg,".")) ? str_replace(".","/",$pkg) : $pkg;
		// find the last dir in the path and the package requested
		$lastdir = (strstr($path,"/")) ? substr($path,0,strrpos($path,"/")) : "";
		$package = (strstr($path,"/")) ? substr($path,strrpos($path,"/") + 1) : $path;
		//$pkgdir  = (strlen($lastdir) > 0) ? LIB."/".$lastdir : LIB;
		$pkgdir  = (strlen($lastdir) > 0) ? dirname(__FILE__)."/".$lastdir : dirname(__FILE__);

		if( !is_dir($pkgdir) ) { return false; }

		// see if we've already included this file?
		//if( in_array(LIB."/".$path, get_included_files()) ) { return false; }
		if( in_array(dirname(__FILE__)."/".$path, get_included_files()) ) { return false; }
	    
		// we have a dir... include the package(s)
		if( $package == "*" )
		{
			// we want ALL the packages within this directory
			// read the dir and loop it
			if( !($dh = opendir($pkgdir)) ) { return false; }
			while( $file = readdir($dh) )
			{
				if( ($file==".") || ($file=="..") )  { continue; }
				elseif( substr($file,-4) == ".php" ) { require_once($pkgdir."/".$file); }
			}
		}
		//else { if( file_exists(LIB."/".$path.".php") ) { require_once(LIB."/".$path.".php"); } }
		else { if( file_exists(dirname(__FILE__)."/".$path.".php") ) { require_once(dirname(__FILE__)."/".$path.".php"); } }
	}	
}
?>