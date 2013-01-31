# Core.Object

The `Object` class extends the basic functionality of PHP's `stdClass` object.  It is used mostly as a parent class to other *ed* modules, but can be instantiated and used for situations like returning JSON data to a client application.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Core.Object");

$object = new Object(array("name"=>"ed"));
print $object->name;  // prints 'ed'

// alternately

$object->lastname = "the enabler.";

print $object->name.", ".$object->lastname;	// prints 'ed, the enabler.'
```

## Documentation Index

* [Dependencies](#dependencies)
* [Functions](#functions)

## Dependencies

* *none*

## Functions

#### __construct( [hash_array] )
Returns an instance of this object class.  Optionally, you can provide a hash array of properties to be added to this object.  Because it automatically extends the `stdClass` object, you also set properties manually on the object instance.

#### json()
Returns a JSON encoded representation of the object instance.

#### jsonize()
Alias to `Object->json()`.