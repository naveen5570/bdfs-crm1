<?php
$key  = Token::generate();
//die('test'.$key)
$time = $_SERVER['REQUEST_TIME'];

/**
* for a 30 minute timeout, specified in seconds
*/
$timeout_duration = 10800;

$_SESSION['LAST_ACTIVITY']=time();
/**
* Here we look for the user's LAST_ACTIVITY timestamp. If
* it's set and indicates our $timeout_duration has passed,
* blow away any previous $_SESSION data and start a new one.
*/
if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

/**
* Finally, update LAST_ACTIVITY so that our timeout
* is based on it and not the user's login time.
*/
$_SESSION['LAST_ACTIVITY'] = $time;
//$_SESSION['LAST_ACTIVITY']=time()-(1594886742+100338);
//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
//echo ini_get("session.cookie_lifetime");
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
<link href="<?=BASEURL;?>assets/lib/css/jBox.css" rel="stylesheet">

<link href="<?=BASEURL;?>assets/administrator/css/style.css" rel="stylesheet">
<link href="<?=BASEURL;?>assets/administrator/css/admin.css" rel="stylesheet">

</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript"> $(document).ready(function() {
    $(window).keyup(function(e){
      if(e.keyCode == 44){
        $("body").hide();
      }

    }); }); 
</script>
<body>
<div id="wrapper">

      <div id="sidebar-wrapper">
            <div class="brand-logo">
                <a href="<?=BASEURL;?>administrator">Administration</a>
            </div>
            <ul class="sidebar-nav">

                <li>
                    <a href="<?=BASEURL;?>administrator/" class="sidebarLi"><i class="fa fa-tachometer sidebarIcon"></i>Dashboard</a>

                </li>
                <!-- <li>
                    <a href="<?=BASEURL;?>administrator/leads/" class="sidebarLi"><i class="fa fa-pencil-square-o sidebarIcon"></i>Leads</a>

                </li> -->
                <li class="mainmenu">
                     <a href="javascript:;" class="sidebarLi"><i class="fa fa-pencil-square-o sidebarIcon"></i>  Leads <span class="fa fa-caret-right subMenuIcon"></span></a>
                    <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>administrator/leads/">All Leads</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/addNewLead">Add New Lead</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/uploadlead">Upload Leads</a>
                         </li>
                         
                         <li>
                             <a href="<?=BASEURL;?>administrator/leadFiltaration">Lead Filter</a>
                         </li>
                         
                         <li>
                             <a href="<?=BASEURL;?>administrator/uploadcampaign">Upload Campaigns</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/SendCampaignMail">Send Campaign Mail</a>
                         </li>
                    </ul>
                </li>
                <li class="mainmenu">
                     <a href="javascript:;" class="sidebarLi"><i class="fa fa-users sidebarIcon"></i>  User <span class="fa fa-caret-right subMenuIcon"></span></a>
                    <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>administrator/users/">All User</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/addNewUser">Add New User</a>
                         </li>
                    </ul>
                </li>
                <li class="mainmenu">
                     <a href="javascript:;" class="sidebarLi"><i class="fa fa-envelope sidebarIcon"></i>  Emailers <span class="fa fa-caret-right subMenuIcon"></span></a>
                    <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>administrator/newsletterList">All Emailers</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/emailer">Add an Emailer</a>
                         </li>
                         
                         </ul>
                         </li>
                         <li class="mainmenu">
                         <a href="javascript:;" class="sidebarLi"><i class="fa fa-bullhorn sidebarIcon"></i>  Campaigns <span class="fa fa-caret-right subMenuIcon"></span></a>
                         <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>administrator/showCampaignList">Campaign List</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/emailSend">Send Campaign</a>
                         </li>
                         
                         </ul>
                         </li>
                <li>
                    <a href="<?=BASEURL;?>administrator/view_logs/" class="sidebarLi"><i class="fa fa-hourglass-half sidebarIcon"></i>Status Logs</a>

                </li>
                <li>
                    <a href="<?=BASEURL;?>administrator/followups/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Follow Ups</a>

                </li>
                <li>
                    <a href="<?=BASEURL;?>administrator/editRequests/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Edit Requests</a>

                </li>
                
                <li>
                    <a href="<?=BASEURL;?>administrator/leadsUser/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>User Leads</a>

                </li>
                <li>
                    <a href="<?=BASEURL;?>administrator/leadsUser/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Another Panel</a>

                </li>
                         
                         
                <li>
                <a href="<?=BASEURL;?>administrator/archiveLeads/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Archives</a>

            </li>
         
                <?php /* ?>         
                <li>
                   <a href="<?=BASEURL;?>administrator/notification/" class="sidebarLi notyfy"><i class="fa fa-bell sidebarIcon"></i>Notification 
                   <?php
                     $reminds = Remind::all(['status'=>1]);
                                foreach($reminds as $re){
                                
                                    $todaydat = date('d/m/y', time());
                                    $datatime = date('d/m/y', $re->reminddate);
                                    if($todaydat == $datatime){
                                        
                                    
                    ?>
                    <span><?=count($re);?></span>
                    <?php }}?>
                    </a>
                </li>
                <?php
                */
                ?>
                <!-- <li>
                    <a href="<?=BASEURL;?>administrator/articles/" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>Articles</a>

                </li> -->
                <li class="mainmenu">
                     <a href="javascript:;" class="sidebarLi"><i class="fa fa-file sidebarIcon"></i>  Articles <span class="fa fa-caret-right subMenuIcon"></span></a>
                    <ul class="subMenu">
                         <li>
                             <a href="<?=BASEURL;?>administrator/articles/">All Articles</a>
                         </li>
                         <li>
                             <a href="<?=BASEURL;?>administrator/articleFiltaration">Article Filter</a>
                         </li>
                    </ul>
                </li>
            </ul>
    </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <nav>
            <div class="container-fluid">
                 <a href="#menu-toggle"  id="menu-toggle"><i class="fa fa-bars barcolor"></i></a>
                 <ul class="notify pull-left">
                     <!-- <li><a href="<?=BASEURL;?>administrator/allIndustries/"><i class="fa fa-building"></i> Industries</a></li> -->
                     <li><a href="<?=BASEURL;?>administrator/leadsfrom/"> Leads Type</a></li>
                     
                      <!-- <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                              <i class="fa fa-bell"></i>
                          </a>
                          <ul class="dropdown-menu">
						    <li>
                                <a href="#">
							        <img src="<?=BASEURL;?>assets/administrator/img/user.png" alt="">
                                    <h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti maxime recusandae nulla ad omnis tempora?</h6>
								</a>
                            </li>
                            <li>
                                <a href="#">
							        <img src="<?=BASEURL;?>assets/administrator/img/user.png" alt="">
                                    <h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti maxime recusandae nulla ad omnis tempora?</h6>
								</a>
                            </li>
                            <li>
                                <a href="#">
							        <img src="<?=BASEURL;?>assets/administrator/img/user.png" alt="">
                                    <h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti maxime recusandae nulla ad omnis tempora?</h6>
								</a>
                            </li>

                            <li><a href="#">See all notification</a></li>
				        </ul>
                    </li> -->
                 <?php 
                    $leadtypemenus = Leadstype::all();
                    foreach ($leadtypemenus as $leadtypemenu) { ?>
                         <li><a href="<?=BASEURL;?>administrator/lead/<?=$leadtypemenu->name;?>/"> <?=ucwords($leadtypemenu->name);?></a></li>
                 <?php   }
                 ?>
                 </ul>
                 <ul class="notify pull-right">
                     <li><a href="<?=BASEURL;?>administrator/setting/"><i class="fa fa-cogs"></i></a></li>
                     <li><a href="<?=BASEURL;?>administrator/adminLogout"><i class="fa fa-sign-out"></i></a></li>
                 </ul>
           </div>
         </nav>
