# Data.Database

The `Database` class extends `Object` and provides an interface to low-level database functionality.  This class is used by both the `SQLQuery` and `SQLResult` classes.  The majority of application interaction with databases should go through `SQLQuery`, so use of this class should be limited at most.

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)
* [Functions](#functions)

## Dependencies

* [**Core.Object**](https://github.com/rkstar/ed/tree/master/docs/Core/Object.md): An extension of PHP's *__stdClass__*
* [**Data.SQLQuery**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLQuery.md): The core class you will interact with when using the *ed* database functionality.  You will define your query parameters here and execute functions to return an *SQLResult* object.
* [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md): The result object that is returned after a database call using *SQLQuery*

## Properties

#### dbhost
> The database host.

#### dbuser
> The database user.

#### dbpass
> The database password.

#### dbname
> The database name.

#### dbtype
> The database type.

#### dsn
> The [**PDO**](http://php.net/pdo) DSN.

#### pdo
> The [**PDO**](http://php.net/pdo) connection object.

#### errorInfo
> The [**PDO errorInfo**](http://www.php.net/manual/en/pdo.errorinfo.php).

## Functions

#### __construct( [dbhost, dbuser, dbpass, dbname, dbtype, dsn] )
> Sets up all the class properties and opens a connection to the database.  All parameters are optional and default to the values defined in the `appconfig.php` file.

#### connect()
> Connects to the database.

#### reconnect()
> Checks for an active connection and re-establishes one if it does not exist.

#### disconnect()
> Disconnects from the database.

#### getTableFieldList( table )
> Returns an array of fields available in the requested table on the connected database.

#### execute( SQLQuery, rawQueryString [, bindParams] )
> Returns an [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object for the query provided.  This function should only be run by internal functions.

#### select( SQLQuery )
> Returns an [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object for the query provided.

#### update( SQLQuery )
> Returns an [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object for the query provided.

#### insert( SQLQuery )
> Returns an [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object for the query provided.

#### replace( SQLQuery )
> Returns an [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md) object for the query provided.

#### delete( SQLQuery )
> Returns `true` or `false`.