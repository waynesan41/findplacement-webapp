<?php

require_once "../../classes/Library.php";
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

$libID = $_GET["id1"];
$objID = $_GET["id2"];

session_start();
if (isset($_SESSION["userLogin"])) {
  $libraryObj = new Library($_SESSION["userLogin"]);
  if (isset($_SESSION["libImg"])) {
    if ($_SESSION["libImg"] != $libID) {
      if (
        $libraryObj->checkOwner($libID) ||
        $libraryObj->checkAccess($libID, 1)
      ) {
        $_SESSION["libImg"] = $libID;
      } else {
        die();
      }
    }
  } else {
    if (
      $libraryObj->checkOwner($libID) ||
      $libraryObj->checkAccess($libID, 1)
    ) {
      $_SESSION["libImg"] = $libID;
    } else {
      die();
    }
  }
} else {
  echo json_encode(0);
  die();
}
$remoteImage = "../../../../../img/lib/$libID/o/$objID-1.jpeg";

// echo $remoteImage;

$imginfo = getimagesize($remoteImage);
header("Content-type: image/jpeg");
readfile($remoteImage);

?>
