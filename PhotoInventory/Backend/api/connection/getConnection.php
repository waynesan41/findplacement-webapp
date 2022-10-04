<?php
require_once "../checkLogin.php";

header("Access-Control-Allow-Methods: POST");
require_once "../../classes/Filter.php";
require_once "../../classes/Connection.php";

if (checkKeys()) {
  $connectionObj = new Connection();
  $connectionObj->setUserID($_SESSION["userLogin"]);
  if ($_POST["type"] == "C") {
    // echo "Type: Connection!\n";
    echo $connectionObj->getConnectedUser();
  } elseif ($_POST["type"] == "B") {
    // echo "Type: Blocked\n";
    echo $connectionObj->getBlockedUser();
  } elseif ($_POST["type"] == "T") {
    // echo "Type: Users you Request To\n";
    echo $connectionObj->getUserRequestTo();
  } elseif ($_POST["type"] == "F") {
    // echo "Type: Users Request From\n";
    echo $connectionObj->getRequestFromUser();
  } else {
    echo "ERROR: Invalid Type / Value!\n";
  }
} else {
  echo "Invalid Key Type!";
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["type"];
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
