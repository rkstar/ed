<?php
// Utils.php
// written by: David Fudge [ rkstar@mac.com ]
// created on: November 2, 2008
// last modified: June 3, 2009
//
// description:
// this class is meant to be used statically.  it houses a bunch of useful
// every day functions that can be called at any time by any application.

class Utils
{
	public static $alphabet = array(
		"a","b","c","d","e","f","g","h","i","j","k","l","m",
		"n","o","p","q","r","s","t","u","v","w","x","y","z"
	);
	
	public static $numbers  = array(0,1,2,3,4,5,6,7,8,9);



	// get a list of country codes
	public static function getCountryCodes()
	{
		ed::import("Utils.Countries");
		return Countries::codes;
	}
	
	// get a list of country names
	public static function getCountryNames()
	{
		ed::import("Utils.Countries");
		return Countries::names;
	}
	
	// get a hash of country code=>name
	public static function getCountryHash()
	{
		ed::import("Utils.Countries");
		return array_combine(Countries::codes, Countries::names);
	}
	
	// get a list of US state codes
	public static function getUSAStateCodes()
	{
		ed::import("Utils.USA");
		return USA::codes;
	}
	
	// get a list of US state names
	public static function getUSAStateNames()
	{
		ed::import("Utils.USA");
		return USA::names;
	}
	
	// get a has of US state code=>name
	public static function getUSAStateHash()
	{
		ed::import("Utils.USA");
		return array_combine(USA::codes, USA::names);
	}
	
	// get a list of Canadian province codes
	public static function getCAProvinceCodes()
	{
		ed::import("Utils.Canada");
		return Canada::codes;
	}
	
	// get a list of Canadian province names
	public static function getCAProvinceNames()
	{
		ed::import("Utils.Canada");
		return Canada::names;
	}
	
	// get a hash of Canadian province code=>name
	public static function getCAProvinceHash()
	{
		ed::import("Utils.Canada");
		return array_combine(Canada::codes, Canada::names);
	}
	
	// validate an email address
	public static function validEmail( $email )
	{
		// check length
		if( strlen($email) < 5 ) { return false; }
		
		$at_symbol_check = "/^[^@]{1,64}@[^@]{1,255}$/";
		$parts_check     = "/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/";
		$ip_check        = "/^\[?[0-9\.]+\]?$/";
		$domain_check    = "/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/";

		// check to make sure there is only one @ symbol ... and there is one at all
//		if( !ereg($at_symbol_check, $email) ) { return false; }
		if( !preg_match($at_symbol_check, $email) ) { return false; }
		
		// split it into sections to make validation easier
		$email_array = explode("@",$email);
		$local_array = explode(".",$email_array[0]);
		// loop the parts
//		for( $i=0; $i<count($local_array); $i++ ) { if( !ereg($parts_check, $local_array[$i]) ) { return false; } }
		for( $i=0; $i<count($local_array); $i++ ) { if( !preg_match($parts_check, $local_array[$i]) ) { return false; } }
		
		// check to see if this is an ip address
//		if( !ereg($ip_check, $email_array[1]) )
		if( !preg_match($ip_check, $email_array[1]) )
		{
			$domain_array = explode(".",$email_array[1]);
			if( count($domain_array) < 2 ) { return false; }
			// loop domain array 
//			for( $i=0; $i<count($domain_array); $i++ ) { if( !ereg($domain_check, $domain_array[$i]) ) { return false; } }
			for( $i=0; $i<count($domain_array); $i++ ) { if( !preg_match($domain_check, $domain_array[$i]) ) { return false; } }
		}
		
		return true;
	}
	
	// validate a phone number
	public static function validPhone( $phone )
	{
		// sanity
		if( strlen($phone) < 1 ) { return false; }
		
		$phone_check = "/^([2-9][0-9]{2})([2-9][0-9]{2})([0-9]{4})$/";
		// check the phone
//		if( !ereg($phone_check, trim($phone)) )
		if( !preg_match($phone_check, trim($phone)) )
		{
			// check format
			if( preg_match("/[^0-9\(\)\-\. ]/", $phone) ) { return false; }
		}
		
		// make sure brackets are balanced
		if( substr_count($phone,"(") != substr_count($phone,")") ) { return false; }
		
		return true;
	}
	
	// validate a canadian postal code
	public static function validPostalCode( $postal_code )
	{
		// strip spaces
		$pc = str_replace(" ","",$postal_code);
		// loop each character and check the type
		for( $i=0; $i<strlen($pc); $i++ )
		{
			if( $i % 2 ) { if( !is_numeric($pc[$i]) ) { return false; } }
			else { if( !self::validAlpha($pc[$i]) ) { return false; } }
		}
		
		return true;
	}
	
	// validate a Canadian Social Insurance Number
	public static function validSIN( $sin )
	{
		// format it without spaces or extra chars
		$sin = str_replace(" ","",$sin);
		$sin = str_replace("-","",$sin);
		$sin = str_replace(".","",$sin);
		$sin = (int)$sin;
		// sanity
		if( strlen($sin) != 9 ) { return false; }
		
		// intense checksum math...
		$chk = 121212121;
		// loop each number in the sin to do the match against our checksum
		$checksum = 0;
		for( $i=0; $i<strlen($sin); $i++ )
		{
			// multiply each position number in the SIN by the position in the chk number
			$num = ((int)substr($sin,$i,1) * (int)substr($chk,$i,1));
			if( strlen($num) > 1)
			{
				// we have to add together the digits of $num to get a number < 10
				$jnum = 0;
				for( $j=0; $j<strlen($num); $j++ ) { $jnum = ($jnum + (int)substr($num,$j,1)); }
				$num = $jnum;
			}
			$checksum = $checksum + $num;
		}
		
		// a valid sin checksum will be evenly divisible by 10
		return ($checksum % 10) ? false : true;
	}
	
	// validate an alpha-numeric
	public static function validAlphaNumeric( $string )
	{
		$alphanum_check = "/^[-a-z0-9.,\'\s]+$/i";
		// check it
		if( !preg_match($alphanum_check, $string) ) { return false; }
		
		return true;
	}
	
	// remove non-alphanumeric chars from a string
	public static function sanitizeAlphaNumeric( $string, $removeSpaces=true )
	{
		return ($removeSpaces) ? preg_replace("/[^_a-zA-Z 0-9\-\.]/","",$string) : preg_replace("/[^_a-zA-Z0-9\-\.]/","",$string);
	}
	
	// generate a random password
	public static function randomPassword( $type="alphanumeric", $length=8 )
	{
		// generate a password based on the type
		switch( $type )
		{
			case "alphanumeric":
			default:
				$available = array_merge(self::$numbers,self::$alphabet);
			break;
			
			case "numeric":
				$available = self::$numbers;
			break;
			
			case "alpha":
				$available = self::$alphabet;
			break;
		}
		
		// for the length specified, generate a password
		$password = "";
		for( $i=0; $i<$length; $i++ ) { $password .= $available[rand(0,count($available)-1)]; }
		
		return $password;
	}
	// easier to use and backward compatible...
	public static function random( $length=8, $type="alphanumeric" )
	{
		return self::randomPassword($type,$length);
	}
	
	// list files in a directory (does NOT traverse subdirs)
	public static function ls( $dir )
	{
		// sanity
		if( strlen($dir) < 1 ) { return false; }
		if( substr($dir,-1) != "/" ) { $dir .= "/"; }
		
		// set up an array for our list
		$list = array();
		// open the dir and read the file list
		$dh = opendir($dir);
		while( ($file = readdir($dh)) )
		{
			$fullpath = $dir.$file;
			if( ($file != ".") && ($file != "..") && !is_dir($fullpath) ) { array_push($list,$file); }
		}
		closedir($dh);
		
		return $list;
	}
	public static function listFilesInDirectory( $dir ) { return Utils::ls($dir); }
	
	// force the download of a file
	public static function forceDownload( $path )
	{
		// sanity
		if( headers_sent() ) { return false; }
		// we can't send a file if the headers have already been sent...
		
		// get the file extension
		$ext = substr($path,strrpos($path,".") + 1);
		// set the header info
		switch( strtolower($ext) )
		{
			case "pdf":		$type = "application/pdf";					break;
			case "exe":		$type = "application/octect-stream";		break;
			case "zip":		$type = "application/zip";					break;
			case "doc":		$type = "application/msword";				break;
			case "xls":		$type = "application/vnd.ms.excel";			break;
			case "ppt":		$type = "application/vnd.ms.powerpoint";	break;
			case "bmp":		$type = "image/bmp";						break;
			case "gif":		$type = "image/gif";						break;
			case "png":		$type = "image/png";						break;
			case "jpg":
			case "jpeg":	$type = "image/jpg";						break;
			default:		$type = "application/force-download";		break;
		}
		
		// set the headers
		header("Pragma: public");	// required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-control: private", false);	// required for certain browsers
		header("Content-Type: ".$type);
		// change, added quotes to allow speces in filenames...
		header("Content-Disposition: attachment; filename=\"".basename($path)."\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($path));
		// read in the file in binary mode and tehn send it
		// we're working with IE and trying to download a PDF
		if( ($fp = fopen($path,"rb")) )
		{
			// read the file in binary mode
			while( !feof($fp) ) { print fread($fp,1024); ob_flush(); }
			fclose($fp);
			exit();		// IE requires we do this...
		}
	}
	
	// create an image resource by using the appropriate GD function
	function createImageResource( $filepath )
	{
		// get the file extension
		$ext = strtolower(substr($filepath,strrpos($filepath,".")+1));
		switch( $ext )
		{
			case "jpg":
			case "Jpeg":	$image = imagecreatefromjpeg($filepath);	self::trace("jpeg: ".$image); break;
			case "gif":		$image = imagecreatefromgif($filepath);		self::trace("gif: ".$image); break;
			case "png":		$image = imagecreatefrompng($filepath);		self::trace("png: ".$image); break;
			case "bmp":		$image = imagecreatefromwbmp($filepath);	self::trace("bmp: ".$image); break;
		}
		return $image;
	}
	// write out the new image to the filepath
	function createImage( $image, $filepath )
	{
		// get the file extension
		$ext = strtolower(substr($filepath,strrpos($filepath,".")+1));
		switch( $ext )
		{
			case "jpg":
			case "Jpeg":	imagejpeg($image,$filepath);	break;
			case "gif":		imagegif($image,$filepath);		break;
			case "png":		imagepng($image,$filepath);		break;
			case "bmp":		imagewbmp($image,$filepath);	break;
		}
		imagedestroy($image);
	}
	
	// resize an image to the given width and height
	function resizeImage( $filepath, $width, $height, $keepAspectRatio=true )
	{
		$directory = substr($filepath, 0, strrpos($filepath, "/"));
		$filename  = substr($filepath, strrpos($filepath, "/")+1);
		// check dimensions
		list($w, $h) = getimagesize($filepath);
		
		if( $keepAspectRatio )
		{
			$scalex = ($width / $w);
			$scaley = ($height / $h);
			$scale  = ($scalex < $scaley) ? $scalex : $scaley;
			
			$newWidth  = $w * $scale;
			$newHeight = $h * $scale;
		}
		else
		{
			$newWidth  = $width;
			$newHeight = $height;
		}
		
		$sourceResource = self::createImageResource($filepath);
		$imageResource  = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($imageResource, $sourceResource, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);
		
		self::createImage($imageResource, $filepath);
	}
}
?>