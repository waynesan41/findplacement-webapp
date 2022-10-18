<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $mainObj = new MainLocation($_SESSION["userLogin"]);

  if ($_POST["mainLocation"] == 1) {
    echo $mainObj->getOwnMainLocation();
  } elseif ($_POST["mainLocation"] == 2) {
    echo $mainObj->getShareMainLocation();
  } else {
    echo json_encode("INVALID");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) > 1) {
    return false;
  }
  $keyAllow = ["mainLocation"];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      return false;
    }
  }
  return true;
}

?>
