<?php

require_once "../../classes/Filter.php";
require_once "../../classes/Location.php";

// $locationObj = new location(3);

//Getting Location of a Main Location
// echo $locationObj->getLocation(12, 9);

//ADD New Location to Main Location
/* $locationObj = new location(3);
$locArr = [];
// $locArr[":photo"] = 1;
$locArr[":description"] = "Don't put anything here";
$locationObj->addNewLocation(12, 9, "No PHotos", $locArr); */

// UPDATE New Location to Main
/* $locationObj = new Location(3);
$locArr = [];
$locArr[":photo"] = 1;
$locArr[":description"] = "Change In Description!!\n";
$locationObj->updateLocation(12, 20, "78456", $locArr); */

// DELET a Location
/* $locationObj = new Location(3);
 $locationObj->deleteLocation(12, 20); */

// GET Top Location ID
/* $locationObj = new Location(3);
 $locationObj->checkTopLocation(12, 11, 18); */

// MOVEING Location / UPDATE Top Location ID
/* $locationObj = new Location(3);
 $locationObj->moveLocation(12, 9, 19); */

// CHECK Owner to a Main Location
/* $locationObj = new Location(3);
if ($locationObj->checkOwn(12)) {
  echo "you own the location...\n";
} else {
  echo "YOU DON'T OWN THE LOCATION!!!\n";
} */

// CHECK Access to the Main Location
$locationObj = new Location(3);
if ($locationObj->checkAccess(11, 3)) {
  echo "You have Access to the location...\n";
} else {
  echo "YOU DON'T HAVE ACCESS TO THE LOCATION!!!\n";
}

// CHECK Top Location Exists
/* $locationObj = new Location(3);
$locationObj->checkTopExists(11, 222);
 */

?>
