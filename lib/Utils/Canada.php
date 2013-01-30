<?
class Canada
{
	public $codes;
	public $names;
	
	public function __construct()
	{
		$this->codes = array("AB","BC","MB","NB","NL","NS","NT","NU","ON","PE","QC","SK","YT");
		$this->names = array("Alberta", "British Columbia", "Manitoba", "New Brunswick", "Newfoundland and Labrador",
							 "Nova Scotia", "Northwest Territories", "Nunavut", "Ontario", "Prince Edward Island",
							 "Quebec", "Saskatchewan", "Yukon Territories");
	}
}
?>