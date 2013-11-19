<?php

// Include Easy form library
include("../lib/init.php");

// Create validators
$EmailValidator = new Base_Validators_Email("Fill in a valid email address.");
$ContainsValidator = new Base_Validators_Contains("It must be an hotmail address.", "hotmail.com");

// Create input fields and textarea
$Email = new Base_Text("Email", "txtemail", "", true, array($EmailValidator, $ContainsValidator), "What’s your email address?"); 
$Subject = new Base_Text("Subject", "txtsubject", "", true, null, "What is the subject of your email?");
$Message = new Base_Textarea("Message", "txtmessage", "", 40, 5, true, null, "Tell me your question.");
$Submit = new Base_Submit("btnsubmit", "Send");

// Create new form
$Form = new Base_Form("Email Form", "frmemail");

// Add input fields and textrarea to the form
$Form->Add($Email);
$Form->Add($Subject);
$Form->Add($Message);
$Form->Add($Submit);

// Set formHandle function as the form processor
$Form->SetPhpCallback("formHandle");

// If data is valid and submitted show thank you message
// and hide the form
if(!$Form->Processed()){
	echo $Form;
}else{
	echo "Thank you";
}

// Form processor function
// $data variable is an array that contains
// all the form data
function formHandle($data){
	echo $data["txtemail"] . "<br />";
	echo $data["txtsubject"] . "<br />";
	echo $data["txtmessage"] . "<br />";
}