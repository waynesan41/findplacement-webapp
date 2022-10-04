<?php

include_once "../../config/Database.php";

class Image
{
  private $imageFile;

  public function __construct($file)
  {
    $this->imageFile = $file;
  }
  public function checkAll()
  {
    if (
      $this->checkImageArray() &&
      $this->checkFileType() &&
      $this->checkImageSize()
    ) {
      return true;
    } else {
      return false;
    }
  }
  //******************************************** */
  /*********** CHECK File Input Type *********** */
  public function checkImageArray()
  {
    if (is_array($this->imageFile["name"])) {
      // echo "THIS IS AN ARRAY...\n";
      return false;
    } else {
      // echo "This is Not Array...\n";
      return true;
    }
  }
  //******************************************** */
  /*********** CHECK Image Size***************** */
  public function checkImageSize()
  {
    if ($this->imageFile["size"] > 30000000) {
      // echo "INVALID SIZE!!!\n";
      return false;
    } else {
      // echo "Size Valid...\n";
      return true;
    }
  }
  //******************************************** */
  /*********** CHECK File Extensiont *********** */
  public function checkFileType()
  {
    if (
      !empty($this->imageFile["tmp_name"]) &&
      getimagesize($this->imageFile["tmp_name"])
    ) {
      // echo "This is the Image File...\n";
      return true;
    } else {
      // echo "THIS IS NOT IMAGE FILE!!!\n";
      return false;
    }
  }

  //*****************************npm *************** */
  /******** UPLOAD IMAGE to the Folder ********* */
  public function uploadImage($typeID, $imgID, $position, $type)
  {
    $path = "";
    if ($type == 1) {
      $path = "main/";
    } elseif ($type == 2) {
      $path = "lib/";
    }
    $imgName = $imgID . "-" . $position . ".jpeg";
    $filePath = "../../../../../img/" . $path . $typeID . "/o/" . $imgName;
    $fileComp = "../../../../../img/" . $path . $typeID . "/" . $imgName;

    if (move_uploaded_file($this->imageFile["tmp_name"], $filePath)) {
      $imageObject = imagecreatefromjpeg($filePath);
      # Get exif information
      $exif = exif_read_data($filePath);
      # Get orientation
      $orientation = $exif["Orientation"];

      switch ($orientation) {
        case 2:
          imageflip($imageObject, IMG_FLIP_HORIZONTAL);
          break;
        case 3:
          $imageObject = imagerotate($imageObject, 180, 0);
          break;
        case 4:
          imageflip($imageObject, IMG_FLIP_VERTICAL);
          break;
        case 5:
          $imageObject = imagerotate($imageObject, -90, 0);
          imageflip($imageObject, IMG_FLIP_HORIZONTAL);
          break;
        case 6:
          $imageObject = imagerotate($imageObject, -90, 0);
          break;
        case 7:
          $imageObject = imagerotate($imageObject, 90, 0);
          imageflip($imageObject, IMG_FLIP_HORIZONTAL);
          break;
        case 8:
          $imageObject = imagerotate($imageObject, 90, 0);
          break;
      }
      imagejpeg($imageObject, $filePath, 60);
      list($width, $height) = getimagesize($filePath);
      if ($width > 1000 || $height > 1000) {
        $sizeChange = 0.25;
        $newWidth = $width * $sizeChange;
        $newHeight = $height * $sizeChange;
      }
      $imageResize = imagescale($imageObject, $newWidth, $newHeight);
      imagejpeg($imageResize, $fileComp, 30);
    } else {
      // echo json_encode("FAIL UPLOAD");
    }
  }

  function compress($source, $destination, $quality)
  {
    $info = getimagesize($source);

    if ($info["mime"] == "image/jpeg") {
      $image = imagecreatefromjpeg($source);
    } elseif ($info["mime"] == "image/gif") {
      $image = imagecreatefromgif($source);
    } elseif ($info["mime"] == "image/png") {
      $image = imagecreatefrompng($source);
    }

    imagejpeg($image, $destination, $quality);

    return $destination;
  }

  //DELETING Objects From Folder
  public function deleteImage($typeID, $imgID, $position, $type)
  {
    $path = "";
    if ($type == 1) {
      $path = "main/";
    } elseif ($type == 2) {
      $path = "lib/";
    }

    for ($i = $position; $i <= 5; $i++) {
      $imgName = $imgID . "-" . $i . ".jpeg";
      $filePath = "../../../../../img/" . $path . $typeID . "/" . $imgName;
      $filePath2 = "../../../../../img/" . $path . $typeID . "/o/" . $imgName;
      if (file_exists($filePath)) {
        unlink($filePath);
        // echo json_encode("IMAGE DELETE");
      }
      if (file_exists($filePath2)) {
        unlink($filePath2);
        // echo json_encode("IMAGE DELETE");
      }
    }
  }
}

?>
