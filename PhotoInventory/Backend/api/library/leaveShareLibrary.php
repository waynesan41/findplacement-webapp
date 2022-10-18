<?php

require_once "../checkLogin.php";
require_once "../../classes/Library.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $libraryID = $_POST["libraryID"];
  $filter = new Filter();

  if ($filter->checkInt($libraryID)) {
    $libraryObj = new Library($_SESSION["userLogin"]);
    $libraryObj->leaveShareLibrary($libraryID);
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
  $keyAllow = ["libraryID"];
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
