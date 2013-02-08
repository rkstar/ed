<?php
// ExternalAPI.php
//
// written by: David Fudge [rkstar@mac.com]
// created on: Feburary 5, 2013
// updated on: Feburary 5, 2013
//
// This class takes care of all the curl options and setup
// to interact with the external API for our airmiles class.

class ExternalInterface
{
	private $_ch;
	private $_options;
	private $_url;
	private $_postvars;

	public function __construct( $url="" ) { $this->url = $url; }

	public function __set( $name, $value ) { $this->_{$name} = $value; }
	public function __get( $name ) { return (property_exists("ExternalInterface",$this->_{$name})) ? $this->_{$name} : null; }

	public function exec() { return $this->execute(); }
	public function execute()
	{
		$this->ch = curl_init();
		// set some default curl options
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_POST, true);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($this->postvars));
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		// check for user options and set those... they may override what we have just done
		if( is_array($this->options) && (count($this->options) > 0) )
		{
			curl_setopt_array($this->ch, $this->options);
		}

		$response = !($r = curl_exec($this->ch))
					? new Object(array("errorcode"=>curl_errno($this->ch), "message"=>curl_error($this->ch)))
					: json_decode($r);

		curl_close($this->ch);
		return $response;
	}
}
?>