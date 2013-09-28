# ed *(core class)*

The `ed` class is the heart of the library.  This is a static class that only has one method: `import`.  This class is included in your `appconfig.php` file and does the rest of the class loading in your application for you.  No more messy lists of `require()` or `include()` calls!

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("ClassContainer.ClassName");
```

## Documentation Index

* [Importing Classes](#importing-classes)
* [Importing Classes Locally](#importing-classes-locally)
* [Importing With Your Own Path](#importing-with-your-own-path)

## Importing Classes

Once you have included (or required) your base ed class, you can use the static `import` method to load any required classes and their associated dependencies.

## Importing Classes Locally

If you'd like to import files from outside of the ed "lib" folder, you can use the `local` method to load any classes and dependencies relative to the file ed was loaded from.

```php
ed::local("ClassContainer.ClassName");
```

## Importing With Your Own Path

If you'd like to import files from another directory, or just prefer to use absolute or actual paths, ed will detect any slashes (/) and will load that path as is. Please note file extensions will be required in this mode.

```php
ed::import("/path/to/class.php");
```

*__NOTE__*
There is a second legacy method in this class called `load` which acts identically to `import`.