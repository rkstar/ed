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
ed::import("ThirdParty.PHPExcel");

class Excel extends PHPExcel
{
	private $_columns;
	private $_rows = 1;

	public function __construct()
	{
		// init the column headings object
		$this->_columns = new Object();

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
	}
}

















/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>