<?php

$mustKeys = ["libraryID", "libType", "name"];
$allowKeys = ["description", "photo"];
foreach (array_keys($_POST) as $key) {
  if (in_array($key, $mustKeys) || in_array($key, $allowKeys)) {
    echo "Key: " . $key . "\n";
  } else {
    echo "!!ERROR!!\n";
  }
}

foreach ($mustKeys as $mustKey) {
  if (in_array($mustKey, array_keys($_POST))) {
    echo "the must key is in the POST\n";
  } else {
    echo "MUST KEY MISSING!!!\n";
  }
}

?>
