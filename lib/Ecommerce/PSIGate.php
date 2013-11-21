<?php
// written by: David Fudge [rkstar@mac.com]
// created on: October 6, 2008
// last modified: May 12, 2009
//
// this file contains functions that match the API for other payment
// gateways that i've created to allow us a common interface to each
// gateway regardless of their individual requirements and interface
// procedures.
//
// IMPORTANT!
// three variables will be stored in our config/psigate.php file.
// they are "defines" so that we do not have to worry about using
// the "global" identifier when we're using them inside this class:
//
// STOREID		=> the PSIGate "StoreID"
// PASSPHRASE	=> the PSIGate "Passphrase"
// GATEWAY		=> the url to the payment gateway
//

ed::load("Data.XML");

class PSIGate extends Core
{
	private $order;			// PSIGate order XML object
	private $method;		// PSIGate "PaymentType" <-- always "CC"
	private $type;			// PSIGate "CardAction" always "0" (zero) == SALE
	
	public function __construct()
	{
		parent::__construct();	// DO NOT REMOVE!
		$this->init();
	}
	// initialize all our class vars
	public function init()
	{
		// set up the default vars here
		$this->method = CC;
		$this->type   = SALE;
		$this->order = new XML("<Order />");
		$this->order->addChild("StoreID",STOREID);
		$this->order->addChild("Passphrase",PASSPHRASE);
		$this->order->addChild("PaymentType",$this->method);
		$this->order->addChild("CardAction",$this->type);
		$this->order->addChild("CustomerIP",getenv("REMOTE_ADDR"));
	}
	
	private function addToOrder( $attr, $value )
	{
		if( !isset($this->order->$attr) ) { $this->order->addChild($attr,$value); } else { $this->order->$attr = $value; }
	}
	public function setTransactionType( $type ) { $this->type = $type; }
	public function setPaymentMethod( $method ) { $this->method = $method; }
	public function setCVS( $cvs ) { $this->addToOrder("CardIDNumber", $cvs); }
	public function setCardNumber( $cardnumber ) { $this->addToOrder("CardNumber", $cardnumber); }
	public function setCardExpiry( $cardexpiry )
	{
		$month = substr($cardexpiry,0,2);
		$year  = substr($cardexpiry,-2);
		$this->addToOrder("CardExpMonth", $month);
		$this->addToOrder("CardExpYear", $year);
	}
	public function setComments( $comments ) { $this->addToOrder("Comments", $comments); }
	public function setSubtotal( $total ) { $this->addToOrder("Subtotal", $total); }
	public function setOrderId( $orderId ) { $this->addToOrder("OrderID", $orderId); }
	public function setReferenceId( $refId ) { $this->addToOrder("TransRefNumber", $txnId); }
	public function setBillingData( $object ) { while( list($k,$v) = each($object) ) { $this->addToOrder($k,$v); } }
	public function setBillingName( $name ) { $this->addToOrder("BName", $name); }
	public function setBillingCompany( $company ) { $this->addToOrder("BCompany", $company); }
	public function setBillingAddress( $address ) { $this->addToOrder("Baddress1",$address); }
	public function setBillingCity( $city ) { $this->addToOrder("Bcity",$city); }
	public function setBillingState( $state ) { $this->addToOrder("Bprovince", $state); }
	public function setBillingZip( $zip ) { $this->addToOrder("Bpostalcode", $zip); }
	public function setBillingCountry( $country ) { $this->addToOrder("Bcountry", $country); }
	public function setPhone( $phone ) { $this->addToOrder("Phone", $phone); }
	public function setFax( $fax ) { $this->addToOrder("Fax", $fax); }
	public function setEmail( $email ) { $this->addToOrder("Email", $email); }
	public function addItem( $id, $description, $qty, $price )
	{
		// add an item child to the order
		$item = $this->order->addChild("Item");
		$item->addChild("ItemID",$id);
		$item->addChild("ItemQty",$qty);
		$item->addChild("ItemPrice",$price);
		$item->addChild("ItemDescription",$description);
	}
	
	// authorize the transaction
	public function authorize()
	{
		// set up the cURL options
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, GATEWAY);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->order->asXML());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 240);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// send it
		$response = curl_exec($ch);
		if( curl_errno($ch) != CURLE_OK )
		{
			// log the error...
			$fp = fopen(SYSROOT."/data/psigate.log","a");
			fputs($fp, "[".date("Y-m-d H:i:s")."] ERROR :: ".curl_errno($ch)." ".curl_error($ch)."\n");
			fputs($fp, "[".date("Y-m-d H:i:s")."] GATEWAY :: ".GATEWAY."\n");
			fputs($fp, "[".date("Y-m-d H:i:s")."] ".print_r($response,true)."\n");
			fclose($fp);
			return false;
		}
		
		// sanity
		curl_close($ch);
		// send back an XML response
		return new XML($response);
	}
}
?>