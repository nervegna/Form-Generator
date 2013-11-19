<script>
function formHandle(data){
	alert(data);
}
</script>

<?php

error_reporting(E_ALL);

include("Element.php");
include("Text.php");
include("Form.php");
include("Button.php");
include("Checkbox.php");
include("Field.php");
include("Radio.php");
include("Select.php");
include("Textarea.php");
include("File.php");
include("Validator.php");

$Form = new Base_Form("Test", "frmtest");
$Form->SetPhpCallback("formHandle");
$Form->Add(new Base_Text("Test", "txtname", "5", false, new Base_Validators_Integer("Het moet een nummer tussen 5 en 10 zijn", 5, 10), "Geef je naam op."));
$Form->Add(new Base_Password("Password", "txtpassword", "", true));
$Form->Add(new Base_Field("Checks"));
$Form->Add(new Base_Checkbox("Akkoord", "txtaccept", "true", false, true));
$Form->Add(new Base_Radio("What type", "rndtype", array("text" => "Text", "list" => "List", "option" => "Option"), "option", true, "Select the type"));
$Form->Add(new Base_Select("Animal", "sltanimal", array("horse" => "Horse", "turtel" => "Turtel", "fish" => "Fish"), "turtel", "Select your type of animal"));
$Form->Add(new Base_List("Animal", "lstanimal", array("horse" => "Horse", "turtel" => "Turtel", "fish" => "Fish"), 3, "turtel", "Select your type of animal", true));
$Form->Add(new Base_Textarea("Message", "txtmessage", "", 20, 6, true,  null, "Een beschrijving"));
$Form->Add(new Base_File("Thumb", "flupload", false, new Base_Validators_File("Wrong file type or size", 1000, array("doc", "txt"))));
$Form->Add(new Base_Submit("btnsubmit", "Send"));
echo $Form;

function formHandle($data){
	//print_r($data);
	echo "OK";
}

?>
