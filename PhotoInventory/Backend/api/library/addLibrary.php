<?php

require_once "../checkLogin.php";
require_once "../../classes/Library.php";
require_once "../../classes/Filter.php";

if (checkKeys()) {
  $name = $_POST["name"];
  $filter = new Filter();

  if ($filter->checkLibraryName($name)) {
    $libraryObj = new Library($_SESSION["userLogin"]);
    if ($libraryObj->addLibrary($name)) {
      if (!is_dir("../../../../../img/lib/" . $libraryObj->newLibID)) {
        mkdir("../../../../../img/lib/" . $libraryObj->newLibID);
        mkdir("../../../../../img/lib/" . $libraryObj->newLibID . "/o");
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
  $keyAllow = ["name"];
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
