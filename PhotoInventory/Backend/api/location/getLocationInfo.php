<?php

require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $locationID = $_POST["locationID"];
  $mainID = $_POST["mainID"];

  if ($filter->checkInt($locationID) && $filter->checkInt($mainID)) {
    $mainObj = new Location($_SESSION["userLogin"]);
    echo $mainObj->getLocationInfo($mainID, $locationID);
  } else {
    echo json_encode("INVALID");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["locationID", "mainID"];
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
