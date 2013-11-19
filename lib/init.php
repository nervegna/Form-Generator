<?php

$path = str_replace(array("\\", "init.php"), array("/", ""), __FILE__);

include($path . "Element.php");
include($path . "File.php");
include($path . "Text.php");
include($path . "Form.php");
include($path . "Button.php");
include($path . "Checkbox.php");
include($path . "Field.php");
include($path . "Radio.php");
include($path . "Select.php");
include($path . "Textarea.php");
include($path . "Validator.php");