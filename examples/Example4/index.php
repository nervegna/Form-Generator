<?php
include("../../lib/init.php");
	
$Form = new Base_Form("Personal information", "frmcontact");
$Form->SetPhpCallback("formHandle");
$Form->SetRequiredContent("(required)");
$Form->Add(new Base_Text("Name", "txtname", "", true, new Base_Validators_NotEmpty("Fill in your name.")));
$Form->Add(new Base_Text("Email", "txtemail", "", true, new Base_Validators_Email("Fill in a valid email address.")));
$Form->Add(new Base_Field("Message"));
$Form->Add(new Base_Text("Subject", "txtsubject", "", true, new Base_Validators_NotEmpty("What's the subject of this email.")));
$Form->Add(new Base_Textarea("Message", "txtmessage", "", 50, 10, true, new Base_Validators_NotEmpty("Don't forget to type in a message.")));
$Form->Add(new Base_Submit("btncontact", "Send"));

function formHandle($data){
	$to      = 'wim@sitebase.be';
	$subject = $data['txtsubject'];
	$message = $data['txtmessage'];
	$headers = 'From: ' . $data['txtemail'] . "\r\n" .
		'Reply-To: ' . $data['txtemail'] . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
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
<h2>Contact form</h2>
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
