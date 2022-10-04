<?php

require_once "../../classes/Object.php";

// $objectObj = new Objects(3);

//======= GET Library ========//
$objectObj = new Objects(3);
echo $objectObj->getObjects(19);

//======= CHECK Access To Shared Library ========//
/* if ($objectObj->checkAccess(12, 0)) {
  echo "GREEN Access!";
} else {
  echo "NO Access!";
} */

//======= CHECK Own Library ========//
/* if ($objectObj->checkOwn(3)) {
  echo "User is OWNER!";
} else {
  echo "NOT OWNER!";
} */

//======= ADDING New Object to the Library =======//
/* $objectObj = new Objects(3);
$libID = 3;
$name = "wallet";
$objectArr = [];
$objectArr[":photo"] = 4;
$objectArr[":description"] = "5000 kyat";
// var_dump($objectArr);
foreach ($objectArr as $key => $value) {
  echo "key: " . $key . " => Value: " . $value . "\n";
}
$objectObj->addNewObject($libID, $name, $objectArr); */

//========== UPDATING Object to the Library =========//
/* $objectObj = new Objects(3);
$libID = 3;
$objId = 2;
$name = "ipod 3";
$objArr = [];
$objArr[":photo"] = 0;
$objArr[":description"] = "Old but GOOd Ipod.";

foreach ($objArr as $key => $value) {
  echo "key: " . $key . " => Value: " . $value . "\n";
}
$objectObj->updateObject($libID, $objId, $name, $objArr); */

//========= DELETE Object from the Library ============//
/* $objectObj = new Objects(3);
$libID = 3;
$objID = 6;

$objectObj->deleteObject($libID, $objID); */

?>
