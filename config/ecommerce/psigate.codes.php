<?
// included here are defines for all PSIGate response codes so that we do not
// can easily update them without having to change the guts of the API at
// a later date for small changes in the ate communication spec.
//
// these defines map to XML elements returned by the PSIGate system
//
// see the XML Messenger v1.092.doc file for explanations

define("TRANSACTIONTIME",	"TransTime");
define("ORDERID",			"OrderID");
define("APPROVED",			"Approved");
define("RETURNCODE",		"ReturnCode");
define("ERRORMESSAGE",		"ErrMsg");
define("TAXTOTAL",			"TaxTotal");
define("SHIPTOTAL",			"ShipTotal");
define("SUBTOTAL",			"SubTotal");
define("TOTAL",				"FullTotal");
define("PAYMENTTYPE",		"PaymentType");
define("CARDNUMBER",		"CardNumber");
define("CARDEXPMONTH",		"CardExpMonth");
define("CARDEXPYEAR",		"CardExpYear");
define("TRANSREFNUMBER",	"TransRefNumber");
define("CARDIDRESULT",		"CardIDResult");
define("AVSRESULT",			"AVSResult");
define("CARDAUTHNUMBER",	"CardAuthNumber");
define("CARDREFNUMBER",		"CardRefNumber");
define("CARDTYPE",			"CardType");
define("IPRESULT",			"IPResult");
define("IPCOUNTRY",			"IPCountry");
define("IPREGION",			"IPRegion");
define("IPCITY",			"IPCity");
?>