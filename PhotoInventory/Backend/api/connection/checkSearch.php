<?php

require_once "../checkLogin.php";

header("Access-Control-Allow-Methods: POST");
require_once "../../classes/Filter.php";
require_once "../../classes/Connection.php";

if (checkKeys()) {
  $filterObj = new Filter();
  if ($filterObj->checkInt($_POST["userID"])) {
    $connectionObj = new Connection();
    $connectionObj->setUserID($_SESSION["userLogin"]);

    $connectionObj->checkSearchUser($_POST["userID"]);
  } else {
    echo json_encode("BAD ID");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["userID"];
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
