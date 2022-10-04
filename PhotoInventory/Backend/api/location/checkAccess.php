<?php
require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $filter = new Filter();
  $ObjIns = new Location($_SESSION["userLogin"]);
  $mainID = $_POST["mainID"];
  if ($filter->checkInt($mainID)) {
    if ($ObjIns->checkOwn($mainID)) {
      echo json_encode(4);
      $_SESSION["mainID"] = $mainID;
    } else {
      echo $ObjIns->getAccess($mainID);
      if ($ObjIns->getAccess($mainID) != 0) {
        $_SESSION["mainID"] = $mainID;
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
  $keyAllow = ["mainID"];
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
