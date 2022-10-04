<?php

require_once "../checkLogin.php";
require_once "../../classes/Library.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $libraryID = $_POST["libraryID"];

  if ($filter->checkInt($libraryID)) {
    $libObj = new Library($_SESSION["userLogin"]);
    if ($_POST["type"] == 1) {
      // echo "Return OWN Json";
      echo $libObj->getOwnLibraryInfo($libraryID);
    } elseif ($_POST["type"] == 2) {
      // echo "Return SHARED Json";
      echo $libObj->getShareLibraryInfo($libraryID);
    } else {
      echo json_encode("INVALID");
    }
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
  $keyAllow = ["libraryID", "type"];
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
