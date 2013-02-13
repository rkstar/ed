# External.ExternalInterface

The `ExternalInterface` class provides an easy-to-use interface to PHP's `curl` functionality.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("External.ExternalInterface");

$ei = new ExternalInterface("http://myexternalapi.com/curl_me_here");
$ei->postdata = array(
	"firstname" => "ed",
	"lastname"  => "thehorse"
);
$response = $ei->execute();
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)
* [Functions](#functions)

## Dependencies

* [**Core.Object**](https://github.com/rkstar/ed/tree/master/docs/Core/Object.md): An extension of PHP's *__stdClass__*

## Properties

#### url
> The url to send cURL requests to.

#### options
> An array of cURL options to be set when executing.

#### postdata
> A hash of properties and values to be sent to the server via the cURL request.

## Functions

#### execute()
> Returns an Object.  Sends the cURL request to the server and parses the response.