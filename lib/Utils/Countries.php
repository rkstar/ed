<?
class Countries
{
    public $codes;
    public $names;

    public function __construct()
    {
    	$this->codes = array("US","CA","AF","AL","DZ","AS","AD","AO","AI","AQ","AG","AR","AM","AU",
    						 "AT","AZ","BS","BH","BD","BB","BY","BE","BZ","BJ","BM","BT","BO","BA",
    						 "BW","BV","BR","IO","BN","BG","BF","BI","KH","CM","CV","KY","CF","TD",
    						 "CL","CN","CX","CC","CO","KM","CG","CK","CR","CI","HR","CU","CY","CZ",
    						 "DK","DJ","DM","DO","TP","EC","EG","SV","GQ","ER","EE","ET","FK","FO",
    						 "FJ","FI","FR","FX","GF","PF","TF","GA","GM","GE","DE","GH","GI","GR",
    						 "GL","GD","GP","GU","GT","GN","GW","GY","HT","HM","HN","HK","HU","IS",
    						 "IN","ID","IR","IQ","IE","IL","IT","JM","JP","JO","KZ","KE","KI","KP",
    						 "KR","KW","KG","LA","LV","LB","LS","LR","LY","LI","LT","LU","MO","MK",
    						 "MG","MW","MY","MV","ML","MT","MH","MQ","MR","MU","YT","MX","FM","MD",
    						 "MC","MN","MS","MA","MZ","MM","NA","NR","NP","NL","AN","NC","NZ","NI",
    						 "NE","NG","NU","NF","MP","NO","OM","PK","PW","PA","PG","PY","PE","PH",
    						 "PN","PL","PT","PR","QA","RE","RO","RU","RW","KN","LC","VC","WS","SM",
    						 "ST","SA","SN","RS","SC","SL","SG","SK","SI","SB","SO","ZA","GS","ES","LK",
    						 "SH","PM","SD","SR","SJ","SZ","SE","CH","SY","TW","TJ","TZ","TH","TG",
    						 "TK","TO","TT","TN","TR","TM","TC","TV","UG","UA","AE","GB","UM","UY",
    						 "UZ","VU","VA","VE","VN","VG","VI","WF","EH","YE","YU","ZR","ZM","ZW");
		$this->names = array("United States", "Canada", "Afghanistan", "Albania", "Algeria", "American Samoa",
							 "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina",
							 "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
							 "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
							 "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory",
							 "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "CapeVerde",
							 "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island",
							 "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Cook Islands", "Costa Rica",
							 "Cote D'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica",
							 "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea",
							 "Eritrea", "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France",
							 "France, Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon",
							 "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe",
							 "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and McDonald Islands",
							 "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland",
							 "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North",
							 "Korea, South", "Kuwait", "Kyrgyzstan", "Lao People's Democratic Republic", "Latvia", "Lebanon",
							 "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau",
							 "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands",
							 "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of",
							 "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar",
							 "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand",
							 "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway",
							 "Oman", "Pakistan", "Palau", "Panama", "Papau New Guinea", "Paraguay", "Peru", "Philippines",
							 "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia",
							 "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa",
							 "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone",
							 "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
							 "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena",
							 "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden",
							 "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tokelau",
							 "Tonga", "Trinidad & Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks & Caicos Islands", "Tuvalu",
							 "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "USA Minor", "Uruguay", "Uzbekistan",
							 "Vanuatu", "Vatican", "Venezuela", "Vietnam", "Virgin Islands", "Virgin Islands (US)",
							 "Wallis/Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zaire", "Zambia", "Zimbabwe");
	}
}
?>