# Utils.Canada

The `Canada` class is a simple class that only contains arrays for Canadian province codes and names.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Utils.Canada");

$codes = Canada::codes;
$names = Canada::names;
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)

## Dependencies

* *none*

## Properties

#### [static] codes
> An array of Canadian province codes.

#### [static] names
> An array of Canadian province names.