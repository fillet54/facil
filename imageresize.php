<?php
require('imageutilities.php');

$fileName = '';

/* Get Arguments */
/* filename size, sizex, sizey, keepaspect */
if (isset($_GET['filename']))
{
    $fileName = $_GET['filename'];    
}

if (!file_exists($fileName))
    return;

$originalImage = getImage($fileName);
if (!$originalImage)
    return;

$originalImage = rotateImage($originalImage, $_GET);
$newImage = getNewImage($originalImage, $_GET);

imageDestroy($originalImage);
/* Output Image */
ImageJPEG($newImage, null, 80);
imageDestroy($newImage);

?>

