<?php
// EXcel.php
//
// written by: David Fudge [rkstar@mac.com]
// created on: February 13, 2013
// updated on: Feburary 13, 2013
//
// this class extends PHPExcel and basically provides a simpler interface
// for creating excel sheets.  i have created this class to work with PHPExcel
// more in the style of the ed library and conventions.
//
// it is NOT NECESSARY to use this class in order to use PHPExcel with ed.  you
// are free to import PHPExcel like below to interact with it directly.
//
ed::import("Core.Object");
ed::import("Core.Utils");
ed::import("ThirdParty.PHPExcel");

class Excel extends PHPExcel
{
	private $_columns;
	private $_rows = 0;
	private $_map;

	public function __construct()
	{
		// init the map so that we can keep track of column numbers to
		// column heading keys
		$this->_map = new Object();

		// run the parent constructor
		parent::__construct();

		$this->sheet = 0;
	}

	public function __get( $name )
	{
		switch( strtolower($name) )
		{
			case "activesheet":
			case "sheet":
				return $this->getActiveSheet();
			break;

			case "columns":
				return $this->_columns;
			break;

			case "properties":
				return $this->getProperties();
			break;

			case "rows":
				return $this->_rows;
			break;

			case "security":
				return $this->getSecurity();
			break;

			case "sheets":
				return $this->getSheetCount();
			break;
		}
	}

	public function __set( $name, $value )
	{
		switch( strtolower($name) )
		{
			// OOPS! no such thing...
			//
			// case "author":
			// 	$this->setAuthor($value);
			// break;

			case "category":
				$this->getProperties()->setCategory($value);
			break;

			// in order to set the column titles for this sheet,
			// you will need to pass in either a hash or an object
			// with keys mapped to column heading titles
			// eg.
			//
			// $cols->firstname = "First Name";
			// $cols->lastname  = "Last Name";
			//
			// OR
			//
			// array(
			//    "firstname" => "First Name",
			//    "lastname"  => "Last Name"
			// );
			// { firstname:"First Name", lastname:"Last Name" }
			case "columns":
				if( !is_array($value) && !is_object($value) ) { return; }
				$this->_columns = array();

				$vars = (is_object($value)) ? get_object_vars($value) : $value;
				while( list($k,$v) = each($vars) )
				{
					$o = new Object(array(
						"key"	=> $k,
						"title"	=> $v
					));
					array_push($this->_columns, $o);
				}
			break;

			case "description":
				$this->getProperties()->setDescription($value);
			break;

			case "keywords":
				$this->getProperties()->setKeywords($value);
			break;

			case "modifiedby":
			case "modified_by":
			case "mod_author":
				$this->getProperties()->setLastModifiedBy($value);
			break;

			case "sheet":
			case "active_sheet":
			case "activesheet":
			case "activesheetindex":
				$this->setActiveSheetIndex($value);
			break;

			case "subject":
				$this->getProperties()->setSubject($value);
			break;

			case "title":
				$this->getProperties()->setTitle($value);
			break;
		}
	}

	// take in an object or hash array and iterate through it
	// to set data on the row
	public function add( $data )
	{
		if( !is_object($data) || !is_array($data) ) { return false; }

		// get a reference to the active spreadsheet
		$sheet = $this->getActiveSheet();
		$alpha = Utils::alphabet;

		// check to see if we have already added the column headings to
		// this spreadsheet or not
		if( $this->_rows < 1 )
		{
			$this->_rows++;
			for( $i=0; $i<count($this->_columns); $i++ )
			{
				// map our headers to column fields (a1, b1, etc...)
				$this->_columns[$i]->letter = strtoupper($alpha[$i]);
				$this->_map->{$this->_columns[$i]->key} = $this->_columns[$i]->letter;
				// add the column contents to the active sheet
				$sheet->setCellValue($this->_columns[$i]->letter.$this->_rows, $this->_columns[$i]->title);
			}
		}

		// increment the row counter and add our data!
		$this->_rows++;
		$data = (is_object($data)) ? get_object_vars($data) : $data;
		while( list($k,$v) = each($data) )
		{
			$column_letter = (is_object($this->_map)) ? $this->_map->{$k} : strtoupper(array_shift($alpha));
			$sheet->setCellValue( $column_letter.$this->_rows, $v );
		}
	}

	// write out the excel sheet
	public function save( $filepath="report.xlsx",  $download=true, $type="Excel2007" )
	{
		if( $download && !headers_sent() )
		{
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.substr($filepath,strrpos($filepath,"/")).'"');
			header('Cache-Control: max-age=0');
		}
		elseif( !$download && !is_writeable(APPDIR) ) { return false; }

		$writer = PHPExcel_IOFactory::createWriter($this, $type);
		$path = ($download) ? "php://output" : APPDIR."/".$filepath;
		$writer->save($path);

		return true;
	}
}
?>