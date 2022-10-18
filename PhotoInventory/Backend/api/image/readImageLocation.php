<?php

require_once "../../classes/MainLocation.php";
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

$mainID = $_GET["id1"];
$locID = $_GET["id2"];

session_start();
if (isset($_SESSION["userLogin"])) {
  $mainObj = new MainLocation($_SESSION["userLogin"]);
  if (isset($_SESSION["mainLocImg"])) {
    if ($_SESSION["mainLocImg"] != $mainID) {
      if (
        $mainObj->checkOwner($mainID) ||
        $mainObj->checkShareUserAccess($mainID, 1)
      ) {
        $_SESSION["mainLocImg"] = $mainID;
      } else {
        die();
      }
    }
  } else {
    if (
      $mainObj->checkOwner($mainID) ||
      $mainObj->checkShareUserAccess($mainID, 1)
    ) {
      $_SESSION["mainLocImg"] = $mainID;
    } else {
      die();
    }
  }
} else {
  echo json_encode(0);
  die();
}

$remoteImage = "../../../../../img/main/$mainID/$locID-1.jpeg";

// echo $remoteImage;

// $imginfo = getimagesize($remoteImage);
header("Content-type: image/jpeg");
readfile($remoteImage);
?>
