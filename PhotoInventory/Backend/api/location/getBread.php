
<?php
require_once "../checkLogin.php";
require_once "../../classes/Location.php";
require_once "../../classes/Filter.php";
if (checkKeys()) {
  $filter = new Filter();
  if (
    !$filter->checkInt($_POST["mainID"]) ||
    !$filter->checkInt($_POST["locationID"])
  ) {
    echo json_encode("INVALID");
    return false; //Break
  }

  $mainID = $_POST["mainID"];
  $locationID = $_POST["locationID"];
  $locObj = new Location($_SESSION["userLogin"]);

  //CHECK Access
  if (!$locObj->checkOwn($mainID) && !$locObj->checkAccess($mainID, 1)) {
    echo json_encode("ACCESS DENY");
    return false; //Break
  }

  echo $locObj->getLinkList($_POST["mainID"], $_POST["locationID"]);
} else {
  echo json_encode("BAD KEY");
}
function checkKeys()
{
  if (empty($_POST)) {
    return false;
  }
  $keyAllow = ["locationID", "mainID"];
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
