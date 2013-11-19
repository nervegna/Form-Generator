<?php
error_reporting(E_ALL);
session_start();
ob_start();
include("../lib/init.php");

if(isset($_POST['btnSave'])){
	foreach($_POST as $name => $data){
		$parts = explode("_", $name);
		if(count($parts) == 3){
			$_SESSION['formbuilder'][$parts[2]][$parts[1]] = $data;
		}
	}
}

// Create form settings form
$Title = new Base_Text("Title", "txtformtitle", isset($_SESSION['formbuilder']['form']['title']) ? $_SESSION['formbuilder']['form']['title'] : "", true, null, "What is the title of this form?");
$Name = new Base_Text("Name", "txtformname", isset($_SESSION['formbuilder']['form']['name']) ? $_SESSION['formbuilder']['form']['title'] : "", true, null, "What's the name for this form. For example frmmail?");
$Action = new Base_Text("Action", "txtformaction", isset($_SESSION['formbuilder']['form']['action']) ? $_SESSION['formbuilder']['form']['title'] : "", false, null, "The PHP page that processes this form. If this is the same page is the form you can leave this empty?");
$Button = new Base_Submit("btnsubmit", "Generate");
$Button->SetClass("button");
$Form = new Base_Form("", "frmform", "#formsettings");
$Form->SetPhpCallback("formHandle");
$Form->Add($Title);
$Form->Add($Name);
$Form->Add($Button);

function formHandle($data){
	echo "dfdf";
	$_SESSION['formbuilder']['form']['title'] = $data['txtformtitle'];
	$_SESSION['formbuilder']['form']['name'] = $data['txtformname'];
	$_SESSION['formbuilder']['form']['action'] = '';
	header("Location: preview.php");
	exit();
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
		addElement("none");
	});
	
	function addElement(name){
		$.post('composer.php', {action: 'add', type: name}, addElementCb, "json");
	}
	function addElementCb(response){
		updateCount(response.types);
		$("#formlist").html(response.data);
		
		// Add toggle handler
		$('.edit').click(function(){
			 $(this).parent().next().slideToggle();
		});
		
	}
	function removeElement(index){
		$.post('composer.php', {action: 'remove', index: index}, removeElementCb, "json");
	}
	function removeElementCb(response){
		if(response.status == "200"){
			updateCount(response.types);
			$("#elementsoverview .tr_" + response.message + " .index").html(response.types[response.message]);
			$("#index" + response.data).fadeOut();
		}
	}
	function removeAllElements(){
		if(confirm("Are you sure that you want to delete all elements on the form?")){
			$.post('composer.php', {action: 'removeall'}, "removeAllElementsCb", "json");
			$("#formlist").html('');
			$("#elementsoverview .tr_textfield .index").html("0");
			$("#elementsoverview .tr_textarea .index").html("0");
			$("#elementsoverview .tr_passwordfield .index").html("0");
			$("#elementsoverview .tr_hiddenfield .index").html("0");
			$("#elementsoverview .tr_checkbox .index").html("0");
			$("#elementsoverview .tr_radiobutton .index").html("0");
			$("#elementsoverview .tr_list .index").html("0");
			$("#elementsoverview .tr_dropdown .index").html("0");
			$("#elementsoverview .tr_button .index").html("0");
			$("#elementsoverview .tr_fieldset .index").html("0");
			$("#elementsoverview .tr_filefield .index").html("0");
		}
	}
	function removeAllElementsCb(response){
		alert(response);
		if(response.status == "200"){
			$("#elementsoverview .tr_textfield .index").html(0);
			$("#elementsoverview .tr_textarea .index").html(0);
			$("#elementsoverview .tr_passwordfield .index").html(0);
			$("#elementsoverview .tr_hiddenfield .index").html(0);
			$("#elementsoverview .tr_checkbox .index").html(0);
			$("#elementsoverview .tr_radiobutton .index").html(0);
			$("#elementsoverview .tr_list .index").html(0);
			$("#elementsoverview .tr_dropdown .index").html(0);
			$("#elementsoverview .tr_button .index").html(0);
			$("#elementsoverview .tr_fieldset .index").html(0);
			$("#elementsoverview .tr_filefield .index").html(0);
		}
	}
	function updateCount(types){
		$("#elementsoverview .tr_textfield .index").html(types.textfield);
		$("#elementsoverview .tr_textarea .index").html(types.textarea);
		$("#elementsoverview .tr_passwordfield .index").html(types.passwordfield);
		$("#elementsoverview .tr_hiddenfield .index").html(types.hiddenfield);
		$("#elementsoverview .tr_checkbox .index").html(types.checkbox);
		$("#elementsoverview .tr_radiobutton .index").html(types.radiobutton);
		$("#elementsoverview .tr_list .index").html(types.list);
		$("#elementsoverview .tr_dropdown .index").html(types.dropdown);
		$("#elementsoverview .tr_button .index").html(types.button);
		$("#elementsoverview .tr_fieldset .index").html(types.fieldset);
		$("#elementsoverview .tr_filefield .index").html(types.filefield);
	}
</script>
</head>
<body>
<div id="wrapper">
	<div id="header">
	  <h1>Form Builder</h1>
        </div>
	<div id="content">
    <div class="header">
      <h2>Add elements</h2>
      <ul class="tabs">
      	<li class="active"></li>
        <li></li>
        <li><a href="javascript:removeAllElements();">Reset form</a></li>
      </ul>
      <a name="addelements" id="addelements"></a></div>
    <div class="content">
      <p>Select elements you want to add to your form. You always can add extra items later. Click on the add buttons against the items you want to add to your form. Next you click on the <strong>Edit elements</strong> button to define the settings for the added form elelments.</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="4" id="elementsoverview">
        <tbody>
          <tr class="tr_textfield">
            <td><img src="images/textfield.gif" alt="Text field icon" width="16" height="16" /></td>
            <td>Text field</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('textfield');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_passwordfield">
            <td><img src="images/textfield.gif" alt="Text field icon" width="16" height="16" /></td>
            <td>Password field</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('passwordfield');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_hiddenfield">
            <td><img src="images/hiddenfield.gif" alt="Hidden field icon" width="16" height="16" /></td>
            <td>Hidden  field</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('hiddenfield');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_textarea">
            <td><img src="images/textarea.gif" alt="Textarea icon" width="16" height="16" /></td>
            <td>Textarea</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('textarea');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_checkbox">
            <td><img src="images/checkbox.gif" alt="Checkbox icon" width="16" height="16" /></td>
            <td>Checkbox</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('checkbox');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_radiobutton">
            <td><img src="images/radiobutton.gif" alt="Radio button icon" width="16" height="16" /></td>
            <td>Radio button</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('radiobutton');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_list">
            <td><img src="images/list.gif" alt="List icon" width="16" height="16" /></td>
            <td>List</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('list');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_dropdown">
            <td><img src="images/dropdown.gif" alt="Dropdown icon" width="16" height="16" /></td>
            <td>Drop down</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('dropdown');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_filefield">
            <td><img src="images/filefield.gif" alt="Filefield icon" width="16" height="16" /></td>
            <td>File field</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('filefield');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_button">
            <td><img src="images/btn.gif" alt="Button icon" width="16" height="16" /></td>
            <td>Button</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('button');" class="button">Add to form</a></td>
          </tr>
          <tr class="tr_fieldset">
            <td><img src="images/fieldset.gif" alt="Fieldset icon" width="16" height="16" /></td>
            <td>Fieldset</td>
            <td align="right" class="index">0</td>
            <td align="right"><a href="javascript:addElement('fieldset');" class="button">Add to form</a></td>
          </tr>
        </tbody>
      </table>
      </div>
    <div class="spacer"><!--SPACER--></div>
    <div class="header">
      <h2>Edit elements</h2>
      <ul class="tabs">
        <li class="active"></li>
        <li></li>
        <li></li>
      </ul>
      <a name="editelements" id="editelements"></a></div>
    <div class="content">
      <p>Here you can modify the settings for the different form elements.</p>
      <form id="form1" name="form1" method="post" action="#editelements">
        <div id="form">
          <ul id="formlist">
            
          </ul>
        </div>
        <input type="submit" class="button" name="btnSave" id="btnSave" value="Save" />
      </form>
      </div>
    <div class="spacer"><!--SPACER--></div>
    <div class="header">
      <h2>Form settings</h2>
      <a name="formsettings" id="formsettings"></a></div>
    <div class="content">
    	<?php echo (string)$Form->__toString(); ?> 
    </div>
     <div class="spacer"><!--SPACER--></div>
  </div>
</div>
<br />
</body>
</html>
