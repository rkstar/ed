<?php
// create an array of the Authorize.NET response codes based on position
//
// IMPORTANT!!
// the Authorize.NET documenation references "position 1" as the first position... our
// array will obviously start at position 0 (zero).  therefore, Authorize.NET's "position" is
// the array index +1.
//
// response array
$response_codes = array(
			"ResponseCode",				// 1
			"ResponseSubcode",
			"ResponseReasonCode",
			"ResponseReasonText",
			"AuthorizationCode",
			"AVSResponse",
			"TransactionID",			// 7
			"InvoiceNumber",
			"Description",
			"Amount",
			"Method",
			"TransactionType",
			"CustomerID",				// 13
			"FirstName",
			"LastName",
			"Company",
			"Address",
			"City",
			"State",
			"ZIPCode",
			"Country",
			"Phone",
			"Fax",
			"EmailAddress",
			"ShipToFirstName",			// 25
			"ShipToLastName",
			"ShipToCompany",
			"ShipToAddress",
			"ShipToCity",
			"ShipToState",
			"ShipToZIPCode",
			"ShipToCountry",
			"Tax",						// 33
			"Duty",
			"Freight",
			"TaxExempt",
			"PurchaseOrderNumber",
			"MD5Hash",
			"CardCodeResponse",
			"CardholderAuthenticationVerificationResponse"
			);
?>