<?php
require_once "../checkLogin.php";

header("Access-Control-Allow-Methods: POST");
require_once "../../classes/Filter.php";
require_once "../../classes/Connection.php";

if (checkKeys()) {
  $filterObj = new Filter();

  if ($filterObj->checkUsernameSearch($_POST["username"])) {
    echo json_encode("NO USER");
  } else {
    // echo "GOOD Username!";
    $connectionObj = new Connection();
    $connectionObj->setUserID($_SESSION["userLogin"]);
    echo $connectionObj->searchUser($_POST["username"]);
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["username"];
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
