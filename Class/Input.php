<?php  if ( ! defined('BASEURL')) exit('No direct script access allowed');
class Input{


	 public static function get($val){
          
          return ($_REQUEST[$val]);
	 }

	 public static function exists($val){
          
           if(isset($val)){
          	      return true;
            }else{
            	return false;
            }
	 }
}