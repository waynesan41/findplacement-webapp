<?php
require_once "../checkLogin.php";
require_once "../../classes/ObjectLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  if (!$filter->checkType($_POST["type"])) {
    echo json_encode("INVALID1");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["mainID"])) {
    echo json_encode("INVALID2");
    return false; //Break
  }

  $mainID = $_POST["mainID"];
  $type = $_POST["type"];
  $objLocIns = new ObjectLocation($_SESSION["userLogin"]);
  if ($type == 1) {
    if (!$objLocIns->checkMainLoc($mainID, 0)) {
      echo json_encode("DENY");
      return false; //Break
    }
  } elseif ($type == 2) {
    if (!$objLocIns->checkMainLoc($mainID, 1)) {
      echo json_encode("DENY123");
      return false;
    }
  }

  echo $objLocIns->getAccessLibrary($mainID, $type);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["mainID", "type"];
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
