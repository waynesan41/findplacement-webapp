<?php

require_once "../checkNotLogin.php";

//Class and configs
require_once "../../classes/User.php";

if (checkKeys()) {
  $login = $_POST["login"];
  $pass = $_POST["password"];

  $userObj = new User();

  if ($userObj->login($login, $pass)) {
    // echo 'User and Password Correct! ID: ' . $userObj->id;
    echo json_encode(1);
    $_SESSION["userLogin"] = $userObj->getUserID();
  } else {
    // echo 'User and Password Incorrect!';
    echo json_encode(0);
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["login", "password"];
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
