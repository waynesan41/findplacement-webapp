<?php

require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Image.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $locType;
  $locationID;
  $mainID;
  $name;
  $locDataArr = [];

  //Check Library Type Value
  if ($filter->checkLibraryType($_POST["locType"])) {
    $locType = $_POST["locType"];
  } else {
    echo json_encode("INVALID1");
    return 0; //BREAK//
  }
  //Check locationID Value
  if ($filter->checkInt($_POST["locationID"])) {
    $locationID = $_POST["locationID"];
  } else {
    echo json_encode("INVALID2");
    return 0;
  }

  if (!$filter->checkName($_POST["name"])) {
    $name = $_POST["name"];
  } else {
    echo json_encode("INVALID3");
    return 0; //BREAK//
  }

  $locationObj = new Location($_SESSION["userLogin"]);

  //Check Libryar ID Value
  if ($filter->checkInt($_POST["mainID"])) {
    //Check User ACCESS to the Library
    $mainID = $_POST["mainID"];
    if ($locType == 1) {
      if (!$locationObj->checkOwn($mainID)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    } elseif ($locType == 2) {
      if (!$locationObj->checkAccess($mainID, 3)) {
        echo json_encode("DENY");
        return 0; //BREAK//
      }
    }
  } else {
    echo json_encode("INVALID LIBRARY");
    return 0; //BREAK//
  }

  //Check Number of Photo
  if (isset($_POST["photo"])) {
    if ($filter->checkNumPhoto($_POST["photo"])) {
      $locDataArr[":photo"] = $_POST["photo"];
    } else {
      echo "INVALID Number of Photo!!\n";
      return 0; //BREAK//
    }
  }

  //Check Object Description
  if (isset($_POST["description"])) {
    if ($filter->checkDescription($_POST["description"])) {
      $locDataArr[":description"] = $_POST["description"];
    } else {
      echo json_encode("INVALID DESCRIPTION");
      return 0; //BREAK//
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

  if (
    $locationObj->updateLocation($mainID, $locationID, $name, $locDataArr) ||
    isset($_POST["photo"])
  ) {
    if (isset($_POST["photo"])) {
      for ($i = 1; $i <= count($_FILES); $i++) {
        $imgObj = new Image($_FILES["img" . $i]);
        $imgObj->uploadImageLinux($mainID, $locationID, $i, 1);
      }
      $imgObj = new Image($mainID);
      $imgObj->deleteImage($mainID, $locationID, count($_FILES) + 1, 1);
    }

    echo json_encode("UPDATED");
  } else {
    echo json_encode("FAIL");
  }
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) < 4 || count($_POST) > 6) {
    return false;
  }
  $mustKeys = ["mainID", "locType", "name", "locationID"];
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
