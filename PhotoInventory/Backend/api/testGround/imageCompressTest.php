<?php

require_once "../../classes/Image.php";

/* echo "FILES count: " . count($_FILES["upload"]["name"]);
 echo "\nFILES size: " . sizeof($_FILES["upload"]) . "\n"; */

// print_r($_FILES["files"]["name"]);

// print_r($_FILES["upload"]);

// echo "HTTP Size: " . $_SERVER["CONTENT_LENGTH"];

if (checkKeys()) {
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

  for ($i = 1; $i <= count($_FILES); $i++) {
    $imgObj = new Image($_FILES["img" . $i]);
    $imgObj->uploadImage(12, 2, $i, 1);
  }

  /* $imageFile = $_FILES["img1"];
  $imageObj = new Image($imageFile);

  if ($imageObj->checkAll()) {
    // echo "Image is good...\n";
    $imageObj->uploadImage(12, 2, 1, 1, $imageFile["tmp_name"]);
  } else {
    echo "IMAGE IS BAD!!!\n";
  }
 */
  //   echo "File Key Good...\n";
} else {
  echo "FILE KEY INVALID!!\n";
}

function checkKeys()
{
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
  /* foreach ($mustKeys as $mustKey) {
    if (!in_array($mustKey, array_keys($_FILES))) {
      return false;
    }
  } */
  return true;
}
// $imageObj->checkImageSize();

/* $size = getimagesize($imageFile["tmp_name"]);
print_r($size);
 */
?>
