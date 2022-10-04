<?php
require_once "../checkLogin.php";
require_once "../../classes/Object.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();

  //Filter Input Validation.
  if (!$filter->checkLibraryType($_POST["libType"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["libraryID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }

  $libType = $_POST["libType"];
  $libraryId = $_POST["libraryID"];
  $objectIns = new Objects($_SESSION["userLogin"]);

  if ($libType == 1) {
    if (!$objectIns->checkOwn($libraryId)) {
      echo json_encode("ACCESS DENY");
      return false; //Break
    }
  }
  if ($libType == 2) {
    if (!$objectIns->checkAccess($libraryId, 1)) {
      echo json_encode("ACCESS DENY");
      return false; //BREAK
    }
  }
  //Everything is Good Ready to Fetch it from SQL Database
  $objectIns->getObject($libraryId);
} else {
  echo json_encode("BAD KEY!");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["libraryID", "libType"];
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
