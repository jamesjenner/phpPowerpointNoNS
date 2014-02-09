<html>
<head>
<title>Process Uploaded File</title>
</head>
<body>
<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

ini_set('error_log', 'errors.log');  
ini_set('log_errors', 'On');

echo "file is " . $_FILES['uploadFile'] ['tmp_name'] . "<br><br>";

$target_file = $_FILES['uploadFile'] ['tmp_name'];

define ('BASE_PATH', dirname(__FILE__));
define ('PHP_POWERPOINT', BASE_PATH . '/lib/');

/*
function __autoload($class) {
	// convert namespace to full file path
	$class = str_replace('\\', '/', $class) . '.php';
	require_once($class);
}
 */

// use phpoffice\powerpoint\PowerPoint;

echo "BASE_PATH     : " . BASE_PATH . '<br>';
echo "PHP_POWERPOINT: " . PHP_POWERPOINT . '<br><br>';

echo "including powerpoint lib<br>";
include PHP_POWERPOINT . 'PowerPoint.php';
echo "loading powerpoint<br>";

$powerpoint = new Powerpoint($target_file);
echo "building powerpoint<br>";
$powerpoint->buildAll();

echo "Number of slides:   " . $powerpoint->getNumberOfSlides() . "<br>";
echo "The first slide is: " . $powerpoint->getSlide(0)->filename . "<br>";

echo $powerpoint->getHTML("page", "[", "]");
unlink($_FILES['uploadFile'] ['tmp_name']);
echo "<br>file removed<br>";

?>

</body>
</html>
