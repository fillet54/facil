<?php

class ImageGD
{
   private $_src;
   private $_type;
   private $_columns;
   private $_rows;
   private $_valid;

   public function ImageGD ($filename)
   {
      $info = getimagesize($filename);
      
      if ($info == FALSE)
      {
         $this->_valid == FALSE;
         return $this;
      }

      $this->_type = $info[2];
      switch ($this->_type)
      {
      case IMAGETYPE_GIF:
         $this->_src = imagecreatefromgif($filename);
         break;
      case IMAGETYPE_JPEG:
         $this->_src = imagecreatefromjpeg($filename);
         break;
      case IMAGETYPE_PNG:
         $this->_src = imagecreatefrompng($filename);
         break;
      default:
         exit();
      }

      $this->_valid = TRUE;
      $this->_columns = $info[0];
      $this->_rows = $info[1];
   }
   
   public function valid ()
   {
      return $this->_valid;
   }

   public function writeImage ($filename)
   {
      if ($filename == NULL)
         return;

      switch ($this->_type)
      {
      case IMAGETYPE_GIF:
         imagegif($this->_src, $filename);
         break;
      case IMAGETYPE_JPEG:
         imagejpeg($this->_src, $filename);
         break;
      case IMAGETYPE_PNG:
         imagepng($this->_src, $filename);
         break;
      default:
         return;
      }
   }

   public function resizeImage ($columns, $rows)
   {
      if ($rows == 0)
         $rows = $this->getScaledRows($columns);

      if ($columns == 0)
         $columns = $this->getScaledColumns($rows);

      $newSrc = $this->getResizedSrc($columns, $rows);
      imagecopyresampled ($newSrc, $this->_src, 0, 0, 0, 0, $columns, $rows, $this->_columns, $this->_rows);

      # Set the new properties
      $this->_src = $newSrc;
      $this->_columns = $columns;
      $this->_rows = $rows;
   }

   public function __toString()
   {
      ob_start();
         switch ($this->_type)
         {
         case IMAGETYPE_GIF:
            imagegif($this->_src);
            break;
         case IMAGETYPE_JPEG:
            imagejpeg($this->_src);
            break;
         case IMAGETYPE_PNG:
            imagepng($this->_src);
            break;
         default:
            echo '';
         }
         $imageData = ob_get_contents();
      ob_end_clean();

      return $imageData;
   }

   public function thumbnailImage ($columns, $rows)
   {
      $this->resizeImage($columns, $rows);
   }

   private function getResizedSrc ($columns, $rows)
   {
      $resizedSrc = imagecreatetruecolor( $columns, $rows );

      if ($this->_type == IMAGETYPE_GIF
          || $this->_type == IMAGETYPE_PNG)
      {
         $transparentIndex = imagecolortransparent($this->_src);

         // If we have a specific transparent color
         if ($transparentIndex >= 0)
         {
            // Get the original image's transparent color's RGB values
            $transparentColor = imagecolorsforindex($this->_src, $transparentIndex);

            // Allocate the same color in the new image resource
            $transparentIndex = imagecolorallocate($resizedSrc, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);

            // Completely fill the background of the new image with allocated color.
            imagefill($resizedSrc, 0, 0, $transparentIndex);

            // Set the background color for new image to transparent
            imagecolortransparent($resizedSrc, $transparentIndex);
         } 
         elseif ($imageType == IMAGETYPE_PNG)
         {
            imagealphablending($resizedSrc, false);
            $color = imagecolorallocatealpha($resizedSrc, 0, 0, 0, 127);
            imagefill($resizedSrc, 0, 0, $color);
            imagesavealpha($resizedSrc, true);
         }
      }

      return $resizedSrc;
   }

   private function getScaledColumns ($rows)
   {
      $columns = ($this->_columns * $rows) / $this->_rows;

      if ($columns == 0)
         $columns = $this->_columns;

      return $columns;
   }

   private function getScaledRows ($columns)
   {
      $rows = ($this->_rows * $columns) / $this->_columns;

      if ($rows == 0)
         $rows == $this->_rows;

      return $rows;
   }
}

?>
