<?php
// ExternalAPI.php
//
// written by: David Fudge [rkstar@mac.com]
// created on: Feburary 5, 2013
// updated on: Feburary 5, 2013
//
// This class takes care of all the curl options and setup
// to interact with the external API for our airmiles class.
ed::import("Core.Object");

class ExternalInterface
{
	public $options;
	public $url;
	public $opts;
	public $postdata;

	public function __construct( $url="", $opts=null )
	{
		$this->url  = $url;
		$this->opts = $opts !== null ? $opts : new stdClass;
	}

	public function exec() { return $this->execute(); }
	public function execute()
	{
		$ch = curl_init();
		// get object vars and loop thru them
		$opts = get_object_vars($this->opts);
		while( list($k,$v) = each($opts) ) { curl_setopt($ch, $k, $v); }
		// set some default curl options
		curl_setopt($ch, CURLOPT_POST, isset($this->opts->CURLOPT_POST) ? $this->opts->CURLOPT_POST : true);
		// static opts
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->postdata));
		// check for user options and set those... they may override what we have just done
		if( is_array($this->options) && (count($this->options) > 0) )
		{
			curl_setopt_array($ch, $this->options);
		}

		$response = !($r = curl_exec($ch))
					? new Object(array("errorcode"=>curl_errno($ch), "message"=>curl_error($ch)))
					: json_decode($r);

		curl_close($ch);
		return $response;
	}
}
?>