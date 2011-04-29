<?php

require('fileutilities.php');

function getImage($fileName)
{
    $extension = getFileExtension($fileName);

    $originalImage = '';
    if ($extension == 'JPEG' || $extension == 'JPG')
    {
        $originalImage = ImageCreateFromJPEG($fileName);
    }
    elseif ($extension == 'GIF')
    {
        $originalImage = ImageCreateFromGIF($fileName);
    }
    elseif ($extension == 'PNG')
    {
        $originalImage = ImageCreateFromPNG($fileName);
    }
    else
    {
        return FALSE;
    }

    return $originalImage;
}

function rotateImage($originalImage, $_GET)
{
    $rotatedImage = $originalImage;

    if (isset($_GET['rotate']) && $_GET['rotate'] == 1)
    {
        if (function_exists('exif_read_data') && function_exists('imagerotate'))
        {
            $exif = exif_read_data($fileName);
            $orientation = $exif['IFD0']['Orientation'];

            $degrees = 0;
            if ($orientation == 6)
            {
                $degrees = 270;
            }
            elseif ($orientation == 8)
            {
                $degrees = 90;
            }

            if ($degress != 0)
                $rotatedImage = imagerotate($rotatedImage, $degrees, 0);
        }
    }

    return $rotatedImage;
}

function getNewImage($originalImage, $_GET)
{
    $originalX = imagesx($originalImage);
    $originalY = imagesy($originalImage);
    $newX = $originalX;
    $newY = $originalY;

    if (isset($_GET['size']))
    {
        $size = $_GET['size'];
        if (isset($_GET['keepaspect']) && $_GET['keepaspect'] == 1)
        {
            $xScale = $originalX / $size;
            $yScale = $originalY / $size;

            if ($xScale > $yScale)
            {
                $newX = round($originalX * (1 / $xScale));
                $newY = round($originalY * (1 / $xScale));
            }
            else
            {
                $newX = round($originalX * (1 / $yScale));
                $newY = round($originalY * (1 / $yScale));
            }
        }
        else
        {
            $newX = $size;
            $newY = $size;
        }
    }   
    elseif (isset($_GET['sizex']) && isset($_GET['sizey']))
    {
        $newX = $_GET['sizex'];
        $newY = $_GET['sizey'];
    }

    $newImage = ImageCreateTrueColor($newX, $newY);

    /* Resize image */
    imageCopyResampled($newImage, $originalImage, 
                       0, 0, 0, 0, 
                       imagesx($newImage), imagesy($newImage), imagesx($originalImage), imagesy($originalImage));
    
    return $newImage;

}
