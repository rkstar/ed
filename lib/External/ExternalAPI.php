<?php
// ExternalAPI.php
//
// written by: David Fudge [rkstar@mac.com]
// created on: Feburary 5, 2013
// updated on: Feburary 5, 2013
//
// This class takes care of all the curl options and setup
// to interact with the external API for our airmiles class.

class ExternalAPI
{
	private $_ch;
	private $_url;
	private $_postvars;

	public function __construct( $url=DEFAULT_API_URL ) { $this->url = $url; }

	public function __set( $name, $value )
	{
		switch( $name )
		{
			case "postvars":
			case "url":
			case "ch":
				$this->_{$name} = $value;
			break;

			case "data":
				$post = array();
				$vars = get_object_vars($value);
				while( list($k,$v) = $vars ) { array_push($post, $k."=".$v); }
				$this->_postvars = join("&",$post);
			break;
		}
	}
	public function __get( $name ) { return (property_exists("AirMiles",$this->_{$name}) ? $this->_{$name} : null; }

	public function exec()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_POST, true);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->postvars);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

		$response = !($r = curl_exec($this->ch))
					? new Object(array("errorcode"=>curl_errno($this->ch), "message"=>curl_error($this->ch)))
					: json_decode($r);

		curl_close($this->ch);
		return $response;
	}
}
?>