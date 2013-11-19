<?php
include("../../lib/init.php");
	
$Form = new Base_Form("Website information", "frmsite");
$Form->SetPhpCallback("formHandle");
$Form->SetRequiredContent("(required)", "This field is required");
$Form->Add(new Base_Text("Sitename", "txtsite", "", true, null, "Some extra information about the Sitename field."));
$Form->Add(new Base_Text("Site address", "txturl", "", true, new Base_Validators_Email("What's the URL of your website."), "Some extra information about the Site address field."));
$Form->Add(new Base_Field("Details"));
$Form->Add(new Base_Radio("Visitors/Month", "rndvisits", array('dontknow' => 'don\'t know' ,'less100' => 'Less than 100', 'less1000' => 'Less than 1000', 'less10000' => 'Less than 10000', 'more10000' => 'More than 10000'), 'dontknow', true, 'How many visitors you have monthly.'));
$Form->Add(new Base_Checkbox("I developed this site", "chkdeveloper", "true", false, true, 'How many visitors you have monthly.'));
$Form->Add(new Base_Textarea("Description", "txtdescription", "", 50, 10, true, new Base_Validators_NotEmpty("Don't forget to type in a description."), "Tell us some thing about your website."));
$Form->Add(new Base_Submit("btncontact", "Send"));

function formHandle($data){
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact form</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<h2>Website information</h2>
<p>This is an example of an contact form created with EasyForm.</p>
<?php
if(!$Form->Processed()){
	echo $Form;
}else{
	echo '<h2>Thank you</h2><p>Thanks for sending us an email.</p>';
}


?>
</div>
</body>
</html>
