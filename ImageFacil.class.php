<?php
require ('ImageGD.class.php');

class ImageFacil
{
   private $_image;

   public function ImageFacil ($file) 
   {
      if (class_exists('Imagick'))
         $this->_image = new Imagick($file);
      else 
         $this->_image = new ImageGD($file);
      
      if (!$this->_image->valid())
         exit();
   }

   public function thumbnailImage ($columns, $rows)
   {
      $this->_image->thumbnailImage($columns, $rows);
   }

   public function save ($filename)
   {
      $this->_image->writeImage($filename);
   }

   public function __toString()
   {
      return $this->_image->__toString();
   }
}
?>
