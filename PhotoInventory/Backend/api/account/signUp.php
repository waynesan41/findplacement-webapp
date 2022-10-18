<?php
require_once "../checkNotLogin.php";
require_once "../../classes/MainLocation.php";
require_once "../../classes/Library.php";

header("Content-Type: application/json");
// header('Content-Type: ');
header("Access-Control-Allow-Methods: POST");
// header('Access-Control-Allow-Origi');

require_once "../../classes/User.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $fullName = $_POST["fullName"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $error = false;
  $errorMessage = [];

  $userObj = new User();
  $filter = new Filter();
  // fullName Validate
  if ($filter->checkName($fullName)) {
    $errorMessage["fullName"] = "Invalid!";
    $error = true;
  } else {
    $errorMessage["fullName"] = "GOOD!";
  }
  // Username Validate
  if ($filter->checkUsername($username)) {
    $errorMessage["username"] = "Invalid!";
    $error = true;
  } else {
    $errorMessage["username"] = "";
  }
  // Email Validate
  if ($filter->checkEmail($email)) {
    $errorMessage["email"] = "Invalid!";
    $error = true;
  } else {
    $errorMessage["email"] = "";
  }
  // Password Validate
  if ($filter->checkPassword($password)) {
    $errorMessage["password"] = "Invalid!";
    $error = true;
  } else {
    $errorMessage["password"] = "GOOD!";
  }
  // Check Email or Username Exists
  if ($errorMessage["username"] == "" && $errorMessage["email"] == "") {
    if ($userObj->checkUsernameExists($username)) {
      $errorMessage["username"] = "Taken";
      $error = true;
    } else {
      $errorMessage["username"] = "GOOD!";
    }

    if ($userObj->checkEmailExists($email)) {
      $errorMessage["email"] = "Taken";
      $error = true;
    } else {
      $errorMessage["email"] = "GOOD!";
    }
  }
  //Execute Query Create New User in Database.
  if (!$error) {
    if ($userObj->createNewUser($fullName, $username, $email, $password)) {
      // session_start();
      $_SESSION["userLogin"] = $userObj->getUserID();
      $mainObj = new MainLocation($_SESSION["userLogin"]);
      $libObj = new Library($_SESSION["userLogin"]);
      if (!is_dir("../../../../../img/user/" . $userObj->getUserID())) {
        mkdir("../../../../../img/user/" . $userObj->getUserID());
      }
      if (!is_dir("../../../../../img/main/" . $mainObj->getNewMainID())) {
        mkdir("../../../../../img/main/" . $mainObj->getNewMainID());
        mkdir("../../../../../img/main/" . $mainObj->getNewMainID() . "/o");
      }
      if (!is_dir("../../../../../img/lib/" . $libObj->getNewLibID())) {
        mkdir("../../../../../img/lib/" . $libObj->getNewLibID());
        mkdir("../../../../../img/lib/" . $libObj->getNewLibID() . "/o");
      }

      echo json_encode(1);
    } else {
      echo json_encode(["message" => "DATABASE ERROR!"]);
    }
  } else {
    echo json_encode($errorMessage);
  }
}

// End of Filters and Query Check.
else {
  echo json_encode(["message" => "BAD KEYS"]);
}
function checkKeys()
{
  // var_dump($_POST);
  if (empty($_POST)) {
    echo "empty keys";
    return false;
  }
  $keyAllow = ["email", "fullName", "username", "password"];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      echo "Unknow Key";
      return false;
    }
  }
  $arrayDiff = array_diff($keyAllow, array_keys($_POST));
  if (empty($arrayDiff)) {
    return true;
  } else {
    echo "Not all keys r here";
    return false;
  }
}

?>
