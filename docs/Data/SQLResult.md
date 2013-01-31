# Data.SQLResult

The `SQLResult` class extends `Object` and provides an interface for working with record sets resulting from database queries.  This class is used in conjunction with `SQLQuery`, which will import it, so there is no need to import this class directly.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Data.SQLQuery");

$sql = new SQLQuery();
$sql->rawQuery("select * from users");
$result = $sql->select();

while( $result->next() )
{
	print $result->firstname." ".$result->lastname."<br />\n";
}

// prints:
// ed mcmahon
// ed thesock
// ed thehorse
// ed mirvish
// ed templeton
// ed hardy
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)
* [Functions](#functions)

## Dependencies

* [**Core.Object**](https://github.com/rkstar/ed/tree/master/docs/Core/Object.md): An extension of PHP's *__stdClass__*

## Properties

#### query
> The raw SQL that created this result set.

#### numrows
> The number of affected rows or records returned.

#### rowcount
> Alias to `numrows`.

#### affectedrows
> Alias to `numrows`.

#### insertid
> [**PDO::lastInsertId**](http://www.php.net/manual/en/pdo.lastinsertid.php)

#### lastinsertid
> Alias to `insertid`

## Functions

#### next()
> Returns (and sets) the public data of this instance to the fields and values of the *next* record in our recordset.  Record set field names will be accessible as object variables and will return the values of those fields in the current record.  This function will return `null` when it has reached the end of the recordset.

#### getData( field )
> Returns the field value from the current record.  This is only necessary when a field in a record is named the same as one of this class' internal attributes.  In my experience, this occurrence is rare.