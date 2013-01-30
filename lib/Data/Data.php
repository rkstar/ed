<?php
// Data.php
// created on: October 22, 2012
// updated on: October 22, 2012
//
// I put this file back into the library purely for backwards compatibility.
//

ed::load("Data.SQLQuery");

class Data extends SQLQuery
{
	public function __construct( $members=array() ) { parent::__construct($members); }
}
?>