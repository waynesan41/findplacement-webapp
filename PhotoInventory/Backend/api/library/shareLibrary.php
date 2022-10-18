<?php

require_once "../checkLogin.php";
require_once "../../classes/Library.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $libraryID = $_POST["libraryID"];
  $userID = $_POST["userID"];
  $access = $_POST["access"];
  $filter = new Filter();

  if (
    $filter->checkInt($libraryID) &&
    $filter->checkInt($userID) &&
    $filter->checkAccessValue($access)
  ) {
    $libraryObj = new Library($_SESSION["userLogin"]);
    $libraryObj->shareLibrary($libraryID, $userID, $access);
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
  $keyAllow = ["libraryID", "userID", "access"];
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
