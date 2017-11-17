<?php

$cpt = 1;
        $directory = 'images/EmojiOne/';
        if ($handle = opendir($directory)) { 
            while (false !== ($fileName = readdir($handle))) {     
                rename($directory . $fileName, $directory . $cpt.".png");
                $cpt += 1;
                echo $cpt;
            }
            closedir($handle);
        }
  ?>