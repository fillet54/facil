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

/*if (isset($_GET['orientate']) && $_GET['orientate'] == 1)
    $originalImage = orientateImage($originalImage);
 */


if (isset($_GET['sizex']) && isset($_GET['sizey']))
{
    resizeImage($fileName, $_GET['sizex'], $_GET['sizey'], 'browser', null, false, true);
}

?>

