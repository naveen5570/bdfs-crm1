<?php  if ( ! defined('BASEURL')) exit('No direct script access allowed');
class View{

	public function views($view,$data=null){
		if(!empty($data)){
			extract($data);
		}
       
       require_once './View/'.$view.'.php';
       exit;
   }
}