<?
// PayPal configuration information
//
// define the PayPal information we'll need for submission of the form and
// specific URLs and email data needed by PayPal

// form id for submission
define("PAYPAL_FORMID",	"paypal_form");
// PayPal account email
define("PAYPAL_EMAIL",	"yourpaypalaccount@yourdomain.com");
// successful return URL
define("PAYPAL_RETURNURL",	LINK_URL."/paypal_return.html");
// canceled payment return URL
define("PAYPAL_CANCELURL",	LINK_URL."/paypal_canceled.html");
// PayPal button image URL
define("PAYPAL_BUTTONIMAGE",	LINK_URL."/images/buttons.paypal.gif");
// PayPal button alternate text
define("PAYPAL_BUTTONTEXT",	"Proceed to PayPal");
?>