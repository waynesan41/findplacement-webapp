<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

require_once "../checkNotLogin.php";
require_once "../../classes/User.php";
require_once "../../classes/Filter.php";
if (checkKeys()) {
  $userObj = new User();
  $filter = new Filter();

  $tokenKey = $_POST["tokenKey"];

  //Filter the Token Key String
  if ($filter->checkTokenString($tokenKey)) {
    //Check Database if the Key is Still Alive.
    if ($userObj->checkTokenAlive($tokenKey)) {
      echo json_encode("GOOD");
    } else {
      echo json_encode("BAD TOKEN");
    }
  } else {
    echo json_encode("BAD TOKEN1");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["tokenKey"];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      return false;
    }
  }
  return true;
}

?>
