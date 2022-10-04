<?php

require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $locType;
  $locationID;
  $mainID;

  //Check Library Type Value
  if ($filter->checkInt($_POST["locType"])) {
    $locType = $_POST["locType"];
  } else {
    echo json_encode("INVALID1");
    return 0; //BREAK//
  }
  //Check locationID Value
  if ($filter->checkInt($_POST["locationID"])) {
    $locationID = $_POST["locationID"];
  } else {
    echo json_encode("INVALID2");
    return 0;
  }

  $locationObj = new location($_SESSION["userLogin"]);

  //Check Libryar ID Value
  if ($filter->checkInt($_POST["mainID"])) {
    //Check User ACCESS to the Library
    $mainID = $_POST["mainID"];
    if ($locType == 1) {
      if (!$locationObj->checkOwn($mainID)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    } elseif ($locType == 2) {
      if (!$locationObj->checkAccess($mainID, 3)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    }
  } else {
    echo json_encode("INVALID3");
    return 0; //BREAK//
  }
  $locationObj->deleteLocation($mainID, $locationID);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["mainID", "locationID", "locType"];
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
