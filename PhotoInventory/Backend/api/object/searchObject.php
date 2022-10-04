<?php
require_once "../checkLogin.php";
require_once "../../classes/Object.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  //Filter Input Validation.
  if (!$filter->checkLibraryType($_POST["libType"])) {
    echo json_encode("INVALID TYPE");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["libraryID"])) {
    echo json_encode("INVALID ID");
    return false; //Break
  }
  if ($filter->checkSearchFilter($_POST["filter"])) {
    echo json_encode("INVALID");
    return false; //Break
  }

  if (!$filter->checkSearchObjectName($_POST["search"])) {
    echo json_encode("INVALID NAME");
    return false;
  }
  $libType = $_POST["libType"];
  $libraryID = $_POST["libraryID"];
  $objectIns = new Objects($_SESSION["userLogin"]);
  $search = $_POST["search"];
  $filter = $_POST["filter"];

  if ($libType == 1) {
    if (!$objectIns->checkOwn($libraryID)) {
      echo json_encode("ACCESS DENY");
      return false; //Break
    }
  }
  if ($libType == 2) {
    if (!$objectIns->checkAccess($libraryID, 1)) {
      echo json_encode("ACCESS DENY");
      return false; //BREAK
    }
  }

  $objectIns->searchObject($search, $libraryID, $filter);
} else {
  echo json_encode("BAD KEY!");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["libraryID", "search", "libType", "filter"];
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
