<?
// Authorize.NET configuration information
//
// login id :: YOU NEED TO CHANGE THIS TO YOUR AUTHORIZE.NET LOGIN ID
define("LOGINID",			"login_id");
// transaction key :: YOU NEED TO CHANGE THIS TO YOUR AUTHORIZE.NET TRANSACTION KEY
define("TXNKEY",			"transaction_key");

// payment getway
//define("ADNGATEWAY",	"https://secure.authorize.net/gateway/transact.dll");
// dev gateway
define("GATEWAY",			"https://dev.authorize.net/gateway/transact.dll");
// response delimiter character --
// all responses from the Authorize.NET gateway will be separated by this character
define("DELIMCHAR",			"|");
// merchant email address
define("MERCHANTEMAIL",		"me@you.com");
// Authorize.NET API version
define("VERSION",			"3.1");
?>