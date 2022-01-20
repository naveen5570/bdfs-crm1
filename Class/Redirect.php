<?php
class Redirect {

   public static function url($url = null){

      $url = BASEURL.$url;
     
      return header('Location:'.$url);
   
   }

}