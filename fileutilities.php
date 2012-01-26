<?php

require ('ImageFacil.class.php');

function filePathOkFor($filePath)
{
   $currentPath = realpath($filePath) . '/';

   if ($currentPath == $filePath)
      return TRUE;
   else
      return FALSE;
}

function getDirectories($filePath)
{
    $directories = array();    
    $currentDirHandle = FALSE;
    $file = '';

    if(($currentDirHandle = opendir($filePath)) == FALSE)
        return FALSE;
    
    while (($file = readdir($currentDirHandle)) !== FALSE)
    {
        if (!is_dir($filePath . '/' . $file))
            continue;
        
        /* Ignore hidden directories */
        if ($file[0] == '.')
            continue;

        $directories[] = $file;
    }
    closedir($currentDirHandle);

    return $directories;
}

function getFiles($filePath)
{
    $files = array();
    $currentDirHandle = FALSE;
    $file = '';

    if(($currentDirHandle = opendir($filePath)) == FALSE)
        return FALSE;

    while (($file = readdir($currentDirHandle)) !== FALSE)
    {
        if(is_dir($filePath . '/' . $file))
            continue;
        
        /* Ignore hidden files */
        if($file[0] == '.')
            continue;

        $files[] = $file;
    }
    closedir($currentDirHandle);

    return $files;
}

function getThumbnailUrl($filePath, $width, $height)
{   
    $image = '';

    if(is_dir($filePath))
    {
        if (file_exists($filePath . '/.folder.jpg'))
        {
            $image = $filePath . '/.folder.jpg';
        }
        elseif (($firstImage = getFirstImageInDir($filePath)) != FALSE)
        {
            $image = $filePath . '/' . $firstImage;        
        }
        else
        {
            $image = 'images/directory.png';
        }
    }
    else
    {
        //CONFIG
        $imageExtensions = array('JPG', 'JPEG', 'PNG', 'GIF');
        $otherExtensions = array ('PDF', 'TAR', 'ZIP', 'GZ', 'DOC', 'DOCX');

        $extension = getFileExtension($filePath);
        
        if (in_array($extension, $imageExtensions))
        {
            $image = $filePath;
        }
        elseif (in_array($extension, $otherExtensions))
        {
            $image = 'images/filetype_' . $extension . '.png';
        }
        else
        {
            $image = 'images/filetype.png';
        }            
     }

     # Cache the image here
     # assume cache is always enabled.
     # getCachedUrl ()
     return getCachedImageUrl($image, $width, $height);
}       

function getCachedImageUrl ($imagePath, $width, $height)
{
   $cachePath = "cache/" . $imagePath;

   # If the image exists then lets return the image
   if (!file_exists($cachePath))
   {
      $image = new ImageFacil ($imagePath);
      $image->cropThumbnailImage($width, $height);

      # Create the directory if it doesnt exist yet.
      if (!file_exists(dirname($cachePath)))
      {
         mkdir(dirname($cachePath), 0777, true);
      }

      $image->save($cachePath);
   }

   return $cachePath;
}

function getFirstImageInDir($filePath)
{
    $image = FALSE;
    $imageExtensions = array ('JPG', 'JPEG', 'PNG', 'GIF');

    $files = getFiles($filePath);
    foreach ($files as $file)
    {
        if (is_dir($file))
            continue;

        if ($file == '.' || $file == '..')
            continue;

        if (in_array(getFileExtension($file), $imageExtensions))
        {
            $image = $file;
            break;
        }
    }

    return $image;
}

function getFileExtension($file)
{
    $extension = substr($file, strrpos($file, '.') + 1);
    return strtoupper($extension);
}
