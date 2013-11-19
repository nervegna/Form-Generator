<?php
include("../../lib/init.php");
	
$Form = new Base_Form("Subscribe", "frmsubscribe");
$Form->SetPhpCallback("formHandle");
$Form->Add(new Base_Text("Name", "txtname", "", true, new Base_Validators_NotEmpty("Don't forget to fill in your name.")));
$Form->Add(new Base_Text("Email", "txtemail", "", true, new Base_Validators_Email("Fill in a valid email address.")));
$Form->Add(new Base_Submit("btnsubmit", "Send"));

function formHandle($data){

	// Create file if not exist/Read if file exists
	$content = "";
	if(!file_exists("subscribers.csv")){
		$fileHandle = fopen("subscribers.csv", 'w') or die("can't open file");
		fclose($fileHandle);
	}else{
		$content = file_get_contents("subscribers.csv");
	}
	
	// Add new content to variable
	$content .= $data['txtname'] . ";" . $data['txtemail'] . "\n";
	
	// Save content to file
	file_put_contents("subscribers.csv", $content);
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Email Subscribe</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<h2>Email Subscribe</h2>
<p>An example of a subscribe form that save the data in a CSV file.</p>
<?php
if(!$Form->Processed()){
	echo $Form;
}else{
	echo "<h2>Success</h2><p>We added your name to the subscriberslist and will send you all to newest features.</p>";
}


?>
</div>
</body>
</html>
