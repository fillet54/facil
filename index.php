<?php 
    $page_title = "Facil Gallery";

    include("header.php")
?>

<body>
    <?php 
    
    $FACIL_ROOT = '/home/phillip/Sites/default/gallery/';
    
    include("fileutilities.php");

    $currentDir = "photos/";
    if(isset($_GET['dir']))
        $currentDir = $currentDir . $_GET['dir'];

    $directories = getDirectories($currentDir);
    $files = getFiles($currentDir);
    ?>

    <h1>Directories</h1>
    <h2>Count: <?php print(count($directories)); ?></h2>
    <ul>
    <?php
    foreach ($directories as $directory)
    {
        $thumb = getThumbnailUrl($currentDir . $directory);
        $image = new ImageResize($thumb);
        $image->
        print('<li><a href=\'?dir=' . $currentDir . $directory . '\'><img src=\'' . getThumbnailUrl($currentDir . $directory) . '\'></img>' . $directory . '</a></li>');  
    }
    ?> 
    </ul>

    <h1>Files</h1>
    <h2>Count: <?php print(count($files)); ?></h2>
    <ul>
    <?php
    foreach ($files as $file)
    {
        print('<li><a href=\'' . getThumbnailUrl($currentDir . $file) . '\'>' . $file . '</a></li>');  
    }
    ?> 
    </ul>
</body>

<?php
    include("footer.php")
?>
