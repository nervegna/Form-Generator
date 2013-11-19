<?php

class Base_Radio extends Base_Element
{
	
	/**
	 * Constructor
	 *
	 * @param string $label
	 * @param string $name
	 * @param array $value
	 * @param string $default
	 * @param bool $required
	 * @param array $validators
	 */
	public function __construct($label="", $name="", $value="", $required=false, $default="", $description=null){

		// Set attr info
		$this->attr_info = array(
				"name" 		=> "string",
				"value" 	=> "array",
				"readonly"	=> "bool",
				"disabled"	=> "bool");
		
		// Execute parent constructor
		// This will add attributes that exist on each HTML element
		// like id and class
		parent::__construct();
		
		// Set default value
		$this->SetName($name);
		$this->SetValue($value);
		
		// Set default
		$this->default = !empty($_POST[$name]) ? htmlspecialchars($_POST[$name]) : $default;
		
		// Set the current type
		$this->type = "radio";
		
		// Set element label
		$this->label = $label;
		
		// Set element description
		$this->description = $description;
		
		// Is input required?
		$this->required = $required;
		
	}
	
	public function __toString(){
		
		// Declarations
		$format 			= TAB.TAB .  '<label%s %s><input%s %s %s %s />%s</label>';
		$attr_skip 			= array("disabled", "readonly", "value");
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
		
		// Readonly attribute
		if(isset($this->attr_values['disabled']) && $this->attr_values['readonly']){
			$attribute_string .= 'readonly="readonly" '; 
		}
		
		// Is required
		$required = $this->required ? ' class="required"' : "";
		
		// Required content
		$requiredcontent = !empty($this->requiredcontent) && $this->required ? '<span class="requiredlabel">' . $this->requiredcontent . '</span>' : ''; 

		// Add type
		$attribute_string .= 'type="' . $this->type . '" '; 

		// Description
		$description = !empty($this->description) ? TAB . '<div id="description_' . $this->attr_values['name'] . '" class="description">' . $this->description . '</div>' . NEWLINE.TAB.TAB : "";

		// Label id
		$label_id = 'id="label_option_' . $this->attr_values['name'] . '"';

		$radio_group = "";
		foreach ($this->attr_values['value'] as $key => $value){
			
			// Create value string
			$attribute_value = 'value="' . $key . '"'; 
			
			// Creat checked string
			$attribute_checked = ($this->default == $key || $this->default == $value) ? ' checked="checked"' : '';
			
			$radio_group .= sprintf($format,$required, $label_id, $required, $attribute_string, $attribute_value, $attribute_checked, $value );
		}
		
		$li_class = "";
		if(isset($_POST['formtag']) && isset($this->parentform) && ($_POST['formtag'] == $this->parentform) && $this->required && empty($_POST[$this->attr_values['name']]) && empty($li_class)){
			$li_class = ' class="error"';
		}
		
		return '<li id="li_' . $this->attr_values['name'] . '" ' . $li_class . '>' . NEWLINE.TAB.TAB.TAB . '<label id="label_' . $this->attr_values['name'] . '">' . $this->label . $requiredcontent . '</label>' . $radio_group . NEWLINE.TAB.TAB . $description . '</li>';
		
		
	}
	
	/**
	 * Get input value
	 * 
	 * @access public
	 * @return string
	 */
	public function GetInputValue(){
		return $this->default;
	}
	
}