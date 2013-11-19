<?php

class Base_Validator
{
	
	/**
	 * Fail message
	 *
	 * @var string
	 */
	protected $fail_message;
	
	/**
	 * Get fail message
	 *
	 * @access public
	 * @return string
	 */
	public function GetMessage(){
		return $this->fail_message;
	}
	
}

/**
 * Empty validation
 */
if(!class_exists("Base_Validators_NotEmpty")){
	class Base_Validators_NotEmpty extends Base_Validator
	{
		
		/**
		 * Constructor
		 *
		 * @param string $message
		 */
		public function __construct($message){
			$this->fail_message = $message;
		}
		
		/**
		 * Validate this element
		 *
		 * @access public
		 * @param string $string
		 * @return string
		 */
		public function Validate($string){
			return !empty($string);
		}
		
	}
}

/**
 * Email validation
 */
if(!class_exists("Base_Validators_Email")){
	class Base_Validators_Email extends Base_Validator
	{
		
		/**
		 * Constructor
		 *
		 * @param string $message
		 */
		public function __construct($message){
			$this->fail_message = $message;
		}
		
		/**
		 * Validate this element
		 *
		 * @access public
		 * @param string $string
		 * @return string
		 */
		public function Validate($string){
			return (bool)preg_match("/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i", $string);
		}
		
	}
}

/**
 * Integer validation
 */
if(!class_exists("Base_Validators_Integer")){
	class Base_Validators_Integer extends Base_Validator
	{
				
		private $_min;
		private $_max;
		
		/**
		 * Constructor
		 *
		 * @param string $message
		 * @param int $min
		 * @param int $max
		 */
		public function __construct($message, $min=null, $max=null){
			$this->fail_message 	= $message;
			$this->_min 			= $min;
			$this->_max 			= $max;
		}
		
		/**
		 * Validate this element
		 *
		 * @access public
		 * @param int $var
		 * @return bool
		 */
		public function Validate($var){
			
			$valid = TRUE;
			
			if(is_numeric($this->_min) && $this->_min > $var){
				$valid = FALSE;
			}
			
			if(is_numeric($this->_max) && $this->_max < $var){
				$valid = FALSE;
			}
			
			if(!is_numeric($var)){
				$valid = FALSE;
			}
			
			return $valid;
		}
		
	}
}

/**
 * Containt validation
 */
if(!class_exists("Base_Validators_Contains")){
	class Base_Validators_Contains extends Base_Validator
	{
				
		private $_contain;
		
		/**
		 * Constructor
		 *
		 * @param string $message
		 * @param string $contain
		 */
		public function __construct($message, $contain=""){
			$this->fail_message 	= $message;
			$this->_contain 		= $contain;
		}
		
		/**
		 * Validate this element
		 *
		 * @access public
		 * @param int $var
		 * @return bool
		 */
		public function Validate($var){
			return strstr(strtolower($var), $this->_contain);
		}
		
	}
}

/**
 * Upload validation
 */
if(!class_exists("Base_Validators_File")){
	class Base_Validators_File extends Base_Validator
	{
				
		private $_maxsize;
		private $_extentions;
		private $_mimes;
		
		/**
		 * Constructor
		 *
		 * @param string $message
		 * @param int $maximum_size
		 * @param array $allowed_extensions
		 * @param array $allowed_mimes
		 */
		public function __construct($message, $maximum_size=null, $allowed_extensions=null, $allowed_mimes=null){
			$this->fail_message 	= $message;
			$this->_maxsize 		= $maximum_size;
			$this->_extentions		= $allowed_extensions;
			$this->_mimes			= $allowed_mimes;
		}
		
		/**
		 * Validate this element
		 *
		 * @access public
		 * @param array $file
		 * @return bool
		 */
		public function Validate($file){

			// Check filesize
			if(($this->_maxsize != null) && ($file['size'] > $this->_maxsize)){
				return FALSE;
			}
			
			// Check extension
			$extension = end(explode(".", $file['name']));
			if(($this->_extentions != null) && !in_array($extension, $this->_extentions)){
				return FALSE;
			}
			
			// Check mime
			if(($this->_mimes != null) && !in_array($file['type'], $this->_mimes)){
				return FALSE;
			}
			
			return TRUE;
		}
		
	}
}

/**
 * Image validation
 */
if(!class_exists("Base_Validators_Image")){
	class Base_Validators_Image extends Base_Validator
	{
				
		private $_width;
		private $_height;
		
		/**
		 * Constructor
		 *
		 * @param int $width
		 * @param int $height
		 */
		public function __construct($message, $width=null, $height=null){
			$this->fail_message 	= $message;
			$this->_width			= $width;
			$this->_height			= $height;
		}
		
		/**
		 * Validate this element
		 *
		 * @access public
		 * @param array $file
		 * @return bool
		 */
		public function Validate($file){

			// Image info
			$info = getimagesize($file['tmp_name']);

			// Check width
			if(($this->_width != null) && ($info[0] > $this->_width)){
				return FALSE;
			}
			
			// Check height
			if(($this->_height != null) && ($info[1] > $this->_height)){
				return FALSE;
			}
			
			return TRUE;
		}
		
	}
}