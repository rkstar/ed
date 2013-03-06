# [ed] Easy Development PHP Library

A lightweight modular PHP library for creating REST APIs and easing your data management woes.

## About *ed*

*__ed__* is a lightweight PHP library that eases application development by taking care of all of the low-level data management (database integration, common validation routines, XML and JSON responses) for you.  Concentrate on the data-flow of your specific applications and leave the heavy lifting *(and boring stuff)* to *__ed__*.

### Modular On-Demand Architecture

ed is built as an *on-demand* library.  There is very little necessary configuration and only one file to include in your application code.  The config files are loaded along with a tiny static ed class which allows you to load modules as needed in your application.  Modules are loaded on each page or function of your application and you only load the modules that you need at any given time.

### Key Benefits

* Create REST APIs quickly without dealing with database access hassles
* Database interaction is done entirely through PHP DataObjects __(PDO)__
* Built-in module dependency management ensures you will never get ed library errors
* Useful classes like __Object__ and __XML__ extend PHP's default functionality
* Utilities class that includes common use cases and validation for large-scale applications
* Flexibility to use with any MVC-type application architecture or custom REST API
* And much, much more...

## Compatibility and Requirements

*__ed__* works and has been tested on the following software:

* [PHP](http://php.net) >= v5.3
* [Apache](http://apache.org) >= v2.2.6
* [MySQL](http://mysql.com) >= v4.1

*__ed__* relies on PHP DataObjects for database access, so this extension must be enabled in your PHP build.

This library is completely open source and available for use for personal and commercial projects free-of-charge.


## Documentation

The primary documentation is split up in to multiple files, due to the size of the overall documentation.  You can find these files in the [/docs](https://github.com/rkstar/ed/tree/master/docs) folder, or use the links below to get straight to the documentation for each module in *__ed__*.

### Core Modules

* [**ed**](https://github.com/rkstar/ed/tree/master/docs/ed.md): Core Library Class
* [**Core.Form**](https://github.com/rkstar/ed/tree/master/docs/Core/Form.md): Form data handlers and helpers
* [**Core.Object**](https://github.com/rkstar/ed/tree/master/docs/Core/Object.md): An extension of PHP's *__stdClass__*
* [**Core.Utils**](https://github.com/rkstar/ed/tree/master/docs/Core/Utils.md): A static class with lots of validation functions as well as commonly used processes for web development

### Data Modules

* [**Data.Data**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLQuery.md): *__NOTE__* This class has been replaced with `Data.SQLQuery`
* [**Data.Database**](https://github.com/rkstar/ed/tree/master/docs/Data/Database.md): A low-level class that handles database connections and interactivity.  This class is not accessed directly, but rather via an *SQLQuery* instance
* [**Data.SQLQuery**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLQuery.md): The core class you will interact with when using the *ed* database functionality.  You will define your query parameters here and execute functions to return an *SQLResult* object.
* [**Data.SQLResult**](https://github.com/rkstar/ed/tree/master/docs/Data/SQLResult.md): The result object that is returned after a database call using *SQLQuery*
* [**Data.XML**](https://github.com/rkstar/ed/tree/master/docs/Data/XML.md): An extension of PHP's *__SimpleXMLElement__* class

### Ecommerce Modules

* [**Ecommerce.PSIGate**](https://github.com/rkstar/ed/tree/master/docs/Ecommerce/PSIGate.md): PSIGate payment module that provides a succinct interface to PSIGate's payment API

### External Modules

* [**External.ExternalInterface**](https://github.com/rkstar/ed/tree/master/docs/External/ExternalInterface.md): An easy-to-use module that takes care of the headaches associated with [**PHP cURL**](http://php.net/curl) requests.

### Third Party Modules

* [**ThirdParty.Excel**](https://github.com/rkstar/ed/tree/master/docs/ThirdParty/Excel.md): PHPExcel API module
* [**ThirdParty.Mailer**](https://github.com/rkstar/ed/tree/master/docs/ThirdParty/Mailer.md): PHPMailer API module

### Utility Modules

* [**Utils.Canada**](https://github.com/rkstar/ed/tree/master/docs/Utils/Canada.md): Contains arrays of Canadian province and territory codes and names
* [**Utils.Countries**](https://github.com/rkstar/ed/tree/master/docs/Utils/Countries.md): Contains arrays of all country codes and names
* [**Utils.FileUpload**](https://github.com/rkstar/ed/tree/master/docs/Utils/FileUpload.md): Incomplete *__DO NOT USE__*
* [**Utils.USA**](https://github.com/rkstar/ed/tree/master/docs/Utils/USA.md): Contains arrays of USA state codes and names