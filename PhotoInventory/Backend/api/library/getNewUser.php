<?php

require_once "../checkLogin.php";
require_once "../../classes/Library.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $libObj = new Library($_SESSION["userLogin"]);
  $libraryID = $_POST["libraryID"];
  if ($filter->checkInt($libraryID)) {
    echo $libObj->getNewUser($libraryID);
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
