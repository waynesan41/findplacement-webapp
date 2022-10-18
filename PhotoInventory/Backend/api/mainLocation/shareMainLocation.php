<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $mainID = $_POST["mainID"];
  $userID = $_POST["userID"];
  $access = $_POST["access"];
  if (
    $filter->checkInt($mainID) &&
    $filter->checkInt($userID) &&
    $filter->checkAccessValue($access)
  ) {
    $mainObj = new MainLocation($_SESSION["userLogin"]);
    $mainObj->shareMainLocation($mainID, $userID, $access);
  } else {
    echo json_encode("INVALID");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) > 3) {
    return false;
  }
  $keyAllow = ["mainID", "userID", "access"];
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
