<?php
require_once('../../../init.php');
/*Description: 
- The script receives a file and a text with method="post". 
- The file is validated to check that is a supported type of image, has no 
  errors and is not larger than the maximum size allowed. 
- If the dimensions of the image are larger than the maximum, it is resized. 
- The image is uploaded to a temporary directory in the server. 
- If the uploading was right, the script outputs an img html tag with the 
  uploaded image, and a JavaScript variable with the temporary path of the 
  uploaded image. If there was any error, the script outputs an error message.  
- If a text is sent a together with the file, it means that there was an 
  image previously uploaded. This text is the path of the previously uploaded 
  image, and it is removed before the new image is uploaded. */
$pathToUpload = RAIZd . "db/pac/";
$fileFieldName = "imageToUpload";
// "image/pjpeg" is the type jpg for Internet Explorer 
$allowedImageTypes = array(
  "image/png", "image/jpg", "image/jpeg",
  "image/pjpeg", "image/gif"
);
$maxImageSize = 2000000; // in bytes 
//----------------------------------------------------------------------------- 
function displayImage($imagePath)
{
  // BUG: the uppercase is very important. The extension of the image must 
  //      be uppercase, if not, it is displayed distorted (Firefox 3.0.10) 
  echo "<img src='" . strtoupper($imagePath) . "' />";
  echo "<script type = 'text/javascript'>";
  echo "var imagePath = '" . $imagePath . "';";
  echo "</script>";
  // delay to test the uploading of the image 
  //sleep(6); 
}
//----------------------------------------------------------------------------- 
// the functions imagecreateXXX raise a fatal error when trying 
// to create an image larger than 3 MB 
function createImageFactory($imagePath, $imageType)
{
  $image = null;
  if ($imageType == "image/png") {
    $image = imagecreatefrompng($imagePath);
  } else if ($imageType == "image/gif") {
    $image = imagecreatefromgif($imagePath);
  } else {
    $image = imagecreatefromjpeg($imagePath);
  }
  return $image;
}
//----------------------------------------------------------------------------- 
function saveImage($image, $imagePath, $imageType)
{
  $resultSave = false;
  if ($imageType == "image/png") {
    $resultSave = imagepng($image, $imagePath);
  } else if ($imageType == "image/gif") {
    // if the gif is animated, the function imagegif doesn't keep the 
    // animation. The animation is lost in the process creating, resampling 
    // and saving the image 
    $resultSave = imagegif($image, $imagePath);
  } else {
    $resultSave = imagejpeg($image, $imagePath, 80);
  }
  return $resultSave;
}
//----------------------------------------------------------------------------- 
function createNewImage($width, $height, $imageType)
{
  $image = imagecreatetruecolor($width, $height);
  // set the transparency if the image is png or gif 
  if (($imageType == "image/png") || ($imageType == "image/gif")) {
    imagealphablending($image, false);
    imagesavealpha($image, true);
    $transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
    imagefilledrectangle($image, 0, 0, $width, $height, $transparent);
  }
  return $image;
}
//----------------------------------------------------------------------------- 
function uploadResizedImage($sourceImagePath, $destinationImagePath, $imageType)
{
  $resultSave = false;
  list($width, $height) = getimagesize($sourceImagePath);
  $maximumDimension = 600;
  if (($maximumDimension >= $width) && ($maximumDimension >= $height)) {
    // with the process of creating, resampling and saving the image, the 
    // animation of an animated gif is lost. In order to keep the possible  
    // animation, if the image is smaller than the maximum size, it is 
    // uploaded without any processing 
    $resultSave = move_uploaded_file($sourceImagePath, $destinationImagePath);
  } else {
    // the function createImageFactory raises a fatal error when trying 
    // to create an image larger than 3 MB 
    $sourceImage = @createImageFactory($sourceImagePath, $imageType);
    if ($width > $height) {
      $newWidth = round($maximumDimension);
      $newHeight = round($height * ($newWidth / $width));
    } else {
      $newHeight = round($maximumDimension);
      $newWidth = round($width * ($newHeight / $height));
    }
    $destinationImage = createNewImage($newWidth, $newHeight, $imageType);
    // the function imagecopyresampled is much better than the function 
    // imagecopyresized, which distorts the image when resizing 
    $resultResize = imagecopyresampled(
      $destinationImage,
      $sourceImage,
      0,
      0,
      0,
      0,
      $newWidth,
      $newHeight,
      $width,
      $height
    );

    if ($resultResize) {
      $resultSave = saveImage($destinationImage, $destinationImagePath, $imageType);
    }
  }

  return $resultSave;
}
//----------------------------------------------------------------------------- 
// if there was an image uploaded before, remove it, because it is being 
// substituted by another one 

// it must be checked first if there is an error with the file (e.g. 
// larger than the maximum size allowed by the hidden field MAX_FILE_SIZE 
// in HTML) than if type of the file is an allowed type, because if there  
// is an error, the type of the file may not be available 
if ($_FILES[$fileFieldName]["error"] > 0) {
  echo "There is an error with the file.";
  echo "<br />";
  echo "Error code: " . $_FILES["imageToUpload"]["error"];
} else if (!in_array($_FILES[$fileFieldName]["type"], $allowedImageTypes)) {
  echo "The type of the file is not a supported image type.";
  echo "<br />";
  echo "FILE: " . $_FILES[$fileFieldName]["name"];
  echo "<br />";
  echo "File type: " . $_FILES[$fileFieldName]["type"];
} else if ($_FILES[$fileFieldName]["size"] > $maxImageSize) {
  // the function createImageFactory, called by uploadResizedImage raises  
  // a fatal error when trying to create an image larger than 3 MB 
  echo "The uploaded file is larger than allowed.";
  echo "<br />";
  echo "Uploaded file size: " . round($_FILES[$fileFieldName]["size"] / 1000) . " KB";
  echo "<br />";
  echo "Max allowed size: " . round($maxImageSize / 1000) . " KB";
} else {
  $filename = "pac" . $_POST['idpac'] . "_" . date('YmdHis') . '.jpg';
  $imagePath = $pathToUpload . $filename;
  if (file_exists($imagePath)) {
    unlink($imagePath);
  }
  if (uploadResizedImage($_FILES[$fileFieldName]["tmp_name"], $imagePath, $_FILES[$fileFieldName]["type"])) {
    displayImage($imagePath);
  } else {
    echo "Error mientra se cargaba el archivo" . $imagePath . ", intente otra vez!";
    echo "<br />";
    echo "Si el error persiste, el archivo cargado no es aceptado por el sistema.";
  }
}
