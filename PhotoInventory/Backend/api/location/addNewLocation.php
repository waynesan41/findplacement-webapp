<?php

require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Image.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $locType;
  $mainID;
  $name;
  $objectDataArr = [];
  $topID;

  if (!$filter->checkType($_POST["locType"])) {
    echo json_encode("INVALID1");
    return false; //BREAK//
  }
  if (!$filter->checkIntZero($_POST["topID"])) {
    echo json_encode("INVALID2");
    return false; //Break
  }
  if ($filter->checkName($_POST["name"])) {
    echo json_encode("INVALID3");
    return false; //BREAK//
  }

  $locationObj = new Location($_SESSION["userLogin"]);
  $locType = $_POST["locType"];
  $topID = $_POST["topID"];
  $name = $_POST["name"];

  if ($filter->checkInt($_POST["mainID"])) {
    $mainID = $_POST["mainID"];
    if ($locType == 1) {
      if (!$locationObj->checkOwn($mainID)) {
        echo json_encode("DENY");
        return false; //BREAK//
      }
    } elseif ($locType == 2) {
      if (!$locationObj->checkAccess($mainID, 2)) {
        echo json_encode("DENY");
        return false; //BREAK//
      }
    }
  } else {
    echo "INVALID MAIN LOCATION ID!!\n";
    return 0; //BREAK//
  }

  //Check Number of Photo
  /* if (isset($_POST["photo"])) {
    if ($filter->checkNumPhoto($_POST["photo"])) {
      $objectDataArr[":photo"] = $_POST["photo"];
    } else {
      echo "INVALID NUMBER OF PHOTO!!\n";
      return false; //BREAK//
    }
  } */

  if (isset($_POST["description"])) {
    if ($filter->checkDescription($_POST["description"])) {
      $objectDataArr[":description"] = $_POST["description"];
    } else {
      echo json_encode("INVALID4");
      return false; //BREAK//
    }
  }

  //Checking Images
  for ($i = 1; $i <= count($_FILES); $i++) {
    if (isset($_FILES["img" . $i])) {
      $imgObj = new Image($_FILES["img" . $i]);
      if (!$imgObj->checkAll()) {
        echo json_encode("INVALID5");
        return false;
      }
    } else {
      echo json_encode("INVALID5");
      return false;
    }
  }

  $objectDataArr[":photo"] = count($_FILES);

  if ($locationObj->addNewLocation($mainID, $topID, $name, $objectDataArr)) {
    $locID = $locationObj->newLocID;
    for ($i = 1; $i <= count($_FILES); $i++) {
      $imgObj = new Image($_FILES["img" . $i]);
      $imgObj->uploadImageLinux($mainID, $locID, $i, 1);
    }
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) < 3 || count($_POST) > 6) {
    return false;
  }
  $mustKeys = ["mainID", "locType", "name", "topID"];
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
