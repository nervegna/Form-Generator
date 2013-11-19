<?php 

define('TAB', "\t");
define('NEWLINE', "\n");

/**
 * Interface for all form elements
 */
abstract class Base_Element 
{
	
	/**
	 * Stores the attributes for this element
	 * 
	 * @access protected
	 * @var array
	 */
	protected $attributes;
	
	/**
	 * Atributes information
	 * 
	 * @access protected
	 * @var array
	 */
	protected $attr_info = array();
	
	/**
	 * Attributes values
	 * 
	 * @access protected
	 * @var array
	 */
	protected $attr_values = array();
	
	/**
	 * Element type
	 * 
	 * @access protected
	 * @var string
	 */
	protected $type;
	
	/**
	 * Element label
	 * 
	 * @access protected
	 * @var string
	 */
	protected $label;
	
	/**
	 * Validator chain
	 * 
	 * @access protected
	 * @var array
	 */
	protected $validators = array();
	
	/**
	 * Add child element
	 * 
	 * @var array
	 */
	protected $childs = array();
	
	/**
	 * Is Required?
	 * 
	 * @access protected
	 * @var bool
	 */
	protected $required = FALSE;
	
	/**
	 * Extra input description
	 * 
	 * @access protected
	 * @var string
	 */
	protected $description;
	
	/**
	 * Parent form
	 * 
	 * @access protected
	 * @var string
	 */
	protected  $parentform;
	
	/**
	 * Error text
	 * 
	 * @access public
	 * @var string
	 */
	public $Error;
	
	/**
	 * Required content
	 * 
	 * @access protected
	 * @var string
	 */
	protected $requiredcontent;
	
	/**
	 * Required message
	 * 
	 * @access protected
	 * @var string
	 */
	protected $requiredmessage;
	
	/**
	 * Construcotr
	 *
	 */
	public function __construct(){
		
		// Add default attribute info
		$this->addDefaultAttrInfo();
		
	}
	
	public function GetError(){
		return $this->Error;
	}
	
	/**
	 * Set required content
	 * 
	 * @access public
	 * @param string $content
	 * @return void
	 */
	public function SetRequiredContent($content, $message="This field is required"){
		$this->requiredcontent = $content;
		$this->requiredmessage = $message;
	}
	
	/**
	 * Get input name
	 * 
	 * @access public
	 * @return string
	 */
	public function GetInputName(){
		if(isset($this->attr_values['name'])){
			return $this->attr_values['name'];
		}else{
			return "";
		}
	}
	
	/**
	 * Get form name
	 * 
	 * @access public
	 * @return string
	 */
	public function GetFormName(){
		return $this->parentform;
	}
	
	public function SetFormName($string){
		$this->parentform = $string;
	}
	
	/**
	 * Fill attributes
	 * 
	 * @access public
	 * @param string $name
	 * @param array $arguments
	 * @return void
	 */
	public function __call($name, $arguments){
		
		// Get attributename
		$attribute = str_replace("set", "", strtolower($name));
		
		// Check if the attribute is valid
		if(!array_key_exists($attribute, $this->attr_info)) trigger_error("Attribute $attribute does not exist on element of type " . $this->type, E_USER_WARNING);
		
		// Save value
		$this->attr_values[$attribute] = $arguments[0];
		
		// Default set the id equal to the name
		// so the label (for binding) is ok
		if((!isset($this->attr_values['id']) || empty($this->attr_values['id'])) && $attribute == "name"){
			$this->attr_values['id'] = $arguments[0];
		}
		
	}
	
	/**
	 * Execute the validators chain
	 * 
	 * @access public
	 * @param bool $array
	 * @return string|array
	 */
	public function Validate($array=false){
		$result = $array ? array() : "";
		foreach ($this->validators as $Validator){
			$temp = $Validator->Validate($this->attr_values['value']);
			
			// Direct return if array = false
			if(!$array && !$temp) return $Validator->GetMessage();
			
			// Add errormessage to the result
			if(!$temp){
				$result[] = $Validator->GetMessage();
			}
			
		}

		$class = get_class($this);
		if(($class == "Base_File") && empty($_FILES[$this->attr_values['name']]['name']) && $this->required){
			$result[] = $this->requiredmessage;
		}
		if(($class != "Base_File") && empty($_POST[$this->attr_values['name']]) && $this->required){
			$result[] = $this->requiredmessage;
		}
		return $result;
	}
	
	/**
	 * Add validator to the validation chain
	 * 
	 * @access public
	 * @param defined $validator
	 * @param string $fail_message
	 * @return void
	 */
	public function AddValidator($validator){
		$this->validators[] = $validator;
	}
	
	private function addDefaultAttrInfo(){
		$this->attr_info["id"] 				= "string";
		$this->attr_info["class"] 			= "string";
		$this->attr_info["onblur"] 			= "string";
		$this->attr_info["onchange"] 		= "string";
		$this->attr_info["onclick"] 		= "string";
		$this->attr_info["ondblclick"] 		= "string";
		$this->attr_info["onfocus"] 		= "string";
		$this->attr_info["onkeydown"] 		= "string";
		$this->attr_info["onkeypress"] 		= "string";
		$this->attr_info["onkeyup"] 		= "string";
		$this->attr_info["onmousedown"] 	= "string";
		$this->attr_info["onmousemove"] 	= "string";
		$this->attr_info["onmouseout"] 		= "string";
		$this->attr_info["onmouseover"] 	= "string";
		$this->attr_info["onmouseup"] 		= "string";
		$this->attr_info["onselect"] 		= "string";
	}
	
}