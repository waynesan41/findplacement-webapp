<?php

require_once "../checkLogin.php";
require_once "../../classes/Object.php";
require_once "../../classes/Filter.php";
require_once "../../classes/Image.php";

if (checkKeys()) {
  $filter = new Filter();
  $libType;
  $objectID;
  $libraryID;

  //Check Library Type Value
  if ($filter->checkLibraryType($_POST["libType"])) {
    $libType = $_POST["libType"];
  } else {
    echo json_encode("INVALID");
    return 0; //BREAK//
  }
  //Check ObjectID Value
  if ($filter->checkInt($_POST["objectID"])) {
    $objectID = $_POST["objectID"];
  } else {
    echo json_encode("INVALID");
    return 0;
  }

  $objectIns = new Objects($_SESSION["userLogin"]);

  //Check Libryar ID Value
  if ($filter->checkInt($_POST["libraryID"])) {
    //Check User ACCESS to the Library
    $libraryID = $_POST["libraryID"];
    if ($libType == 1) {
      if (!$objectIns->checkOwn($libraryID)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    } elseif ($libType == 2) {
      if (!$objectIns->checkAccess($libraryID, 3)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    }
  } else {
    echo json_encode("INVALID");
    return 0; //BREAK//
  }
  if ($objectIns->deleteObject($libraryID, $objectID)) {
    $imgObj = new Image($libType);
    $imgObj->deleteImage($libraryID, $objectID, 1, 2);
  }
} else {
  echo json_encod("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST)) {
    echo "empty keys";
    return false;
  }
  $keyAllow = ["libraryID", "objectID", "libType"];
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
