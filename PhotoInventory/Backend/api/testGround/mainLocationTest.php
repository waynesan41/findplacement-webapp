<?php

require_once "../../classes/Filter.php";
require_once "../../classes/MainLocation.php";

// $mainLocObj = new MainLocation(3);

//Getting OWN Main Location
// echo $mainLocObj->getOwnMainLocation();

//Getting SHARED Main Location
// echo $mainLocObj->getShareMainLocation();

//Getting Shared USERS of a Main Location
/* $mainLocObj = new MainLocation(44);
 echo $mainLocObj->getShareduser(12); */

// CHECKING Main Location Owner
/* $mainLocObj = new MainLocation(4);
 echo $mainLocObj->checkOwner(16, 4); */

// CHECK Name of Main Location
/* $mainLocObj = new MainLocation(4);
 $mainLocObj->checkMainName("WearHouse1", 4); */

// CHECK Access Of the User To the Main Location
/* $mainLocObj = new MainLocation(7);
 $mainLocObj->checkShareuserAccess(12, 1); */

// ADD New Main Location
/* $mainLocObj = new MainLocation(3);
$name = "Cyber Power";
$mainLocObj->addNewMain($name); */

// EDIT / UPDATE Main Location
/* $mainLocObj = new MainLocation(3);
$name = "Cyber Power123";
$mainLocObj->updateMain(12, $name); */

// SHARE | INSERT/UPDATE Main Library
/* $mainLocObj = new MainLocation(3);
$mainID = 5;
$shareID = 1;
$access = 6;
$mainLocObj->shareMainLocation($mainID, $shareID, $access); */

// LEAVE | DELETE Shared Main Location
/* $mainLocObj = new MainLocation(3);
 $mainLocObj->leaveSharedMainLocation(7); */

// REMOVE | DELETE User from Own Main Location
/* $mainObj = new MainLocation(3);
 $mainObj->removeShareUser(12, 2); */

// DELETE Own Main Location
$mainObj = new MainLocation(5);
$mainObj->deleteMainLocation(26, "717 Logistics");

?>
