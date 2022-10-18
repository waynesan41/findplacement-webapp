<?php
session_start();
require_once "../../classes/User.php";
if (isset($_SESSION["userLogin"])) {
  echo "current Session: " . $_SESSION["userLogin"];

  $userObj = new User();
  $userObj->setUserID($_SESSION["userLogin"]);

  echo json_encode($userObj->getUserProfile());
} else {
  echo "User SESSIONG is NOT Set!\n";
}

?>
