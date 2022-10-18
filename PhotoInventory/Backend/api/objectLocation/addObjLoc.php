<?php
require_once "../checkLogin.php";
require_once "../../classes/ObjectLocation.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();

  if (!$filter->checkInt($_POST["mainID"])) {
    echo json_encode("INVALID");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["locID"])) {
    echo json_encode("INVALID1");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["objID"])) {
    echo json_encode("INVALID2");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["libID"])) {
    echo json_encode("INVALID3");
    return false; //Break
  }
  if (!$filter->checkInt($_POST["quantity"])) {
    echo json_encode("INVALID4");
    return false; //Break
  }

  $newArr = [];
  if (isset($_POST["description"])) {
    if ($filter->checkDescription($_POST["description"])) {
      $newArr[":description"] = $_POST["description"];
    } else {
      echo json_encode("INVALID DESCRIPTION");
      return false;
    }
  }
  if (isset($_POST["quantity"])) {
    if ($filter->checkIntZero($_POST["quantity"])) {
      $newArr[":quantity"] = $_POST["quantity"];
    } else {
      echo json_encode("INVALID QUANTITY");
      return false; //BREAK//
    }
  }
  $mainID = $_POST["mainID"];
  $locID = $_POST["locID"];
  $objID = $_POST["objID"];
  $libID = $_POST["libID"];

  $objLocIns = new ObjectLocation($_SESSION["userLogin"]);

  if (
    !$objLocIns->checkMainLoc($mainID, 2) &&
    !$objLocIns->checkMainLoc($mainID, 0)
  ) {
    echo json_encode("DENY1");
    return false; //Break
  }
  if (
    !$objLocIns->checkLibrary($libID, 2) &&
    !$objLocIns->checkLibrary($libID, 0)
  ) {
    echo json_encode("DENY2");
    return false; //Break
  }
  if (!$objLocIns->checkMainLibrary($mainID, $libID)) {
    echo json_encode("OWNER MISMATCH");
    return false; //Break
  }

  $objLocIns->addObjLoc($locID, $mainID, $objID, $libID, $newArr);
} else {
  echo json_encode("BAD KEY");
}

function checkKeys()
{
  if (empty($_POST) || count($_POST) < 5 || count($_POST) > 6) {
    return false;
  }
  $mustKeys = ["mainID", "locID", "libID", "objID", "quantity"];
  $allowKeys = ["description"];
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
  return true;
}
?>
