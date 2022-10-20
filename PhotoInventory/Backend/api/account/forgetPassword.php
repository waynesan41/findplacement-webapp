<?php

require_once "../checkNotLogin.php";

//Class and configs
require_once "../../classes/User.php";
require_once "../../classes/Filter.php";
require_once "../../classes/Mail/Mailer.php";

// SLEEP(1);
if (checkKeys()) {
  $email = $_POST["email"];
  $userObj = new User();
  $filter = new Filter();

  if ($filter->checkEmail($email)) {
    $errorMessage["email"] = "Invalid!";
    $error = true;
    echo json_encode("BAD EMAIL");
  } else {
    $errorMessage["email"] = "";
    // Email Exist Continue To process sending Password Link
    if ($userObj->checkEmailToken($email)) {
      //CREATING TOKEN AND SAVING IT ON DATABASE
      $tokenKey = bin2hex(random_bytes(64));
      if ($userObj->createToken($tokenKey)) {
        //Send Email Here
        // $apiURL = "http://localhost:3000";
        $mailerObj = new Mailer();
        if ($mailerObj->sendEmailLink($tokenKey, $email)) {
          echo json_encode(1);
        } else {
          echo json_encode(0);
        }
      } else {
        echo json_encode("TOKEN FAIL");
      }
    } else {
      // Email Not Found
      echo json_encode(0);
    }
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["email"];
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
