<?php

require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $locType;
  $mainID;

  //Check Library Type Value
  if ($filter->checkInt($_POST["locType"])) {
    $locType = $_POST["locType"];
  } else {
    echo json_encode("INVALID1");
    return 0; //BREAK//
  }

  $locationObj = new location($_SESSION["userLogin"]);
  $search = $_POST["search"];
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
      if (!$locationObj->checkAccess($mainID, 1)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    }
  } else {
    echo json_encode("INVALID3");
    return 0; //BREAK//
  }

  $locationObj->searchLocation($search, $mainID);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["mainID", "search", "locType"];
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
