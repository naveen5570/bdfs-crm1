  <?php
  $key  = Token::generate();
  ?>
  <!DOCTYPE HTML>
  <html>
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">

      <title>User</title>

      <link href="<?=BASEURL;?>assets/lib/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?=BASEURL;?>assets/lib/css/jquery.dataTables.css" rel="stylesheet">
      <link href="<?=BASEURL;?>assets/lib/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?=BASEURL;?>assets/lib/css/toastr.min.css" rel="stylesheet">

      <link href="<?=BASEURL;?>assets/user/css/dash.css" rel="stylesheet">
      <link href="<?=BASEURL;?>assets/user/css/style.css" rel="stylesheet">

  </head>
      <body>
      <div class="page-container">

          <div class="sidebar-menu">
              <header class="logo1">
  			    <a href="#" class="sidebar-icon"><span class="fa fa-bars"></span></a>
              </header>
              <ul class="sidebar-nav">
                  <li>
                      <a href="<?=BASEURL;?>" class="sidebarLi"><i class="fa fa-tachometer sidebarIcon"></i><h6>Dashboard</h6></a>
                  </li>
                  <li>
                      <a href="<?=BASEURL;?>user/leads/" class="sidebarLi"><i class="fa fa-th-list sidebarIcon"></i><h6>Leads</h6></a>
                  </li>
                  <li>
                      <a href="<?=BASEURL;?>user/notification/" class="sidebarLi"><i class="fa fa-bell sidebarIcon"></i><h6>Notification</h6></a>
                   </li>
                   <!--
                  <li class="mainmenu">
                       <a href="javascript:;" class="sidebarLi"><i class="fa fa-picture-o sidebarIcon"></i>  <h6>User</h6><span class="fa fa-caret-right subMenuIcon"></span></a>
                      <ul class="subMenu" style="display: none;">
                           <li>
                               <a href="#">Menu</a>
                           </li>
                           <li>
                               <a href="#">Menu sub menud</a>
                          </li>
                      </ul>
                  </li> -->

              </ul>
          </div>
          <div class="left-content">
              <nav class="navbar">
                  <div class="container-fluid">
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

  <!--
                          <ul class="nav navbar-nav">
                              <li><a href="#">Link</a></li>
                          </ul>
  -->


                          <ul class="nav navbar-nav navbar-right">
                          <!--<li><a href="#">Link</a></li>-->
                              <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=Session::get('userName');?> <span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="#">Profile</a></li>
                                      <li><a href="<?=BASEURL;?>user/changepassword/">Change Password</a></li>
                                      <li role="separator" class="divider"></li>
                                      <li><a href="<?=BASEURL;?>user/userSingout/">Logout</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>
                  </div>
              </nav>
