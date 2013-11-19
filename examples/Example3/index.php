<?php

error_reporting(E_ALL);

include("../../lib/init.php");
	
$Form = new Base_Form("Image Uploader", "frmimage");
$Form->SetPhpCallback("formHandle");
$Form->Add(new Base_Text("Name", "txtimage", "", true));
$Form->Add(new Base_File("Image", "fileupload", true, array(new Base_Validators_File("This is not a valid image. An image must be of type jpg.", "102400", array("jpg", "gif", "png")), new Base_Validators_Image("Wrong image size", 300, 300))));
$Form->Add(new Base_Submit("btnupload", "Upload"));

function formHandle($data){
	move_uploaded_file($data["fileupload"]["tmp_name"], "upload/" . $data["fileupload"]["name"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Image</title>
<style>
body{
	color:#333333;
	font-family:Arial,sans-serif;
	text-align: center;	
	background-color: #e1eaf3;
	font-size:12px;
}
#wrapper{
	margin: 0 auto;
	text-align: left;
	padding: 30px;
	width: 700px;
	border:1px solid #97AEC9;
	background-color: #FFF;
}
h2{
	border-bottom:1px solid #DCE3EB;
	margin-bottom:15px;	
	font-size:18px;
	line-height:1.5em;
	padding:8px 0 5px;
}
form li{
	list-style: none;
	list-style-type:none;
	margin-bottom: 5px;
	display: block;
	height: 22px;
	padding: 5px;
}
#li_tatext{
	height: 60px;
}
#li_lsttype{
	height: 120px;	
}
form legend{
	font-size:18px;	
	line-height:1.5em;
	padding:8px 5px;
}
form fieldset{
	border:1px solid #d2e8fa;
	margin-bottom:10px;	
	background-color: #fcfeff;
}
form #label_option_rndradio label{
	padding: 0px;	
	width: 50px;
}
form label{
	color:#3E434A;
	cursor:pointer;
	float:left;
	font-size:13px;
	width:100px;
	padding: 3px 10px 0px 5px;
	font-weight:bold;
	text-align: right;
}

form input, form textarea, form select{
	font-family:Arial,sans-serif;
	color:#8B96A4;	
	float: left;
	width:208px;
	font-size:13px;
	line-height:1;
	margin:0;
	padding:3px;
}
form input:focus, form textarea:focus, form select:focus{
	color:#333333;
}
form .description{
	float: left;
	padding-left: 10px;
	padding-top: 3px;
	color:#666666;
	font-style:italic;
}
form .error .description{
	display: none;	
}
form .error{
	background-color:#FFF9D7;
	border-color:#E2C822;	
}
form .errormessage{
	display: inline;
	padding-left: 20px;
	color:#666666;
	font-weight: bold;
}
</style>
</head>
<body>
<div id="wrapper">
<h2>Image Uploader</h2>
<p>This is an image uploader example that shows you how you can validate the image width, hight, size and type before it's uploaded. In this example you can only upload jpeg images that are smaller than 300x300 and are smaller then 100kb</p>
<?php
if(!$Form->Processed()){
	echo $Form;
}else{
	$data = $Form->GetData();
	$currentfile = "upload/" . $data["fileupload"]["name"];	
	echo '<h2>Success</h2><p><img src="' . $currentfile . '" height="40" width="40" align="left" hspace="5" />This is the image that you just uploaded.</p>';
}


?>
</div>
</body>
</html>
