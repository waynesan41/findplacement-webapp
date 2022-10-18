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
  $newPassword;
  //Filter the Token Key String
  if ($filter->checkTokenString($tokenKey)) {
    //Check Database if the Key is Still Alive.
    if ($userObj->checkTokenAlive($tokenKey)) {
      //Check Password String
      $newPassword = $_POST["newPassword"];
      if (!$filter->checkPassword($newPassword)) {
        //Update Password
        if ($userObj->updatePassword($newPassword)) {
          if ($userObj->deleteToken()) {
            echo json_encode("UPDATED");
          } else {
            echo json_encode("BAD DATA");
          }
        }
      } else {
        echo json_encode("BAD PASSWORD");
      }
    } else {
      echo json_encode("BAD TOKEN");
    }
  } else {
    echo json_encode("BAD KEY");
  }

  //************************************************************* */
  //***** Password Update ***** */
  /* if (isset($_POST["password1"]) && isset($_POST["password2"])) {
    
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
  } */

  //Returning Response as JSON.
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["newPassword", "tokenKey"];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      return false;
    }
  }
  return true;
}

?>
