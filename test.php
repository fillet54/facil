<?php

include('imageutilities.php');

function resizeImage($file, $width = 0, $height = 0, $output = 'return', $outputFile = null, $proportional = false, $crop = false)
{
    if ( $height <= 0 && $width <= 0 )
        return false;

    $info = getimagesize($file);
    $image = '';

    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;
    $imageType = $info[2];

    if ($crop)
    {
        list($width_old, $height_old) = getCroppedAspectSize($width_old, $height_old, $width/$height);
        $final_width = $width;
        $final_height = $height;
    }
    elseif ($proportional)
    {
        list($final_width, $final_height) = getScaledSize($width, $height, $width);
    }
    else
    {
        $final_width = $width;
        $final_height = $height;  
    }
 
    switch ($imageType)
    {
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($file);
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($file);
            break;
        default:
            return false;
    }
    
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
        
    if ( ($imageType == IMAGETYPE_GIF) || ($imageType == IMAGETYPE_PNG) )
    {
        $transparentIndex = imagecolortransparent($image);
   
        // If we have a specific transparent color
        if ($transparentIndex >= 0)
        {
            // Get the original image's transparent color's RGB values
            $transparentColor = imagecolorsforindex($image, $transparentIndex);
   
            // Allocate the same color in the new image resource
            $transparentIndex = imagecolorallocate($image_resized, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);
   
            // Completely fill the background of the new image with allocated color.
            imagefill($image_resized, 0, 0, $transparentIndex);
   
            // Set the background color for new image to transparent
            imagecolortransparent($image_resized, $transparentIndex);
        }
        elseif ($imageType == IMAGETYPE_PNG)
        {
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
        }
    } 

    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
  
    switch (strtolower($output)) {
        case 'browser':
            header('Content-type: ' . image_type_to_mime_type($imageType));
            outputImage($image_resized, $imageType, null);
            break;
        case 'browser_and_file':
            header('Content-type: ' . image_type_to_mime_type($imageType));
            outputImage($image_resized, $imageType, null);

            if ($outputFile)
                outputImage($image_resized, $imageType, $outputFile);
            break;
        case 'file':
            outputImage($image_resized, $imageType, $outputFile);
            break;
        case 'return':
            return $image_resized;
            break;
        default:
            break;
    }

    return true;
}

function outputImage($image, $imageType, $file)
{
    switch ($imageType)
    {
        case IMAGETYPE_GIF:
            imagegif($image, $file);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($image, $file);
            break;
        case IMAGETYPE_PNG:
            imagepng($image, $file);
            break;
        default:
            return false;
    }
}

resizeImage($_GET['filename'], $_GET['width'], $_GET['height'], 'browser', null, false, true);
