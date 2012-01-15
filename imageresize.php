<?php
include ('ImageFacil.class.php');

$filename = '';

/* Get Arguments */
/* filename size, sizex, sizey, keepaspect */
if (isset($_GET['filename']))
{
    $filename = $_GET['filename'];    
}

if (!file_exists($filename))
    return;

/*if (isset($_GET['orientate']) && $_GET['orientate'] == 1)
    $originalImage = orientateImage($originalImage);
 */


if (isset($_GET['sizex']) && isset($_GET['sizey']))
{
   $image = new ImageFacil ($filename);
   $image->thumbnailImage($_GET['sizex'], $_GET['sizey']);

   header('Content-type: image/jpeg');
   echo $image; 
}

?>

