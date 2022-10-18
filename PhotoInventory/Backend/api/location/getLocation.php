<?php
require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();

  //Filter Input Validation.
  if (!$filter->checkType($_POST["locType"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["mainID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkIntZero($_POST["topID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }

  $locType = $_POST["locType"];
  $mainID = $_POST["mainID"];
  $topID = $_POST["topID"];
  $locationObj = new Location($_SESSION["userLogin"]);

  if ($locType == 1) {
    if (!$locationObj->checkOwn($mainID)) {
      echo json_encode("DENY");
      return false; //Break
    }
  }
  if ($locType == 2) {
    if (!$locationObj->checkAccess($mainID, 1)) {
      echo json_encode("DENY");
      return false; //BREAK
    }
  }
  //Everything is Good Ready to Fetch it from SQL Database
  echo $locationObj->getLocation($mainID, $topID);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["mainID", "locType", "topID"];
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
