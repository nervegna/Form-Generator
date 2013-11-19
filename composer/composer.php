<?php
error_reporting(0);

// Start session
session_start();

// Includes
include("../lib/init.php");
include("Encoder.php");

// Defines
$valid_types = array("textfield", "hiddenfield", "textarea", "checkbox", "radiobutton", "passwordfield", "list", "dropdown", "filefield","fieldset", "button", "none");
$format = '<li class="%s element" id="index%s">%s<span><a href="javascript:;" class="edit">Edit</a>&nbsp;<a href="javascript:removeElement(%s)">Delete</a></span>
                <div style="display:none">
					<ul>
                  %s
				  </ul>
                </div>
            </li>';

// Add element to the form
if($_POST['action'] == "add" && in_array($_POST['type'], $valid_types)){

	// Add element to the form
	$new_number = getNewNumber();
	$_SESSION['formbuilder'][$new_number]['index'] = $_POST['type'];
	$_SESSION['formbuilder'][$new_number]['type'] = $_POST['type'];

	// Construct new form
	$form = "";
	foreach($_SESSION['formbuilder'] as $index => $element){
		if(isset($element['type'])){
			switch($element['type']){
				case "textfield":
					$Type = new Base_Hidden("el_type_" . $index, "textfield", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "What is the default value for this element?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString() . (string)$Name->__toString() . (string)$Value->__toString() . (string)$Required->__toString() . (string)$Description->__toString());
					break;
				case "hiddenfield":
					$Type = new Base_Hidden("el_type_" . $index, "hiddenfield", null);
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "What is the default value for this element?");
					$form .= sprintf($format, $element['type'],$index, $element['type'], $index, (string)$Type->__toString() . (string)$Name->__toString() . (string)$Value->__toString());
					break;
				case "passwordfield":
					$Type = new Base_Hidden("el_type_" . $index, "passwordfield", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "What is the default value for this element?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString() . (string)$Name->__toString() . (string)$Value->__toString() . (string)$Required->__toString() . (string)$Description->__toString());
					break;
				case "textarea":
					$Type = new Base_Hidden("el_type_" . $index, "textarea", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "What is the default value for this element?");
					$Cols = new Base_Text("Cols", "el_cols_" . $index, isset($element['cols']) ? $element['cols'] : 50, true, null, "The number of columns?");
					$Rows = new Base_Text("Rows", "el_rows_" . $index, isset($element['rows']) ? $element['rows'] : 4, true, null, "The number of rows?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString() . (string)$Name->__toString() . (string)$Value->__toString() . (string)$Cols->__toString() . (string)$Rows->__toString() . (string)$Required->__toString() . (string)$Description->__toString());
					break;
				case "checkbox":
					$Type = new Base_Hidden("el_type_" . $index, "checkbox", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "The value of this field when it's checked?");
					$Checked = new Base_Checkbox("Checked", "el_checked_" . $index, "true", isset($element['checked']) ? $element['checked'] : "", false, "Is this checkbox default checked.");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString() . (string)$Name->__toString() . (string)$Value->__toString() . (string)$Checked->__toString() . (string)$Required->__toString() . (string)$Description->__toString());
					break;
				case "radiobutton":
					$Type = new Base_Hidden("el_type_" . $index, "radiobutton", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "Key value pair values of this radio group. For example '+18=Older than 18;+30=Older than 30;+99=Very old' ?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Default = new Base_Text("Default", "el_default_" . $index, isset($element['default']) ? $element['default'] : "", true, null, "What's the default selected value?");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString(). (string)$Name->__toString() . (string)$Value->__toString() . (string)$Required->__toString() . (string)$Default->__toString() . (string)$Description->__toString());
					break;
					
				case "list":
					$Type = new Base_Hidden("el_type_" . $index, "list", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "Key value pair values of this list box. For example '+18=Older than 18;+30=Older than 30;+99=Very old' ?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Size = new Base_Text("Size", "el_size_" . $index, isset($element['size']) ? $element['size'] : "", true, null, "How many items are visible?");
					$Default = new Base_Text("Default", "el_default_" . $index, isset($element['default']) ? $element['default'] : "", true, null, "What's the default selected value?");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString() . (string)$Name->__toString() . (string)$Value->__toString() . (string)$Required->__toString() . (string)$Size->__toString(). (string)$Default->__toString() . (string)$Description->__toString());
					break;
					
				case "dropdown":
					$Type = new Base_Hidden("el_type_" . $index, "dropdown", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "Key value pair values of this drop down. For example '+18=Older than 18;+30=Older than 30;+99=Very old' ?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Default = new Base_Text("Default", "el_default_" . $index, isset($element['default']) ? $element['default'] : "", true, null, "What's the default selected value?");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, $element['type'], $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString() . (string)$Name->__toString() . (string)$Value->__toString() . (string)$Required->__toString() . (string)$Default->__toString() . (string)$Description->__toString());
					break;
					
				case "button":
					$Type = new Base_Hidden("el_type_" . $index, "button", null);
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Value = new Base_Text("Value", "el_value_" . $index, isset($element['value']) ? $element['value'] : "", true, null, "Key value pair values of this drop down. For example '+18=Older than 18;+30=Older than 30;+99=Very old' ?");
					$form .= sprintf($format, "btn", $index, $element['type'], $index, (string)$Type->__toString() . (string)$Name->__toString() . (string)$Value->__toString());
					break;
					
				case "filefield":
					$Type = new Base_Hidden("el_type_" . $index, "filefield", null);
					$Label = new Base_Text("Label", "el_label_" . $index, isset($element['label']) ? $element['label'] : "", true, null, "What's the label text for this element?");
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name for this element?");
					$Required = new Base_Checkbox("Required", "el_required_" . $index, "true", isset($element['required']) ? $element['required'] : "", false, "Is this input required");
					$Description = new Base_Text("Description", "el_description_" . $index, isset($element['description']) ? $element['description'] : "", true, null, "Give a description for this field?");
					$form .= sprintf($format, "filefield", $index, $element['type'], $index, (string)$Type->__toString() . (string)$Label->__toString(). (string)$Name->__toString() . (string)$Required->__toString(). (string)$Description->__toString());
					break;
				
				case "fieldset":
					$Type = new Base_Hidden("el_type_" . $index, "fieldset", null);
					$Name = new Base_Text("Name", "el_name_" . $index, isset($element['name']) ? $element['name'] : "", true, null, "What's the name to show in the legend?");
					$form .= sprintf($format, "fieldset", $index, $element['type'], $index, (string)$Type->__toString() . (string)$Name->__toString());
					break;
				
				case "none":
					break;
			}
		}
	
	}

	response($_POST['type'], $form);

}

// Remove all elements
if($_POST['action'] == "removeall"){
	session_destroy();
}

// Return count
if($_POST['action'] == "count"){
	response("Return type count", elementsCount());
}

// Remove element
if($_POST['action'] == "remove" && is_numeric($_POST['index'])){
	if(isset($_SESSION['formbuilder'][$_POST['index']])){
		$_SESSION['formbuilder'][$_POST['index']]['type'] = 'none';
		if(!isset($_POST['type'])) $_POST['type'] = "";
		response($_POST['type'], $_POST['index']);
	}else{
		error("The index is not found");
	}
}

function getNewNumber(){
	$highest = 0;
	if(isset($_SESSION['formbuilder'])){
		foreach($_SESSION['formbuilder'] as $index => $data){
			if($index > $highest){
				$highest = $index;
			}
		}
		$highest++;
	}
	return $highest;
}

function response($message, $data){
	//header('Content-type: text/json');
	$response['status'] = 200;
	$response['message'] = $message;
	$response['data'] = $data;
	$response['types'] = elementsCount();
	echo Zend_Json_Encoder::encode($response);
	exit();
}

function error($error){
	//header('Content-type: text/json');
	$response['status'] = 500;
	$response['error'] = $message;
	echo Zend_Json_Encoder::encode($response);
	exit();
}

function elementsCount(){
	$types = array();
	foreach($_SESSION['formbuilder'] as $index => $element){
		if(!isset($element['type']) || !isset($types[$element['type']])){
			if(!isset($element['type'])) $element['type'] = "";
			$types[$element['type']] = 0;
		}
		
		$types[$element['type']]++;
	}
	return $types;
}