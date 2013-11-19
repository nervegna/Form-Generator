<?php

class Base_Button extends Base_Element
{
	
	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name="", $value=""){

		// Set attr info
		$this->attr_info = array(
				"name" 		=> "string",
				"value" 	=> "string",
				"disabled"	=> "bool");
		
		// Execute parent constructor
		// This will add attributes that exist on each HTML element
		// like id and class
		parent::__construct();
		
		// Set default value
		$this->SetName($name);
		$this->SetValue($value);
		
		// Set the current type
		$this->type = "button";
		
	}
	
	public function __toString(){
		
		// Declarations
		$format 			= TAB.TAB . '<li id="li_%s"><input %s /></li>';
		$attr_skip 			= array("disabled");
		$attribute_string 	= "";
		
		// Standard attributes
		foreach ($this->attr_values as $attribute => $value){
			if(!in_array($attribute, $attr_skip)){
				$attr_type_check = "is_" . $this->attr_info[$attribute];

				// Validate attribute
				if($attr_type_check($value)){
					$attribute_string .= $attribute . '="' . $value . '" '; 
				}else{
					trigger_error("Attribute $attribute is wrong type, expected type is " . $this->attr_info[$attribute], E_USER_NOTICE);
				}
				
			}
		}
		
		// Disabled attribute
		if(isset($this->attr_values['disabled']) && $this->attr_values['disabled']){
			$attribute_string .= 'disabled="disabled" '; 
		}
		
		// Add type
		$attribute_string .= 'type="' . $this->type . '" '; 
		
		return sprintf($format, $this->attr_values['name'], $attribute_string);
		
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

class Base_Submit extends Base_Button 
{
	
	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name="", $value=""){
		
		// Call parent constructor
		parent::__construct($name, $value);
		
		// Set type to submit
		$this->type = "submit";
		
	}
	
}

class Base_Reset extends Base_Button 
{
	
	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name="", $value=""){
		
		// Call parent constructor
		parent::__construct($name, $value);
		
		// Set type to submit
		$this->type = "reset";
		
	}
	
}