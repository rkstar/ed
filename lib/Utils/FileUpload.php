<?
// FileUpload.php
// written by: David Fudge [ rkstar@mac.com ]
// created on: November 6, 2008
// last modified: November 6, 2008
//
// description:
// this library is supposed to make AJAX file uploading simpler for
// those that wish to do so without having ot know all kinds of ins and outs
// of iframes and progress bars and stuff like that.

class FileUpload
{
	private $systemDir;			// full system path to the upload dir
	private $storageDir;		// relative path to the upload dir
	private $tmpDir;			// tmp upload dir.  defaults to "/tmp"
	private $file;				// $_FILES["thefile"]

	public function __construct()
	{
		global $_FILES;
		// set the file var
		$this->file   = $_FILES["fileUpload"];
		// set the tmp dir by default
		$this->tmpDir = "/tmp";
	}
	
	public function setSystemDir( $path ) { $this->systemDir = $path; }
	public function setStorageDir( $dir ) { $this->storageDir = $dir; }
	
	// this will test the permissions on the system upload dir
	// to make sure that we are able to write to it
	private function testSystemDir()
	{
		$tmpFile = $this->systemDir."/".md5(rand())."tmp";
		// try to open the tmp file for writing
		if( !($fp = fopen($tmpFile,"w")) ) { return false; }
		// it works! continue...
		fclose($fp);
		unlink($tmpFile);
		return true;
	}
}
?>