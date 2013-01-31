# Core.Form

The `Form` class provides an easy interaction with data submitted to our application.  There are static methods to sanitize submitted data and decode XML and JSON formatted data submitted in the body of HTTP requests.  Use of this class is not mandatory, but handles merging of `$_REQUEST`, `$_GET`, amd `$_POST` global variables as well as `php://input`.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Core.Form");

$formObject = Form::sanitized($_POST);
if( $formObject->posted_id === $_POST["posted_id"] )
{
	print "These are the same!";
}
```

## Documentation Index

* [Dependencies](#dependencies)
* [Functions](#functions)

## Dependencies

* [**Core.Object**](https://github.com/rkstar/ed/tree/master/docs/Core/Object.md): An extension of PHP's *__stdClass__*

## Functions

**raw()**

Returns a hash array of all merged data submission vars: `$_REQUEST`, `$_GET`, amd `$_POST`.


**data()**

Retunrs an object of all merged data and submission vars: `$_REQUEST`, `$_GET`, amd `$_POST`.


**xml()**

Returns a SimpleXML object of XML formatted HTTP request body contents.  This is typically how XML data is sent to PHP APIs.


**json()**

Returns an object of JSON formatted HTTP request body contents.  This is typically how JSON data is sent to PHP APIs.

**sanitized( hash_array )**
Returns an object of provided hash array.  This function will use the `Form::raw()` function to use merged submission data by default.  This function will omit hash elements that are null, zero-length string values, and string values equal to "null".