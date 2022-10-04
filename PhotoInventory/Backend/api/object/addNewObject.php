<?php

require_once "../checkLogin.php";
require_once "../../classes/Object.php";
require_once "../../classes/Image.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $libType;
  $libraryID;
  $name;
  $objectDataArr = [];

  //Check Library Type Value
  if ($filter->checkLibraryType($_POST["libType"])) {
    $libType = $_POST["libType"];
  } else {
    echo json_encode("INVALID");
    return false; //BREAK//
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
      if (!$objectIns->checkAccess($libraryID, 2)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    }
  } else {
    echo json_encode("INVALID4");
    return 0; //BREAK//
  }

  //There is NO Need to Check name If User DON'T Have Permission to Access the Objects.
  //Check Object Name
  if ($filter->checkObjectName($_POST["name"])) {
    $name = $_POST["name"];
  } else {
    echo json_encode("INVALID311");
    return false; //BREAK//
  }

  //Check Number of Photo
  if (isset($_POST["photo"])) {
    if ($filter->checkNumPhoto($_POST["photo"])) {
      $objectDataArr[":photo"] = $_POST["photo"];
    } else {
      echo json_encode("INVALID2");
      return false; //BREAK//
    }
  }

  //Check Object Description
  if (isset($_POST["description"])) {
    if ($filter->checkDescription($_POST["description"])) {
      $objectDataArr[":description"] = $_POST["description"];
    } else {
      echo json_encode("INVALID1");
      return false; //BREAK//
    }
  }

  //Checking Images
  for ($i = 1; $i <= count($_FILES); $i++) {
    if (isset($_FILES["img" . $i])) {
      $imgObj = new Image($_FILES["img" . $i]);
      if (!$imgObj->checkAll()) {
        echo json_encode("INVALID IMG");
        return false;
      }
    } else {
      echo json_encode("INVALID IMG");
      return false;
    }
  }

  //Adding New Object
  if ($objectIns->addNewObject($libraryID, $name, $objectDataArr)) {
    $objID = $objectIns->newObjID;
    for ($i = 1; $i <= count($_FILES); $i++) {
      $imgObj = new Image($_FILES["img" . $i]);
      $imgObj->uploadImage($libraryID, $objID, $i, 2);
    }
    echo json_encode("ADD");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) < 3 || count($_POST) > 5) {
    return false;
  }
  $mustKeys = ["libraryID", "libType", "name"];
  $allowKeys = ["description", "photo"];
  foreach (array_keys($_POST) as $key) {
    if (in_array($key, $mustKeys) || in_array($key, $allowKeys)) {
    } else {
      return false;
    }
  }
  foreach ($mustKeys as $mustKey) {
    if (!in_array($mustKey, array_keys($_POST))) {
      return false;
    }
  }
  if (count($_FILES) > 5) {
    return false;
  }
  $allowKeys = ["img1", "img2", "img3", "img4", "img5"];
  foreach (array_keys($_FILES) as $key) {
    if (in_array($key, $allowKeys)) {
    } else {
      return false;
    }
  }
  return true;
}
?>
