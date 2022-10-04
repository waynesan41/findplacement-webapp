<?php

include_once "../../classes/Filter.php";
include_once "../../classes/Location.php";

echo "Top Location Test\n";

$locObj = new Location(7);

if ($locObj->checkLocationLoop(27, 5, 8)) {
  echo "TRUE";
} else {
  echo "FALSE";
}

?>
