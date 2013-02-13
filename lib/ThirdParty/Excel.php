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
	private $_map;
	private $_rows = 0;

	public function __construct()
	{
		// run the parent constructor
		parent::__construct();
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
				$this->setCategory($value);
			break;

			case "columns":
				if( !is_array($value) ) { return; }
				$this->_columns = $value;
			break;

			case "description":
				$this->setDescription($value);
			break;

			case "keywords":
				$this->setKeywords($value);
			break;

			case "modifiedby":
			case "modified_by":
			case "mod_author":
				$this->setLastModifiedBy($value);
			break;

			case "sheet":
			case "active_sheet":
			case "activesheet":
			case "activesheetindex":
				$this->setActiveSheetIndex($value);
			break;

			case "subject":
				$this->setSubject($value);
			break;

			case "title":
				$this->setTitle($value);
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
				$column = strtoupper($alpha[$i]).($this->_rows);
				$title  = $this->_columns[$i];
				// map our headers to column fields (a1, b1, etc...)
				if( !$this->_map ) { $this->_map = new Object(); }
				$this->_map->{$title} = $column;
				$sheet->setCellValue($column, $title);
			}
		}

		// increment the row counter and add our data!
		$this->_rows++;
		$data = (is_object($data)) ? get_object_vars($data) : $data;
		while( list($k,$v) = each($data) )
		{
			$sheet->setCellValue( $this->_map{$k}.$this->_rows, $v );
		}
	}

	// write out the excel sheet
	public function save( $filepath="php://output", $type="Excel2007" )
	{
		if( ($filepath == "php://output") && !headers_sent() )
		{
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="01simple.xlsx"');
			header('Cache-Control: max-age=0');
		}
		elseif( !is_writeable($filepath) ) { return false; }

		$writer = PHPExcel_IOFactory::createWriter($this, $type);
		$writer->save($filepath);

		return true;
	}
}
?>