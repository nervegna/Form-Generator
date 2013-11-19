<?php

class Base_Field extends Base_Element 
{
	
	/**
	 * Constructor
	 *
	 * @param string $value
	 */
	public function __construct($label=""){
		
		// Execute parent constructor
		// This will add attributes that exist on each HTML element
		// like id and class
		parent::__construct();
		
		// Set the current type
		$this->type = "field";
		
		// Set element label
		$this->label = $label;
		
	}
	
	public function __toString(){
		
		// Declarations
		$format 			= TAB . '</ul></fieldset>' . NEWLINE.TAB . '<fieldset>' . TAB . '%s' . TAB;
		$attr_skip 			= array("disabled");
		
		// If label for the form is set
		$legend = !empty($this->label) ? NEWLINE.TAB.TAB . '<legend>' . $this->label . '</legend><ul>' : "";
		
		return sprintf($format, $legend);
		
	}
	
	/**
	 * Get input value
	 * 
	 * @access public
	 * @return string
	 */
	public function GetInputValue(){
		return FALSE;
	}
	
}