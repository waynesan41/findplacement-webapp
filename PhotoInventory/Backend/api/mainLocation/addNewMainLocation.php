<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();

  if (!$filter->checkName($_POST["name"])) {
    $name = $_POST["name"];
    $mainObj = new MainLocation($_SESSION["userLogin"]);
    if ($mainObj->addNewMain($name)) {
      if (!is_dir("../../../../../img/main/" . $mainObj->newMainID)) {
        mkdir("../../../../../img/main/" . $mainObj->newMainID);
        mkdir("../../../../../img/main/" . $mainObj->newMainID . "/o");
      }
    }
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
  $keyAllow = ["name"];
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
