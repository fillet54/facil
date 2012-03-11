
<div class='gallery-content'>

<?php   foreach ($directories as $directory) { ?>
            <div class='directory asset'>
                <a href='?dir=<?php print(urlencode($currentDir . $directory)); ?>'>
                    <img src='<?php print(getThumbnailUrl($baseDir . $currentDir . $directory, 200, 130)); ?>' />
                    <p><?php print($directory); ?></p> 
                </a>
            </div>
<?php   } ?>

<?php   foreach ($files as $file) { ?>
            <div class='image asset'>
                <a href='<?php print($baseDir . $currentDir . $file); ?>' title='<?php print($file); ?>' rel='prettyPhoto[gallery]'>
                    <img src='<?php print(getThumbnailUrl($baseDir. $currentDir . $file, 200, 130)); ?>' />
                     <p><?php print($file); ?></p>
                </a>
            </div>
<?php   } ?>


</div>
