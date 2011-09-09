
<div class='gallery-content'>

<?php   foreach ($directories as $directory) { ?>
            <div class='directory asset'>
                <a href='?dir=<?php print(urlencode($currentDir . $directory)); ?>'>
                    <img src='imageresize.php?filename=<?php print(getThumbnailUrl($baseDir . $currentDir . $directory)); ?>&sizex=200&sizey=130' />
                    <p><?php print($directory); ?></p> 
                </a>
            </div>
<?php   } ?>

<?php   foreach ($files as $file) { ?>
            <div class='image asset'>
                <a href='<?php print($baseDir . $currentDir . $file); ?>'>
                    <img src='imageresize.php?filename=<?php print(getThumbnailUrl($baseDir. $currentDir . $file)); ?>&sizex=200&sizey=130' />
                    <p><?php print($file); ?></p>
                </a>
            </div>
<?php   } ?>


</div>
