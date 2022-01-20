<?php
// Configure timeout to 15 minutes
$timeout = 60;

// Set the maxlifetime of session
ini_set( "session.gc_maxlifetime", $timeout );

// Also set the session cookie timeout
ini_set( "session.cookie_lifetime", $timeout );


 session_start();
//  define("BASEURL","http://markuplounge.com/bdforsalecrm/");
 define("BASEURL","http://localhost/bdfs-crm1/");
//  define("BASEURL","http://crm.brokerdealerforsale.com/");
  require_once("Config/orm.php");
  require_once("Config/helper.php");
  require_once("Config/PHPassLib.php");
  require_once("Config/Pass.php");
  require_once("Config/Controller.php");

 // Define Base url for this app
 require_once("init.php");
   
 
  

define('ENV','DEV');


define("DefaultController","user");
define("DefaultFuncation","index");

 $obj = new Controller(); 
 


