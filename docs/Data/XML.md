# Data.XML

The `XML` class extends PHP's `SimpleXMLElement` class.  It adds a few handy functions that are not found in the base PHP class.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Data.XML");

header("Content-type: text/xml");

$xml = new XML("<response>");
$xml->addChild("name", "ed");
$xml->addCDATA("code", "this is some kinda code that is inside cdata tags! woot.");

$xml->finish();

// will die() with:
// <response>
//	<name>ed</name>
//	<code><![CDATA[this is some kinda code that is inside cdata tags! woot.]]></code>
// </response>
```

## Documentation Index

* [Dependencies](#dependencies)
* [Functions](#functions)

## Dependencies

* [**SimpleXMLElement**](http://php.net/simplexmlelement)

## Functions

#### append( element )
> Appends a complete node to the parent.  Nested elements inside the supplied element will be added.

#### addCDATA( name, value )
> Creates a new node using the parent's `addChild` function, but wraps the `value` parameter in a `<![CDATA[]]>` tag.

#### finish( [return] )
> Runs parent's `asXML` function and returns the value (if `return` is true) or `die()` printing XML to screen/output.  `return` is false by default.