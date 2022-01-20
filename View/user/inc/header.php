<?php
$key  = Token::generate();
//print_r($_SESSION);
//echo ini_get("session.gc_maxlifetime");
//echo $_COOKIE['email'];
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

<title></title>

<link href="<?=BASEURL;?>assets/lib/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/lib/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/lib/css/jquery.dataTables.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/lib/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/lib/css/toastr.min.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/lib/css/select2.min.css" rel="stylesheet">

<!--<link href="<?=BASEURL;?>assets/lib/css/jBox.css" rel="stylesheet">-->

<link href="<?=BASEURL;?>assets/user/css/admin.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/user/css/style.css" rel="stylesheet">


</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<body>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <div class="brand-logo">
            <a href="<?=BASEURL;?>">User</a>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="<?=BASEURL;?>" class="sidebarLi"><i class="fa fa-tachometer sidebarIcon"></i> Dashboard </a>
            </li>
            <!-- <li>
                <a href="<?=BASEURL;?>user/leads/" class="sidebarLi"><i class="fa fa-th-list sidebarIcon"></i> Leads </a>
            </li> -->
            <li class="mainmenu">
                 <a href="javascript:;" class="sidebarLi"><i class="fa fa-th-list sidebarIcon"></i>  Leads <span class="fa fa-caret-right subMenuIcon"></span></a>
                <ul class="subMenu">
                     <li>
                         <a href="<?=BASEURL;?>user/leads/">All Leads</a>
                     </li>
                     <li>
                         <a href="<?=BASEURL;?>user/addNewLead">Add New Lead</a>
                     </li>
                     <li>
                         <a href="<?=BASEURL;?>user/leadFiltaration">Lead Filter</a>
                     </li>
                </ul>
            </li>
            <li class="mainmenu">
                     <a href="javascript:;" class="sidebarLi"><i class="fa fa-envelope sidebarIcon"></i>  Emailers <span class="fa fa-caret-right subMenuIcon"></span></a>
                    <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>user/newsletterList">All Emailers</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>user/emailer">Add an Emailer</a>
                         </li>
                         
                         </ul>
                         </li>
                         <li class="mainmenu">
                         <a href="javascript:;" class="sidebarLi"><i class="fa fa-bullhorn sidebarIcon"></i>  Campaigns <span class="fa fa-caret-right subMenuIcon"></span></a>
                         <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>user/showCampaignList">Campaign List</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>user/emailSend">Send Campaign</a>
                         </li>
                         
                         </ul>
                         </li>
            <li>
                    <a href="<?=BASEURL;?>user/work/" class="sidebarLi"><i class="fa fa-hourglass-half sidebarIcon"></i>Work</a>

            </li>
            <li>
                    <a href="<?=BASEURL;?>user/followups/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Follow Ups</a>

            </li>
            <li>
                <a href="<?=BASEURL;?>user/articleFiltaration/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Article Filter</a>

            </li>
            <li>
                <a href="<?=BASEURL;?>user/editRequests/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Edit Requests</a>

            </li>
            <li>
                   <a href="<?=BASEURL;?>user/notification/" class="sidebarLi notyfy"><i class="fa fa-bell sidebarIcon"></i>Notification 
                   <?php
                      $userid = Session::get('userId');
                     $reminds = Remind::all(['status'=>1,'user_id'=> $userid]);
                                foreach($reminds as $re){
                                
                                    $todaydat = date('d/m/y', time());
                                    $datatime = date('d/m/y', $re->reminddate);
                                    if($todaydat == $datatime){
                                        
                                    
                    ?>
                    <span><?=count($re);?></span>
                    <?php }}?>
                    </a>
                </li>
        </ul>
    </div>
    <nav>
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <a href="#menu-toggle"  id="menu-toggle"><i class="fa fa-bars barcolor"></i></a>
                <ul class="notify pull-left">
                    <?php 
                        $leadtypemenus = Leadstype::all();
                        foreach ($leadtypemenus as $leadtypemenu) { ?>
                            <li><a href="<?=BASEURL;?>user/lead/<?=$leadtypemenu->name;?>/"> <?=ucwords($leadtypemenu->name);?></a></li>
                        <?php   }
                    ?>
                </ul>
                <ul class="notify pull-right">
                    <li><a href="<?=BASEURL;?>user/changepassword/"><i class="fa fa-cogs"></i></a></li>
                    <li><a href="<?=BASEURL;?>user/userSingout"><i class="fa fa-sign-out"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
