# Core.Utils

The `Utils` class provides a list of utility functions for validation and other commonly used routines by web developers.  All functions in this class are static.  This class is a dependency for several other modules.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("Core.Utils");

$email = "linus@php.net";
if( Utils::validEmail($email) )
{
	print "woot! php rocks, bro.";
}
```

## Documentation Index

* [Dependencies](#dependencies)
* [Functions](#functions)

## Dependencies

* *none*

## Functions

#### [static] getCountryCodes()
Returns an array of country codes.

#### [static] getCountryNames()
Returns an array of country names.

#### [static] getCountryHash()
Returns a hash array of country names keyed on country code.

#### [static] getUSAStateCodes()
Returns an array of USA state codes.

#### [static] getUSAStateNames()
Returns an array of USA state names.

#### [static] getUSAStateHash()
Returns a hash array of USA state names keyed on state code.

#### [static] getCAProviceCodes()
Returns an array of Canadian province codes.

#### [static] getCAProvinceNames()
Returns an array of Canadian province names.

#### [static] getCAProvinceHash()
Returns a hash array of Canadian province names keyed on province code.

#### [static] validEmail( email )
Returns `true` or `false`.  Validates formatting of supplied email address.

#### [static] validPhone( phone )
Returns `true` or `false`.  Validates formatting of supplied phone number.  Acceptable formats include any combination of the following:
	(555) 867-5309
	555 867 5309
	555.867.5309

#### [static] validPostalCode( postalCode )
Returns `true` or `false`.  Validates formatting of supplied Canadian postal code.  Acceptable formats include:
	h0h 0h0
	h0h0h0

#### [static] validSIN( sin )
Returns `true` or `false`.  Validates formatting of supplied Canadian Social Insurance Number.  Acceptable formats include:
	999-223-223
	999 223 223
	999223223

#### [static] validAlphanumeric( string )
Returns `true` or `false`.  Validates that the supplied string only contains letters and numbers.

#### [static] random( [length, type] )
Returns a string generated with random characters as delimited by parameters passed in.
	parameters:
		length : The length of random string to be generated (default: 8).
		type   : The type of string to be generated. Available types: "alphanumeric", "numeric", "alpha" (default: "alphanumeric").

#### [static] randomPassword( [length, type] )
Alias to `Utils::random()`.

#### [static] ls( directory )
Returns an array of files in the supplied directory.  This function ignores nested directories.

#### [static] listFilesInDirectory( directory )
Alias to `Utils::ls()`.

#### [static] forceDownload( filepath )
Writes appropriate headers and starts forced download of file at supplied filepath.

#### [static] createImageResource( filepath )
Returns a GD image resource created from the supplied filepath.

#### [static] createImage( imageResource, filepath )
Creates a new image from the supplied image resource and saves it to the supplied filepath.

#### [static] resizeImage( filepath, width, height [, keepAspectRatio] )
Resizes the image at the supplied filepath to supplied width and height parameters.  If the optional keepAspectRatio is true, the aspect ratio will be preserved within the width and height specified. otherwise width and height will be treated as absolute (default: true).