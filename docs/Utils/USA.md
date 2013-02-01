# Utils.USA

The `USA` class is a simple class that only contains arrays for United States state codes and names.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Utils.USA");

$codes = USA::codes;
$names = USA::names;
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)

## Dependencies

* *none*

## Properties

#### [static] codes
> An array of United States state codes.

#### [static] names
> An array of United States state names.