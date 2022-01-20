<?php
 
require_once './venders/php-activerecord/ActiveRecord.php'; 
// require_once './venders/rych/phpass/PHPassLib.php'; 


ActiveRecord\Config::initialize(function($cfg)
 {
     $cfg->set_model_directory('./Model');
     $cfg->set_connections(array(
        'development' => 'mysql://bdfs_crm1:bdfs_crm1@localhost/bdfs-crm1'));
 });


//$make = 'PHPassLib\Hash\BCrypt';