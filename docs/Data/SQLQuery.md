# Data.SQLQuery

The `SQLQuery` class extends `Core.Object` and provides an interface to creating a query resource for interacting with data stored in a database.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Data.SQLQuery");
ed::import("Data.SQLResult");

$sqlQuery = new SQLQuery();
$sqlQuery->table = "users";
$sqlQuery->setAuthMethod("firstname", "ed");
$sqlQuery->orderBy = "lastname";
$sqlQuery->direction = "ascend";
if( !($sqlResult = $sqlQuery->select()) )
{
	die("No matching records!.");
}

// we have data!
while( $sqlResult->next() )
{
	print $sqlResult->firstname." ".$sqlResult->lastname."<br />\n";
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
* [**Data.Database**](https://github.com/rkstar/ed/tree/master/docs/Data/Database.md): A low-level class that handles database connections and interactivity.  This class is not accessed directly, but rather via an *SQLQuery* instance
* [**Data.XML**](https://github.com/rkstar/ed/tree/master/docs/Data/XML.md): An extension of PHP's *__SimpleXMLElement__* class

## Properties

#### table
> get or set the database table for this query

#### fields
> get or set the fields you wish to use in this query

#### direction
> get or set the direction ording of the results (`ascend` or `descend`)

#### orderBy
> get or set the field(s) to order results by

#### groupBy
> get or set the field(s) to group results by

#### limit
> get or set the limit for results

#### query
> get the last query that was run on this instance

#### errorInfo
> get the PDO errorInfo object for the last query run on this instance

## Functions

#### setAuthMethod( field, value [, operator, linkage] )
> Sets a *where* condition for the query.  Field and value are required and map directly to the table being acted on.  Operator and linkage are optional.
```
field : field in the database table to act on
value : value that the field must contain
operator : =, !=, >, <, >=, <=, like, not like (default: =)
linkage : and, or (default: and)
```
The value field is automatically quoted before it is used in a `where` clause.  This means that double quotes `" "` are placed around whatever the value is of that variable or string.  You can override the quoting feature by using slashes `/` around the variable or string passed in as the `value`.
```php
$sql->setAuthMethod("password", "/PASSWORD('".$my_new_password."')/");
```

#### addToAuthMethod( objectOrArray )
> Allows you to add multiple field/value pairs to the auth method at once.  These must be either a hash array or an object of field => value pairs.  This is the equivalent of writing multiple lines of `setAuthMethod` calls.
>*__NOTE__* This function does not support non-default operators or linkage to `setAuthMethod`

#### clearAuthMethod()
> Clears all auth methods previous set up in the SQLQuery instance.

#### openAuthGroup( [linkage] )
> Starts an "auth group" to which subsequent `setAuthMethod` calls will be added.  The `linkage` parameter defines which "glue" should be used when working in conjunction with other auth methods in the same query.  Accepted `linkage`: *(and | or)*.  This function must always close your auth group with `closeAuthGroup`.
```php
$sql = new SQLQuery();
$sql->table = "users";
$sql->setAuthMethod("firstname", "ed");
$sql->openAuthGroup("and")
	$sql->setAuthMethod("email", "ed@johnny.com");
	$sql->setAuthMethod("address", "123 Fake St.", "or");
	$sql->setAuthMethod("city", "Miami", "or");
$sql->closeAuthGroup();
$result = $sql->select();

...
```

#### closeAuthGroup()
> Closes an auth group

#### clearAuthGroups()
> Clears all auth groups

#### setValue( field, value )
> Sets the value of a field for a pending update or insert call.
```
field : field in the database table to act on
value : value that the field will contain after a successful action
```
The value field is automatically quoted before it is used in a `where` clause.  This means that double quotes `" "` are placed around whatever the value is of that variable or string.  You can override the quoting feature by using slashes `/` around the variable or string passed in as the `value`.
```php
$sql->setValue("password", "/PASSWORD('".$my_new_password."')/");
```
*__NOTE__* Fields specified that do not exist in the table being acted on will be ignored.

#### getValue( field )
> Returns the value being set for the field supplied.  This will probably never get used.

#### setValues( objectOrArray )
> Allows you to add multiple field/value pairs to the values for an update or insert call at once.  These must be either a hash array or an object of field => value pairs.  This is the equivalent of writing multiple lines of `setValue` calls.

#### addToValues( objectOrArray )
> Alias to `setValues`.

#### getValues()
> Returns a hash array of current field => value pairs.  This will probably never get used.

#### rawQuery( query )
> Run a raw SQL query on the currently connected database.
> Returns an [**SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object containing the results of the query.

#### raw( query )
> Alias to `rawQuery`.

#### select()
> Returns an [**SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object containing the results of the query or `false` on error or if there are no matching records.

#### update()
> Returns [**SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) or `false` based on the result of the query.  On error, the `errorInfo` attribute will contain [**PDO errorInfo**](http://www.php.net/manual/en/pdostatement.errorinfo.php).

#### insert()
> Returns [**SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) or `false` based on the result of the query.  If an auto_increment field is present on the table, and the insert was successful, the [**PDO::lastInsertId**](http://www.php.net/manual/en/pdo.lastinsertid.php) will be returned.

#### replace()
> Returns [**SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) or `false` based on the result of the query.  On error, the `errorInfo` attribute will contain [**PDO errorInfo**](http://www.php.net/manual/en/pdostatement.errorinfo.php).

#### delete()
> Returns [**SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) or `false` based on the result of the query.  On error, the `errorInfo` attribute will contain [**PDO errorInfo**](http://www.php.net/manual/en/pdostatement.errorinfo.php).

#### ascending()
> Set the direction for ordering results to `ASCEND`

#### ascend()
> Alias to `ascending()`

#### descending()
> Set the direction for ordering results to `DESCEND`

#### descend()
> Alias to `descending()`

#### reset()
> Clears all auth methods, auth groups, and values in this instance.

#### autoUpdate()
> Looks for two defines `LASTMODIFIED` and `IPADDRESS` which define the names of table fields which will contain that data.  If found, this function automatically adds values for these fields and sets the values to `now()` and `getenv("REMOTE_ADDR")` respectively.  This function is called for you automatically on `update` and `insert` calls.