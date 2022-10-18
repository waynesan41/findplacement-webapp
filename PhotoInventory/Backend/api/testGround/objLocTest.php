<?php

require_once "../../classes/Filter.php";
require_once "../../classes/ObjectLocation.php";

//Getting Objects from a Location
$objLocIns = new ObjectLocation(3);
echo $objLocIns->getObjLoc(8, 12, 1);

// UPDATE | EDIT Objects in Location
/* $objLocIns = new ObjectLocation(3);
$editArr = [];
// $editArr[":quantity"] = 41;
$editArr[":description"] = "not iphone";
$objLocIns->updateObjLoc(9, 12, 13, 15, $editArr); */

// INSERT | ADD New Objects in a Location
/* $objLocIns = new ObjectLocation(3);
$editArr = [];
$editArr[":quantity"] = 33;
$editArr[":description"] = "IPHONE.";
$objLocIns->addObjLoc(9, 12, 13, 15, $editArr); */

// DELETE | REMOVE Object from Location
/* $objLocIns = new ObjectLocation(3);
 $objLocIns->deleteObjLoc(9, 12, 13, 15); */

// CHECK Main Library Owner Match
/* $objLocIns = new ObjectLocation(3);
if ($objLocIns->checkMainLibrary(17, 125)) {
  echo "Match...\n";
} else {
  echo "DOESN'T MATCH!!!\n";
} */

// CHECK Main Location Own / Shared
/* $objLocIns = new ObjectLocation(3);
$objLocIns->checkMainLoc(11, 1);
$objLocIns->checkLibrary(20, 1); */

?>
