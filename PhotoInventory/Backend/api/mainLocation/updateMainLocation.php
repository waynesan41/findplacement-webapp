<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();

  if (
    !$filter->checkName($_POST["name"]) &&
    $filter->checkInt($_POST["mainID"])
  ) {
    $mainID = $_POST["mainID"];
    $name = $_POST["name"];
    $mainObj = new MainLocation($_SESSION["userLogin"]);
    $mainObj->updateMain($mainID, $name);
  } else {
    echo json_encode("INVALID");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) > 2) {
    return false;
  }
  $keyAllow = ["name", "mainID"];
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
