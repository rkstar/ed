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
	private $errorcode;
	private $message;

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
	
	// this is a special function that will add an <errorcode/> and <message/> to our
	// XML element and save us 2 lines of code later on
	public function addError( $errorcode, $message )
	{
		$this->addChild("errorcode",$errorcode);
		$this->addChild("message",$message);
	}
	// add a message to an existing "message" child
	public function addMessage( $message )
	{
		// sanity
		if( !$this->message ) { return; }
		$this->message .= $message;
	}
	
	// quickly send a die() or print command with the asXML() func inside
	// saves us some typing and this is commonly used
	public function finish( $return=false ) { return ($return) ? $this->asXML() : die($this->asXML()); }
}
?>