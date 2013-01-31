<?
// XML.php
// written by: David Fudge [ rkstar@mac.com ]
// created on: November 2, 2008
// last modified: November 2, 2008
//
// description:
// this class basically just extends the functionality of the SimpleXML
// functions built in to PHP.

class XML extends SimpleXMLElement
{
	public function append( $element )
	{
		// add a new element
		$child = (count($element->children()) > 0) ? $this->addChild($element->getName()) : $this->addChild($element->getName(),$element);
		// add the attributes
		foreach( $element->attributes() as $k => $v ) { $child->addAttribute($k,$v); }
		// add the children...
		foreach( $element->children() as $childelement ) { $child->append($childelement); }
	}
	
	// add a special CDATA child element
	public function addCDATA( $name, $value ) { $this->addChild($name,"<![CDATA[".$value."]]>"); }
		
	// quickly send a die() or print command with the asXML() func inside
	// saves us some typing and this is commonly used
	public function finish( $return=false ) { return ($return) ? $this->asXML() : die($this->asXML()); }
}
?>