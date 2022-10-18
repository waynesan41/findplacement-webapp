<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $mainObj = new MainLocation($_SESSION["userLogin"]);
  $mainID = $_POST["mainID"];
  if ($filter->checkInt($mainID)) {
    echo $mainObj->getNewUser($mainID);
    // echo $mainObj->getOwner($mainID);
  } else {
    echo "BAD MAIN LOCATION ID VALUE!!!\n";
  }
} else {
  echo "INVALID KEY!!!\n";
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) > 1) {
    return false;
  }
  $keyAllow = ["mainID"];
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
