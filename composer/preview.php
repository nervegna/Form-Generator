<?php

error_reporting(0);
session_start();
ob_start();
include("../lib/init.php");

$Form = new Base_Form($_SESSION['formbuilder']['form']['title'],$_SESSION['formbuilder']['form']['name'], $_SESSION['formbuilder']['form']['action']);
$source = '$Form = new Base_Form("' . $_SESSION['formbuilder']['form']['title'] . '","' . $_SESSION['formbuilder']['form']['name'] . '","");<br />';
$source .= '$Form->SetPhpCallback("formHandle");<br /><br />';
$counter = 0;
$callback = "";
foreach($_SESSION['formbuilder'] as $index => $element){
	if(isset($element['type'])){
		switch($element['type']){
			case "textfield":
				$Element = new Base_Text($element['label'], 
										$element['name'], 
										$element['value'],
										$element['required'], 
										null, 
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Text("%s", "%s", "%s", %s, null, "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										$element['value'],
										($element['required'] == "true") ? "true" : "false", 
										$element['description']);
				break;
			case "passwordfield":
				$Element = new Base_Password($element['label'], 
										$element['name'], 
										$element['value'],
										$element['required'], 
										null);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Password("%s", "%s", "%s", %s, null);<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										$element['value'],
										($element['required'] == "true") ? "true" : "false");
				break;
			case "hiddenfield":
				$Element = new Base_Hidden($element['label'], 
										$element['name'], 
										$element['value']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Hidden("%s", "%s", "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										$element['value']);
				break;
			case "textarea":
				$Element = new Base_Textarea($element['label'], 
										$element['name'], 
										$element['value'],
										$element['cols'],
										$element['rows'],
										$element['required'], 
										null, 
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Textarea("%s", "%s", "%s", %s, %s, %s, null, "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										$element['value'],
										$element['cols'],
										$element['rows'],
										($element['required'] == "true") ? "true" : "false", 
										$element['description']);
				break;
			case "checkbox":
				$Element = new Base_Checkbox($element['label'], 
										$element['name'], 
										$element['value'],
										$element['checked'],
										$element['required'],
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Checkbox("%s", "%s", "%s", %s, %s, "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										$element['value'],
										($element['checked'] == "true") ? "true" : "false",
										($element['required'] == "true") ? "true" : "false", 
										$element['description']);
				break;
			case "radiobutton":
				$Element = new Base_Radio($element['label'], 
										$element['name'], 
										makeKeyValue($element['value']),
										$element['required'],
										$element['default'],
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Radio("%s", "%s", %s, %s, "%s", "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										makeKeyValueString($element['value']),
										($element['required'] == "true") ? "true" : "false",
										$element['default'], 
										$element['description']);
				break;
			case "list":
				$Element = new Base_List($element['label'], 
										$element['name'], 
										makeKeyValue($element['value']),
										$element['required'],
										$element['size'],
										$element['default'],
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_List("%s", "%s", %s ,%s, %s, "%s", "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										makeKeyValueString($element['value']),
										($element['required'] == "true") ? "true" : "false",
										$element['size'],
										$element['default'], 
										$element['description']);
				break;
			case "dropdown":
				$Element = new Base_Select($element['label'], 
										$element['name'], 
										makeKeyValue($element['value']),
										$element['required'],
										$element['default'],
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Select("%s", "%s", %s ,%s, "%s", "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										makeKeyValueString($element['value']),
										($element['required'] == "true") ? "true" : "false",
										$element['default'], 
										$element['description']);
				break;
			case "button":
				$Element = new Base_Submit($element['name'], 
										$element['value']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Submit("%s", "%s");<br />';
				$source .= sprintf($format, $counter, $element['name'], 
										$element['value']);
				break;
			case "filefield":
				$Element = new Base_File($element['label'], 
										$element['name'], 
										$element['required'], 
										null, 
										$element['description']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_File("%s", "%s", %s, null, "%s");<br />';
				$source .= sprintf($format, $counter, $element['label'], 
										$element['name'], 
										($element['required'] == "true") ? "true" : "false", 
										$element['description']);
				break;
			case "fieldset":
				$Element = new Base_Field($element['name']);
				$Form->Add($Element);
				$format = '$Element%s = new Base_Field("%s");<br />';
				$source .= sprintf($format, $counter, $element['name']);
				break;
		}
		
		
		if(isset($element['name']) && !empty($element['name']) && $element != "none" && $element['type'] != "none"){
			$source .= '$Form->Add($Element' . $counter . ');<br />';
		}
		if(isset($element['name']) && !empty($element['name'])){
			$callback .= 'echo "' . $element['name'] . ' = " . $data[\'' . $element['name'] . '\'] . "&lt;br /&gt;"; <br />';
		}
		$counter++;
	}
}


function makeKeyValue($data){
	$array = array();
	$parts = explode(";", $data);
	foreach($parts as $line){
		$keyvalue = explode("=", $line);
		$array[$keyvalue[0]] = $keyvalue[1];
	}
	return $array;
}
function makeKeyValueString($data){
	$lines = array();
	$parts = explode(";", $data);
	foreach($parts as $line){
		$keyvalue = explode("=", $line);
		$lines[] = '"' . $keyvalue[0] . '" => "' . $keyvalue[1] . '"';
	}
	return "array(" . implode(",", $lines) . ")";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form Builder</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$('h2').click(function(){
			$(this).parent().next().slideToggle();
		});
	});
	
	function showSource(){
		$("#source").fadeIn();
	}
</script>
</head>
<body>
<div id="wrapper">
	<div id="header">
	  <h1>Form Builder Preview</h1>
        </div>
	<div id="content">
    <div class="header">
      <h2>Preview form</h2>
      <ul class="tabs">
      	<li class="active"></li>
        <li><a href="javascript:showSource();">Get source</a></li>
        <li><a href="index.php">Back</a></li>
      </ul>
      <a name="addelements" id="addelements"></a></div>
    <div class="content">
        <div style="display:none" id="source">
        &lt;?php<br /><br />
        // Don't forget to include the EasyForms library<br />
        // include("lib/init.php");<br /><br />
        <?php echo $source; ?>
        <br />
		<br />
        function formHandle($data){<br />
        	 <?php echo $callback; ?>
        }<br /><br />
        
        if(!$Form->Processed()){ <br />
        echo $Form->__toString();<br />
        }
        </div>
      <p>
      	<?php echo (string)$Form->__toString(); ?>
      </p>
    </div>
    <div class="spacer"><!--SPACER--></div>
  </div>
</div>
<br />
</body>
</html>
