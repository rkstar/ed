# Utils.Countries

The `Countries` class is a simple class that only contains arrays for Country codes and names.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Utils.Countries");

$codes = Countries::codes;
$names = Countries::names;
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)

## Dependencies

* *none*

## Properties

#### [static] codes
> An array of Country codes.

#### [static] names
> An array of Country names.