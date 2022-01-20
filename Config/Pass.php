<?php
 class Pass{
    
 	public function __construct(){
      
 	  
 	}

 	public static function hash($pass){
 		$make = 'PHPassLib\Hash\BCrypt';
 		return $make::hash($pass);
 	}

    public static function verify($pass,$oldPass){
    	$make = 'PHPassLib\Hash\BCrypt';
 		return $make::verify($oldPass,$pass);
    }
 }