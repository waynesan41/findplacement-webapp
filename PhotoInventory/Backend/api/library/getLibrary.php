<?php

require_once "../checkLogin.php";
require_once "../../classes/Library.php";

if (checkKeys()) {
  $libraryObj = new Library($_SESSION["userLogin"]);

  if ($_POST["library"] == 1) {
    // echo "Return OWN Json";
    $libraryObj->getOwnLibrary();
  } elseif ($_POST["library"] == 2) {
    // echo "Return SHARED Json";
    $libraryObj->getSharedLibrary();
  } else {
    echo json_encode("INVALID");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    echo "post is empty";
    return false;
  }
  $keyAllow = ["library"];
  foreach (array_keys($_POST) as $key) {
    if (!in_array($key, $keyAllow)) {
      echo "key not in array";
      return false;
    } else {
      return true;
    }
  }
}

?>
