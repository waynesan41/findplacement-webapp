<?php

include_once '../../config/Database.php';

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
        if (is_array($this->imageFile['name'])) {
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
        if ($this->imageFile['size'] > 30000000) {
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
            !empty($this->imageFile['tmp_name']) &&
            getimagesize($this->imageFile['tmp_name'])
        ) {
            // echo "This is the Image File...\n";
            return true;
        } else {
            // echo "THIS IS NOT IMAGE FILE!!!\n";
            return false;
        }
    }

    //******************************************** */
    /******** UPLOAD IMAGE to the Folder ********* */
    public function uploadImageWindow($typeID, $imgID, $position, $type)
    {
        $path = '';
        if ($type == 1) {
            $path = 'main/';
        } elseif ($type == 2) {
            $path = 'lib/';
        }
        $imgName = $imgID . '-' . $position . '.jpeg';
        $filePath = '../../../../../img/' . $path . $typeID . '/o/' . $imgName;
        $fileComp = '../../../../../img/' . $path . $typeID . '/' . $imgName;

        echo "===============\n";
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        echo $finfo->file($this->imageFile['tmp_name']);

        if (file_exists($filePath)) {
            unlink($filePath);
            echo "\nxxxxxxxxxxPATHHHH\n";
        }
        if (file_exists($fileComp)) {
            unlink($fileComp);
            echo "\nxxxxxxxxxxxxxxCOMPPP\n";
        }
        echo "\nFile error: " . $this->imageFile['error'];
        if (
            move_uploaded_file($this->imageFile['tmp_name'], $filePath) &&
            chmod($filePath, 0777) &&
            file_exists($filePath)
        ) {
            // var_dump(gd_info());
            // ini_set('gd.jpeg_ignore_warning', 1);
            // $imageObject = imagecreatefromjpeg($filePath);
            

            echo "\nImage Object OG\n";
            var_dump($imageObject);
            # Get exif information
            $exif = exif_read_data($filePath);
            # Get orientation
            $orientation = $exif['Orientation'];

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
            echo "FILE COMP PATH\n";
            echo $fileComp;

            if (
                imagejpeg($imageObject, $filePath, 60) &&
                imagejpeg($imageObject, $fileComp, 60) &&
                chmod($filePath, 0777) &&
                chmod($fileComp, 0777)
            ) {
                list($width, $height) = getimagesize($imageObject);
                echo 'width: ' . $width;
                if ($width > 1000 || $height > 1000) {
                    $sizeChange = 0.25;
                    $newWidth = $width * $sizeChange;
                    $newHeight = $height * $sizeChange;
                }

                $imageResize = imagescale($imageObject, $newWidth, $newHeight);
                echo "Image Resize\n";
                var_dump($imageResize);

                imagejpeg($imageResize, $fileComp, 30);
                chmod($fileComp, 0777);
            }
        } else {
            echo 'FAIL UPLOAD';
        }
    }
    //******************************************** */
    /******** UPLOAD IMAGE to the Folder for Linux Ubuntu ********* */
    function uploadImageLinux($typeID, $imgID, $position, $type)
    {
        $path = '';
        if ($type == 1) {
            $path = 'main/';
        } elseif ($type == 2) {
            $path = 'lib/';
        }
        $imgName = $imgID . '-' . $position . '.jpeg';
        $ogDestination =
            '../../../../../img/' . $path . $typeID . '/o/' . $imgName;
        $destination = '../../../../../img/' . $path . $typeID . '/' . $imgName;

        $source = $this->imageFile['tmp_name'];
        $info = getimagesize($source);

        
        $mimeType = $info['mime'];
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                copy($source, $destination);
                move_uploaded_file($source, $ogDestination);
                return true;
                $image = imagecreatefrompng($source);
                // imagepng($image, $ogDestination);
                // imagepng($image, $destination);
                chmod($destination, 0777);
                chmod($ogDestination, 0777);
                imagedestroy($image);
                return true;
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($source);
                break;
            case 'image/avif':
                $image = imagecreatefromavif($source);
                break;
            case 'image/bmp':
                $image = imagecreatefrombmp($source);
                break;
            case 'image/xbm':
                $image = imagecreatefromxbm($source);
                break;
            case 'image/xpm':
                $image = imagecreatefromxpm($source);
                break;
            case 'image/vnd.wap.wbmp':
                $image = imagecreatefromwbmp($source);
                break;
            default:
                return false;
                echo 'Unknow File type';
                $data = file_get_contents($source);
                $image = imagecreatefromjpeg($data);
                break;
        }
        //Rotating Image TO Normal
        # Get exif information
        $exif = exif_read_data($source);
        # Get orientation
        $orientation = 0;
        if(isset($exif['Orientation'])){

            $orientation = $exif['Orientation'];
        }

        switch ($orientation) {
            case 2:
                imageflip($image, IMG_FLIP_HORIZONTAL);
                break;
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 4:
                imageflip($image, IMG_FLIP_VERTICAL);
                break;
            case 5:
                $image = imagerotate($image, -90, 0);
                imageflip($image, IMG_FLIP_HORIZONTAL);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 7:
                $image = imagerotate($image, 90, 0);
                imageflip($image, IMG_FLIP_HORIZONTAL);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
        imagejpeg($image, $ogDestination, 50);

        $imageResize = $image;
        list($width, $height) = getimagesize($ogDestination);
        if ($width > 1000 || $height > 1000) {
            $sizeChange = 0.25;
            $newWidth = $width * $sizeChange;
            $newHeight = $height * $sizeChange;
            
            $imageResize = imagescale($image, $newWidth, $newHeight);
        } 
        
        imagejpeg($imageResize, $destination, 50);
        imagedestroy($image);
        // move_uploaded_file($source, $destination);
        chmod($destination, 0777);
        chmod($ogDestination, 0777);
        return true;
    }
    //******************************************** */
    /******** UPLOAD IMAGE to the Folder for Linux Ubuntu ********* */
    function converter($typeID, $imgID, $position, $type)
    {
        $path = '';
        if ($type == 1) {
            $path = 'main/';
        } elseif ($type == 2) {
            $path = 'lib/';
        }
        $imgName = $imgID . '-' . $position . '.png';
        $destination = '../../../../../img/' . $path . $typeID . '/' . $imgName;
        echo $destination;

        $source = $this->imageFile['tmp_name'];
        $imgObj = new Imagick();
        // $imgObj->setBackgroundColor(new ImagickPixel('transparent'));
        $imgObj->readImage($source);

        echo "SOURCE\n";
        // var_dump($imgObj);

        // $imgObj->setImageBackgroundColor('#ffffff');
        // $imgObj->setImageBackgroundColor(new ImagickPixel('transparent'));
        // $imgObj = $imgObj->flattenImages();
        // $imgObj->setImageFormat('jpeg');

        // $imgObj->setFormat('jpeg');
        // $imgObj->setFormat('png');
        // var_dump($imgObj->getImageFormat());

        $imgObj->setImageCompressionQuality(50);
        // $imgObj->setImageCompressionQuality(50);
        $imgObj->setFilename($destination);

        $imgObj->clear();
        $imgObj->destroy();
        return $destination;
    }
    //DELETING Objects From Folder
    public function deleteImage($typeID, $imgID, $position, $type)
    {
        $path = '';
        if ($type == 1) {
            $path = 'main/';
        } elseif ($type == 2) {
            $path = 'lib/';
        }

        for ($i = $position; $i <= 5; $i++) {
            $imgName = $imgID . '-' . $i . '.jpeg';
            $filePath =
                '../../../../../img/' . $path . $typeID . '/' . $imgName;
            $filePath2 =
                '../../../../../img/' . $path . $typeID . '/o/' . $imgName;
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
