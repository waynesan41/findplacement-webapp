<?php

require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $locType;
  $locationID;
  $mainID;

  if ($filter->checkInt($_POST["locType"])) {
    $locType = $_POST["locType"];
  } else {
    echo json_encode("INVALID");
    return 0; //BREAK//
  }
  if ($filter->checkInt($_POST["locationID"])) {
    $locationID = $_POST["locationID"];
  } else {
    echo json_encode("INVALID");
    return 0;
  }
  if (!$filter->checkIntZero($_POST["topID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }

  $topID = $_POST["topID"];
  $locationObj = new location($_SESSION["userLogin"]);

  if ($topID == $locationID) {
    echo json_encode("FAIL");
    return 0;
  }
  if ($filter->checkInt($_POST["mainID"])) {
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
    echo json_encode("INVALID");
    return 0; //BREAK//
  }
  $locationObj->moveLocation($mainID, $locationID, $topID);
} else {
  echo json_encode("BAD ");
}

function checkKeys()
{
  if (empty($_POST)) {
    echo "empty keys";
    return false;
  }
  $keyAllow = ["mainID", "locationID", "locType", "topID"];
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
