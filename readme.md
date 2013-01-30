# [ed] Easy Development PHP Library

A lightweight modular PHP library for creating REST APIs and easing your data management woes.

## About '''ed'''

'''''ed''''' is a lightweight PHP library that eases application development by taking care of all of the low-level data management (database integration, common validation routines, XML and JSON responses) for you.  Concentrate on the data-flow of your specific applications and leave the heavy lifting '''(and boring stuff)''' to '''''ed'''''.

### Modular On-Demand Architecture

ed is built as an '''on-demand''' library.  There is very little necessary configuration and only one file to include in your application code.  The config files are loaded along with a tiny static ed class which allows you to load modules as needed in your application.  Modules are loaded on each page or function of your application and you only load the modules that you need at any given time.

### Key Benefits

* Create REST APIs quickly without dealing with database access hassles
* Database interaction is done entirely through PHP DataObjects ''(PDO)''
* Built-in module dependency management ensures you will never get ed library errors
* Useful classes like ''Object'' and ''XML'' extend PHP's default functionality
* Utilities class that includes common use cases and validation for large-scale applications
* Flexibility to use with any MVC-type application architecture or custom REST API
* And much, much more...
