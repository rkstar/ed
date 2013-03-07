# ThirdParty.Excel

The `Excel` class extends `PHPExcel` and provides a simplified wrapper to the complex functions within.  *__NOTE__* It is still possible to use the `PHPExcel` class directly without using this wrapper.

Example code:
```php
require_once(dirname(__FILE__)."/config/appconfig.php");
ed::import("ThirdParty.Excel");

// set up the column headings with a hash
$column_headings = array(
	"firstname"	=> "First Name",
	"lastname"	=> "Last Name",
	"email"		=> "Email"
);

// set up the data array
$data = array(
	array(
		"firstname"	=> "David",
		"lastname"	=> "Fudge",
		"email"		=> "rkstar@mac.com"
	),
	array(
		"firstname" => "Mike",
		"lastname"	=> "Karter",
		"email"		=> "mike@luvsblackberry.com"
	)
);


// create our excel object
$excel = new Excel();
$excel->creator = "David Fudge";
$excel->title   = "my test excel sheet";
$excel->subject = "For useful reporting!  woot.";
$excel->category = "reporting";
$excel->columns = $column_headings;

// loop thru our data array and add each row
for( $i=0;$i<count($data);$i++ )
{
	$excel->add($data[$i]);
}

$excel->save("myreports.xlsx",true);
```

## Documentation Index

* [Dependencies](#dependencies)
* [Properties](#properties)
* [Functions](#functions)

## Dependencies

* [**PHPExcel**](http://phpexcel.codeplex.com/): An open source PHP library to work with Microsoft Excel files
* [**Core.Object**](https://github.com/rkstar/ed/tree/master/docs/Core/Object.md): An extension of PHP's *__stdClass__*

## Properties

#### columns
> get or set the column headings for this worksheet

#### rows
> get the number of rows currently added to this worksheet

#### sheets
> get the number of worksheets in this document

#### category
> set the category for this document

#### description
> set the description for this document

#### keywords
> set the keywords for this document

#### modifiedby
> set the "modified by" author for this document

#### sheet
> get or set the active worksheet index

#### subject
> set the subject for this document

#### title
> set the title for this document


## Functions

#### add( data )
> Adds a row of data to the active worksheet.  This function will automatically add your column headings (if set) when you add the first row of data.  Data passed to this function must be either an `Object` or a hash `Array`.

#### save( filepath [, download, type] )
> Saves the Excel file.  By default, it will save as Excel2007 (.xlsx) and force download of the file.  In order for force-download to work, no header information can be sent to the browser before this function is called.  By setting the `download` options to `false` you can define a filepath relative to your `APPDIR` to save the file to.  **YOU MUST HAVE WRITE PERMISSIONS TO THIS DIRECTORY FOR THIS TO WORK**