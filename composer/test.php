<?php

// Don't forget to include the EasyForms library
include("../lib/init.php");

$Form = new Base_Form("All elements","All elements","");
$Form->SetPhpCallback("formHandle");

$Element1 = new Base_Password("Password field", "txtpass", "", true, null);
$Form->Add($Element1);
$Element2 = new Base_Hidden("", "txthidden", "This is hidden data");
$Form->Add($Element2);
$Element3 = new Base_Textarea("Textarea", "txttextarea", "This is a text area", 50, 5, true, null, "This is the text area");
$Form->Add($Element3);
$Element4 = new Base_Checkbox("Checkit", "chktest", "true", true, true, "A checkbox");
$Form->Add($Element4);
$Element5 = new Base_Radio("Rnd", "rndage", array("+18" => "Older than 18","+30" => "Older than 30","+99" => "Very old"), true, "+99", "This is an radio group");
$Form->Add($Element5);
$Element6 = new Base_List("List", "lst", array("+18" => "Older than 18","+30" => "Older than 30","+99" => "Very old") ,true, 3, "+30", "What is this for a list");
$Form->Add($Element6);
$Element7 = new Base_Select("Dropdown", "drpdown", array("+18" => "Older than 18","+30" => "Older than 30","+99" => "Very old") ,true, "+30", "This is a dropdown");
$Form->Add($Element7);
$Element8 = new Base_Text("Textfield", "txtname", "Wim", true, null, "What is your namd");
$Form->Add($Element8);
$Element9 = new Base_Field("Avatar");
$Form->Add($Element9);
$Element10 = new Base_File("Image", "flimage", true, null, "Choose an image");
$Form->Add($Element10);
$Element11 = new Base_Submit("btnSave", "Save");
$Form->Add($Element11);


function formHandle($data){
echo "txtpass = " . $data['txtpass'] . "<br />";
echo "txthidden = " . $data['txthidden'] . "<br />";
echo "txttextarea = " . $data['txttextarea'] . "<br />";
echo "chktest = " . $data['chktest'] . "<br />";
echo "rndage = " . $data['rndage'] . "<br />";
echo "lst = " . $data['lst'] . "<br />";
echo "drpdown = " . $data['drpdown'] . "<br />";
echo "txtname = " . $data['txtname'] . "<br />";
echo "Avatar = " . $data['Avatar'] . "<br />";
echo "flimage = " . $data['flimage'] . "<br />";
echo "btnSave = " . $data['btnSave'] . "<br />";
}

if(!$Form->Processed()){
echo $Form;
} 