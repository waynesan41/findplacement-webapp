<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  if (
    $filter->checkInt($_POST["mainID"]) &&
    $filter->checkInt($_POST["userID"])
  ) {
    $userID = $_POST["userID"];
    $mainID = $_POST["mainID"];
    $mainObj = new MainLocation($_SESSION["userLogin"]);
    $mainObj->removeShareUser($mainID, $userID);
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
  $keyAllow = ["mainID", "userID"];
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
