<?php
require_once "../checkLogin.php";
require_once "../../classes/ObjectLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();

  if (!$filter->checkInt($_POST["mainID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["locID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["objID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["libID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }

  $mainID = $_POST["mainID"];
  $locID = $_POST["locID"];
  $objID = $_POST["objID"];
  $libID = $_POST["libID"];

  $objLocIns = new ObjectLocation($_SESSION["userLogin"]);

  if (
    !$objLocIns->checkMainLoc($mainID, 2) &&
    !$objLocIns->checkMainLoc($mainID, 0)
  ) {
    echo json_encode("DENY");
    return false; //Break
  }
  if (
    !$objLocIns->checkLibrary($libID, 2) &&
    !$objLocIns->checkLibrary($libID, 0)
  ) {
    echo json_encode("DENY");
    return false; //Break
  }
  /*   if (!$objLocIns->checkMainLibrary($mainID, $libID)) {
    echo "MAIN LOCATION AND LIBRARY DOESN'T HAVE SAME OWNER!!!\n";
    return false; //Break
  } */

  $objLocIns->deleteObjLoc($locID, $mainID, $objID, $libID);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["mainID", "locID", "objID", "libID"];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      return false;
    }
  }
  $arrayDiff = array_diff($keyAllow, array_keys($_POST));
  if (empty($arrayDiff)) {
    return true;
  } else {
    return false;
  }
}
?>
