

<div class='gallery-content'>

<?php   foreach ($directories as $directory) { ?>
            <div class='directory'>
                <a href='?dir=<?php print(urlencode($currentDir . $directory)); ?>'>
                    <img src='imageresize.php?filename=<?php print(getThumbnailUrl($baseDir . $currentDir . $directory)); ?>&sizex=200&sizey=130' />
                </a>
            </div>
<?php   } ?>

<?php   foreach ($files as $file) { ?>
            <div class='image'>
                <a href='<?php print($baseDir . $currentDir . $file); ?>'>
                    <img src='imageresize.php?filename=<?php print(getThumbnailUrl($baseDir. $currentDir . $file)); ?>&sizex=200&sizey=130' />
                </a>
            </div>
<?php   } ?>


</div>
