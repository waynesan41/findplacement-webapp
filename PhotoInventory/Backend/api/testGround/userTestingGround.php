<?php
require_once "../../classes/MainLocation.php";
require_once "../../classes/Library.php";

$mainObj = new MainLocation(12);
$libObj = new Library(12);

echo "max main: " . $mainObj->getNewMainID() . "\n";
echo "max lib: " . $libObj->getNewLibID() . "\n";
?>
