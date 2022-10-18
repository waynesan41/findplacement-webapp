<?php
require_once "../checkLogin.php";

header("Access-Control-Allow-Methods: POST");
require_once "../../classes/Filter.php";
require_once "../../classes/Connection.php";

if (checkKeys()) {
  $filterObj = new Filter();

  if (checkValue() && $filterObj->checkUserID($_POST["userID"])) {
    $connObj = new Connection();
    $connObj->setUserID($_SESSION["userLogin"]);
    $userID = $_POST["userID"];
    if ($_POST["update"] == "S") {
      // echo "Send Request.\n";
      $connObj->sendRequestTo($userID);
    } elseif ($_POST["update"] == "A") {
      // echo "Accept Request\n";
      $connObj->acceptRequestFrom($userID);
    } elseif ($_POST["update"] == "C") {
      // echo "Cancel Request\n";
      $connObj->cancelRequestTo($userID);
    } elseif ($_POST["update"] == "D") {
      // echo "Deny Request\n";
      $connObj->denyRequestFrom($userID);
    } elseif ($_POST["update"] == "B") {
      // echo "Block User\n";
      $connObj->blockUser($userID);
    } elseif ($_POST["update"] == "R") {
      // echo "Remove Connection.\n";
      $connObj->removeConnection($userID);
    } elseif ($_POST["update"] == "U") {
      // echo "Unblock User.\n";
      $connObj->unblockUser($userID);
    } else {
      echo "This should never be display!!!";
    }
  } else {
    echo "Bad Value!";
  }
} else {
  echo "Invalid Keys!";
}

function checkValue()
{
  $valueAllow = ["S", "A", "C", "D", "B", "R", "U"];
  foreach ($valueAllow as $value) {
    if ($value == $_POST["update"]) {
      return true;
    }
  }
  return false;
}
function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["userID", "update"];
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
