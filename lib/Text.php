<?php

class Base_Text extends Base_Element
{
	
	/**
	 * Constructor
	 *
	 * @param string $label
	 * @param string $name
	 * @param string $value
	 * @param array $validators
	 */
	public function __construct($label="", $name="", $value="", $required=false, $validators=null, $description=null){

		// Set attr info
		$this->attr_info = array(
				"name" 		=> "string",
				"value" 	=> "string",
				"size" 		=> "integer",
				"maxlength" => "integer",
				"readonly"	=> "bool",
				"disabled"	=> "bool");
		
		// Execute parent constructor
		// This will add attributes that exist on each HTML element
		// like id and class
		parent::__construct();
	
		// Overwrite default value
		if(!empty($_POST[$name])) $value = htmlspecialchars($_POST[$name]);
		
		// Add validators
		if($validators != null && is_array($validators)){
			foreach ($validators as $validator){
				$this->AddValidator($validator);
			}
		}
		if($validators != null && !is_array($validators)){
			$this->AddValidator($validators);
		}
		
		// Set default value
		$this->SetName($name);
		$this->SetValue($value);
		
		// Set the current type
		$this->type = "text";
		
		// Set element label
		$this->label = $label;
		
		// Set element description
		$this->description = $description;
		
		// Is input required?
		$this->required = $required;
		
	}
	
	public function __toString(){
		
		// Declarations
		$format 			= TAB.TAB . '<li id="li_' . $this->attr_values['name'] . '"%s>' . NEWLINE.TAB.TAB.TAB . '<label%s %s for="%s">%s%s</label>' . NEWLINE.TAB.TAB.TAB . '<input%s %s />' . NEWLINE.TAB.TAB . '%s%s</li>';
		$attr_skip 			= array("disabled", "readonly");
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
			$attribute_string .= 'disabled '; 
		}
		
		// Readonly attribute
		if(isset($this->attr_values['readonly']) && $this->attr_values['readonly']){
			$attribute_string .= 'readonly="readonly" '; 
		}
		
		// Is required
		$required = $this->required ? ' class="required"' : "";
		
		// Required content
		$requiredcontent = !empty($this->requiredcontent) && $this->required ? '<span class="requiredlabel">' . $this->requiredcontent . '</span>' : ''; 

		// Description
		$description = !empty($this->description) ? TAB . '<div id="description_' . $this->attr_values['name'] . '" class="description">' . $this->description . '</div>' . NEWLINE.TAB.TAB : "";
		
		// Add type
		$attribute_string .= 'type="' . $this->type . '" '; 
		
		// Label id
		$label_id = 'id="label_' . $this->attr_values['name'] . '"';
		
		// Input validation
		$li_class 	= "";
		$error 		= "";
		if(isset($_POST['formtag']) && isset($this->parentform) && ($_POST['formtag'] == $this->parentform)){
			$this->Error = $this->Validate();
			$li_class = !empty($this->Error) ? ' class="error"' : '';
			$error_string = is_array($this->Error) ? $this->Error[0] : $this->Error;
			$error = !empty($this->Error) ? TAB . '<div id="error_' . $this->attr_values['name'] . '" class="errormessage">' . $error_string . '</div>' . NEWLINE.TAB.TAB : "";
			
			if($this->required && empty($_POST[$this->attr_values['name']]) && empty($li_class)){
				$li_class = ' class="error"';
			}
		}
		
		return sprintf($format, $li_class, $required, $label_id, $this->attr_values['name'], $this->label, $requiredcontent, $required, $attribute_string, $description, $error);
		
	}
	
	/**
	 * Get input value
	 * 
	 * @access public
	 * @return string
	 */
	public function GetInputValue(){
		return $this->attr_values['value'];
	}
	
}

class Base_Hidden extends Base_Text 
{
	
	/**
	 * Constructor
	 *
	 * @param string $label
	 * @param string $name
	 * @param string $value
	 * @param array $validators
	 */
	public function __construct($name="", $value="", $validators=null){
		
		// Call parent constructor
		parent::__construct("", $name, $value, true);
		
		// Set type to submit
		$this->type = "hidden";
		
	}
	
	public function __toString(){
		
		// Declarations
		$format 			= TAB.TAB . '<input %s />';
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
		
		return sprintf($format, $attribute_string);
		
	}
	
}

class Base_Password extends Base_Text 
{
	
	/**
	 * Constructor
	 *
	 * @param string $label
	 * @param string $name
	 * @param string $value
	 * @param array $validators
	 */
	public function __construct($label="", $name="", $value="",  $required=false, $validators=null){
		
		// Call parent constructor
		parent::__construct($label, $name, $value, $required, $validators);
		
		// Set type to submit
		$this->type = "password";
		
		// Empty element
		//$this->SetValue("");
		
	}
	
}
