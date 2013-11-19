<?
// Mailer.php
// written by: David Fudge [ rkstar@mac.com ]
// created on: November 3, 2008
// last modified: November 17, 2013
//
// description:
// this class extends the wonderful PHPMailer classes that are available
// at http://phpmailer.sourceforge.net
// basically i just wanted an easier way to call them and set some default
// values without having to call it every time

// include the PHPMailer classes
require_once(dirname(__FILE__)."/PHPMailer/class.phpmailer.php");

class Mailer extends PHPMailer
{
/*
 * purely for reference *
 * for the default values, see /config/php/application.php
 *
 *
	private $priority	= 3;
	private $to_addr	= "";
	private $to_name	= "";
	private $from_addr	= "";
	private $from_name	= "";
	private $host		= "";
	private $port		= 25;
	private $smtp_auth	= false;
	private $mailer		= "smtp";
 *
 */
	
	// constructor
	public function __construct()
	{
		// we can set the from address and name and mailer from
		// the vars defined in the ed config files
		$this->Sender   = NOTIFICATION_EMAIL_FROM_ADDRESS;
		$this->From     = NOTIFICATION_EMAIL_FROM_ADDRESS;
		$this->FromName = NOTIFICATION_EMAIL_FROM_NAME;
		$this->Host     = NOTIFICATION_EMAIL_HOST;
		$this->Port     = NOTIFICATION_EMAIL_PORT;
		$this->Priority = NOTIFICATION_EMAIL_PRIORITY;
		$this->AltBody  = NOTIFICATION_EMAIL_ALTBODY;
		// check for SMTP auth
		if( NOTIFICATION_SMTP_AUTH_REQUIRED )
		{
			$this->Username = NOTIFICATION_SMTP_AUTH_USERNAME;
			$this->Password = NOTIFICATION_SMTP_AUTH_PASSWORD;
			$this->SMTPAuth = true;
			$this->IsSMTP();
		}
		else
		{
			$this->SMTPAuth = false;
			$this->IsSendmail();
		}
	}
}
?>