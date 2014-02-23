<?php
// PSIGate payment gateway configuration
//
// store id :: YOU NEED TO CHANGE THIS TO YOUR PSIGATE STORE ID
define("STOREID",		"teststore");
// passphrase :: YOU NEED TO CHANGE THIS TO YOUR PSIGATE PASSPHRASE
define("PASSPHRASE",	"psigate1234");
// payment gateway
//define("PSIGGATEAY",	"");
// dev gateway
define("GATEWAY",		"https://dev.psigate.com:7989/Messenger/XMLMessenger");

//
// DO NOT MODIFY! ...
// the defines below are codes for PaymentType and CardAction variables
// which need to get sent to PSIGate
//
// PaymenType
define("CC",	"CC");
//
// CardAction
define("SALE",		0);		// sale
define("PREAUTH",	1);		// pre-auth
define("POSTAUTH",	2);		// post-auth
define("CREDIT",	3);		// refund/credit
define("FORCED",	4);		// forced post-auth
define("VOID",		9);		// void
?>