<?php

require_once "../checkLogin.php";
require_once "../../classes/User.php";

if (isset($_SESSION["userLogin"])) {
  $userObj = new User();
  $userObj->setUserID($_SESSION["userLogin"]);

  echo json_encode($userObj->getUserProfile());
} else {
  echo "Cannot get Profile Info, User not Login!";
}
?>
