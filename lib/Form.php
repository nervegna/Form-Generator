<?php

class Base_Form extends Base_Element 
{
	
	/**
	 * PHP callback function
	 *
	 * @var string
	 */
	private $_phpcallback;
	
	/**
	 * Javascript callback function
	 * 
	 * @var string
	 */
	private $_jscallback;
	
	/**
	 * Form data array
	 * 
	 * @var array
	 */
	private $_data = array();
	
	/**
	 * Variable to fix dubble formHandle
	 * 
	 * @var bool
	 */
	private $_lock = false;
	
	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param string $value
	 * @param int $maxlength
	 * @param int $size
	 */
	public function __construct($label="", $name="", $action=""){
		
		// Set attr info
		$this->attr_info = array(
				"name" 		=> "string",
				"action" 	=> "string",
				"method" 	=> "string",
				"enctype"	=> "string",
				);

		// Execute parent constructor
		// This will add attributes that exist on each HTML element
		// like id and class
		parent::__construct();
		
		// Set default value
		$this->SetName($name);
		$this->SetAction($action);
		$this->SetMethod("post");
		
		// Set the current type
		$this->type = "form";
		
		// Set element label
		$this->label = $label;
		
	}
	
	/**
	 * To string
	 */
	public function __toString(){
		
		// Declarations
		$format 			= '<form %s >' . NEWLINE . TAB . '<fieldset>' . NEWLINE.TAB . '%s<ul>' . TAB . NEWLINE . '%s' . TAB . '</ul></fieldset>' . NEWLINE . '</form>';
		//$format 			= '<form %s >' . NEWLINE . TAB . '<fieldset>' . NEWLINE.TAB . '%s<ul>' . TAB . NEWLINE . '%s' . TAB . '</ul></fieldset>' . NEWLINE . '</form>';
		$attribute_string 	= "";
		$element_string		= "";
		
		// Standard attributes
		foreach ($this->attr_values as $attribute => $value){

			$attr_type_check = "is_" . $this->attr_info[$attribute];

			// Validate attribute
			if($attr_type_check($value)){
				$attribute_string .= $attribute . '="' . $value . '" '; 
			}else{
				trigger_error("Attribute $attribute is wrong type, expected type is " . $this->attr_info[$attribute], E_USER_NOTICE);
			}
		}
		
		// If label for the form is set
		$legend = !empty($this->label) ? TAB . '<legend>' . $this->label . '</legend>' : "";
		
		// Make element string;
		foreach ($this->childs as $Element){
			$element_string .= (string)$Element->__toString() . NEWLINE;
		}
		
		// Add hidden field to track form submission
		$Tag = new Base_Hidden("formtag", $this->attr_values['name']);
		$element_string .= '<li style="display:none">' . (string)$Tag->__toString() . '</li>';
		
		// Return form
		$form_html = sprintf($format, $attribute_string, $legend, $element_string);

		// If valid do callback
		if($this->IsValid() && isset($_POST['formtag']) && ($this->attr_values['name']==$_POST['formtag'])){
			
			// Collect data
			$data = array();
			foreach ($this->childs as $child){
				$data[$child->GetInputName()] = $child->GetInputValue();
			}
			$this->_data = $data;
			
			if(!$this->_lock){
				// Execute PHP callback
				$function = $this->GetPhpCallback();
				if(is_callable($function)){
					call_user_func($function, $data);
				}
				
				// Execute JS callback
				$function = $this->GetJsCallback();
				if(!empty($function)){
					echo '<script>' . $function . '(\'' . json_encode($data) . '\');</script>';
				}
			}
			
		}
		
		return $form_html;
		
	}
	
	/**
	 * Return true if the form is processed with valid values
	 *
	 * @access public
	 * @return bool
	 */
	public function Processed(){
	
		// Excution must be done 2 times to work
		$this->_lock = true;
		$form = (string)$this->__toString();
		$this->_lock = false;
		
		if($this->IsValid() && isset($_POST['formtag']) && ($this->attr_values['name']==$_POST['formtag'])){
			foreach($this->childs as $Element){
				$result = $Element->Validate();
				if(is_array($result)){
					if(count($result)==0) return FALSE;
				}else{
					if(!empty($result)) return FALSE;
				}
			}
			
			// Parse form this is needed so
			// for the callbacks to execute
			$form = (string)$this->__toString();
			
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Return form data array
	 * 
	 * @access public
	 * @return array
	 */
	public function GetData(){
		return $this->_data;
	}
	
	/**
	 * IsValid
	 * 
	 * @access public
	 * @return bool
	 */
	public function IsValid(){
		foreach ($this->childs as $child){
			if(!empty($child->Error)){
				return FALSE;
			}
		}
		return TRUE;
	}
	
	/**
	 * Set a PHP function to callback when the form is valid submitted
	 *
	 * @access public
	 * @param function $function
	 * @return void
	 */
	public function SetPhpCallback($function){
		if(is_callable($function)){
			$this->_phpcallback = $function;
		}else{
			trigger_error("Callback function $function does not exist", E_USER_WARNING);
		}
	}
	
	/**
	 * Set a javascript function to callback when the form is valid submitted
	 * 
	 * @access public
	 * @param function $function
	 * @return void
	 */
	public function SetJsCallback($function){
		$this->_jscallback = $function;
	}
	
	/**
	 * Get javascript function to callback when the form is valid submitted
	 * 
	 * @access public
	 * @return string
	 */
	public function GetPhpCallback(){
		return $this->_phpcallback;
	}
	
		
	/**
	 * Get javascript function to callback when the form is valid submitted
	 * 
	 * @access public
	 * @return string
	 */
	public function GetJsCallback(){
		return $this->_jscallback;
	}
	
	/**
	 * Add child element to this element
	 * 
	 * @access public
	 * @param Base_Element $element
	 * @return void
	 */
	public function Add($element){
		
		// Set multipart enctype if there is an file input added
		$this->SetEnctype("multipart/form-data");
		
		$element->SetFormName($this->attr_values['name']);
		$this->childs[] = $element;
		$element->SetRequiredContent($this->requiredcontent);
	}
}