<?php

require_once "../checkLogin.php";
require_once "../../classes/Object.php";
require_once "../../classes/Image.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $libType;
  $objectID;
  $libraryID;
  $name;
  $objectDataArr = [];

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
    echo json_encode("INVALID4");
    return 0; //BREAK//
  }

  //There is NO Need to Check name If User DON'T Have Permission to Access the Objects.
  //Check Object Name
  if ($filter->checkObjectName($_POST["name"])) {
    $name = $_POST["name"];
  } else {
    echo json_encode("INVALID3");
    return 0; //BREAK//
  }

  //Check Number of Photo
  if (isset($_POST["photo"])) {
    if ($filter->checkNumPhoto($_POST["photo"])) {
      $objectDataArr[":photo"] = $_POST["photo"];
    } else {
      echo json_encode("INVALID PHOTO");
      return 0; //BREAK//
    }
  }

  //Check Object Description
  if (isset($_POST["description"])) {
    if ($_POST["description"] == "") {
      $objectDataArr[":description"] = $_POST["description"];
    } elseif ($filter->checkDescription($_POST["description"])) {
      $objectDataArr[":description"] = $_POST["description"];
    } else {
      echo json_encode("INVALID2");
      return 0; //BREAK//
    }
  }

  //Checking Images
  for ($i = 1; $i <= count($_FILES); $i++) {
    if (isset($_FILES["img" . $i])) {
      $imgObj = new Image($_FILES["img" . $i]);
      if (!$imgObj->checkAll()) {
        echo "INVALID IMAGE FILE!!!\n";
        return false;
      }
    } else {
      echo "IMAGE NOT IN ORDER!!!\n";
      return false;
    }
  }

  // print_r($objectDataArr);

  if (
    $objectIns->updateObject($libraryID, $objectID, $name, $objectDataArr) ||
    isset($_POST["photo"])
  ) {
    if (isset($_POST["photo"])) {
      for ($i = 1; $i <= count($_FILES); $i++) {
        $imgObj = new Image($_FILES["img" . $i]);
        $imgObj->uploadImage($libraryID, $objectID, $i, 2);
      }
      $imgObj = new Image($libType);

      $imgObj->deleteImage($libraryID, $objectID, count($_FILES) + 1, 2);
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
  $mustKeys = ["libraryID", "libType", "name", "objectID"];
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
