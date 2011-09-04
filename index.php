<?php 
    $page_title = "Facil Gallery";

    include("header.php")
?>

<body>
    <?php 
    
    $FACIL_ROOT = '/home/phillip/Sites/default/gallery/';
    
    include("fileutilities.php");

    $baseDir = "photos/";
    if(isset($_GET['dir']))
        $currentDir =  $_GET['dir'] . '/';
    else
        $currentDir = "";



    // INPUT CONFIG FILES 
    //


    $directories = getDirectories($baseDir . $currentDir);
    $files = getFiles($baseDir . $currentDir);


    // Display view based on Configuration
    include('views/default/gallery.php');
    ?>

    
    <?php
    include("footer.php")
?>
