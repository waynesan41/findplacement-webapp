<?php

require_once "../checkLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $mainID = $_POST["mainID"];

  if ($filter->checkInt($mainID)) {
    $mainObj = new MainLocation($_SESSION["userLogin"]);
    if ($_POST["type"] == 1) {
      // echo "Return OWN Json";
      echo $mainObj->getOwnMainInfo($mainID);
    } elseif ($_POST["type"] == 2) {
      // echo "Return SHARED Json";
      echo $mainObj->getShareMainInfo($mainID);
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
  $keyAllow = ["mainID", "type"];
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
