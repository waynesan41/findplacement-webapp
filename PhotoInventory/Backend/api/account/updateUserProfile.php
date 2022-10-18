<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

require_once "../checkLogin.php";
require_once "../../classes/User.php";
require_once "../../classes/Filter.php";
if (checkKeys()) {
  $userObj = new User();
  $filter = new Filter();
  $userObj->setUserID($_SESSION["userLogin"]);
  $echoArray = [];
  //************************************************************* */
  //***** Name Update ***** */
  if (isset($_POST["fullName"])) {
    $fullName = $_POST["fullName"];

    if (!$filter->checkName($fullName)) {
      if ($userObj->updateName($fullName)) {
        $echoArray["NAME"] = "GOOD";
      } else {
        $echoArray["NAME"] = "INVALID";
      }
    } else {
      $echoArray["NAME"] = "INVALID";
    }
  }

  //************************************************************* */
  //***** Username Update ***** */
  if (isset($_POST["username"])) {
    $username = $_POST["username"];
    if ($filter->checkUsername($username)) {
      $echoArray["USERNAME"] = "INVALID";
    } elseif ($userObj->checkUsernameExists($username)) {
      $echoArray["USERNAME"] = "TAKEN";
    } else {
      if ($userObj->updateUsername($username)) {
        $echoArray["USERNAME"] = "GOOD";
      }
    }
  }
  //************************************************************* */
  //***** Email Update ***** */
  if (isset($_POST["email"])) {
    $email = $_POST["email"];

    if ($filter->checkEmail($email)) {
      $echoArray["EMAIL"] = "INVALID";
    } elseif ($userObj->checkEmailExists($email)) {
      $echoArray["EMAIL"] = "TAKEN";
    } else {
      if ($userObj->updateEmail($email)) {
        $echoArray["EMAIL"] = "GOOD";
      }
    }
  }
  //************************************************************* */
  //***** Password Update ***** */
  if (isset($_POST["password1"]) && isset($_POST["password2"])) {
    $oldPassword = $_POST["password1"];
    $newPassword = $_POST["password2"];
    if (
      // $filter->checkPassword($oldPassword) ||
      $filter->checkPassword($newPassword)
    ) {
      $echoArray["PASSWORD"] = "INVALID";
    } elseif (!$userObj->checkOldPassword($oldPassword)) {
      $echoArray["PASSWORD"] = "WRONG";
    } else {
      if ($userObj->updatePassword($newPassword)) {
        $echoArray["PASSWORD"] = "GOOD";
      }
    }
  }
  //************************************************************* */
  //***** Unit Update ***** */
  if (isset($_POST["unit"])) {
    $unit = $_POST["unit"];
    if ($filter->checkUnit($unit)) {
      if ($userObj->updateUnit($unit)) {
        $echoArray["UNIT"] = "UPDATED!";
      }
    } else {
      $echoArray["UNIT"] = "INVALID";
    }
  }

  //Returning Response as JSON.
  echo json_encode($echoArray);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = [
    "fullName",
    "username",
    "password1",
    "password2",
    "email",
    "unit",
  ];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      return false;
    }
  }
  return true;
}

?>
