<?php

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

function getThumbnailUrl($filePath)
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

     return urlencode($image);
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
