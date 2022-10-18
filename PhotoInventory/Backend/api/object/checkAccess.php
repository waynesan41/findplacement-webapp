<?php
require_once "../checkLogin.php";
require_once "../../classes/Object.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $ObjIns = new Objects($_SESSION["userLogin"]);
  $libraryID = $_POST["libraryID"];
  if ($filter->checkInt($libraryID)) {
    if ($ObjIns->checkOwn($libraryID)) {
      echo json_encode(4);
      $_SESSION["libraryID"] = $libraryID;
    } else {
      echo $ObjIns->getAccess($libraryID);
      if ($ObjIns->getAccess($libraryID) != 0) {
        $_SESSION["libraryID"] = $libraryID;
      }
    }
  } else {
    echo json_encode("INVALID");
  }
} else {
  echo json_encode("BAD KEY");
}
function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["libraryID"];
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
