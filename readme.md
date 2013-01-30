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

### ed's Modules

* [**Marionette.Application**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.application.md): An application object that starts your app via initializers, and more
* [**Marionette.AppRouter**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.approuter.md): Reduce your routers to nothing more than configuration
* [**Marionette.Callbacks**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.callbacks.md): Manage a collection of callback methods, and execute them as needed
* [**Marionette.CollectionView**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.collectionview.md): A view that iterates over a collection, and renders individual `ItemView` instances for each model
* [**Marionette.Commands**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.commands.md): An extension of Backbone.Wreqr.Commands, a simple command execution framework
* [**Marionette.CompositeView**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.compositeview.md): A collection view and item view, for rendering leaf-branch/composite model hierarchies
* [**Marionette.Controller**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.controller.md): A general purpose object for controlling modules, routers, view, and implementing a mediator pattern
* [**Marionette.functions**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.functions.md): A suite of helper functions and utilities for implementing common Marionette behavior in your objects
* [**Marionette.ItemView**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.itemview.md): A view that renders a single item
* [**Marionette.Layout**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.layout.md): A view that renders a layout and creates region managers to manage areas within it
* [**Marionette.Module**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.application.module.md): Create modules and sub-modules within the application
* [**Marionette.Region**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.region.md): Manage visual regions of your application, including display and removal of content
* [**Marionette.Renderer**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.renderer.md): Render templates with or without data, in a consistent and common manner
* [**Marionette.RequestResponse**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.requestresponse.md): An extension of Backbone.Wreqr.RequestResponse, a simple request/response framework
* [**Marionette.TemplateCache**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.templatecache.md): Cache templates that are stored in `<script>` blocks, for faster subsequent access
* [**Marionette.View**](https://github.com/marionettejs/backbone.marionette/blob/master/docs/marionette.view.md): The base View type that other Marionette views extend from (not intended to be used directly)