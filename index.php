<?php 
    $page_title = "Facil Gallery";

    include("header.php")
?>

    <?php 
    
    $FACIL_ROOT = realpath('.') . '/';
    
    include("fileutilities.php");

    $baseDir = "photos/";
    $currentDir = "";
    if(isset($_GET['dir']))
       $currentDir = $_GET['dir'] . '/';


    /* Check for invalid file path */
    if (!filePathOkFor($FACIL_ROOT . $baseDir . $currentDir))
    { ?>
       <h1>Invalid Path</h1>
<?php
       exit;
    }

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
