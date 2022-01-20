<?php
  $key  = Token::generate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="<?=BASEURL;?>assets/lib/css/bootstrap.min.css" rel='stylesheet'/>
    <link href="<?=BASEURL;?>assets/lib/css/font-awesome.min.css" rel="stylesheet"> 
    <link href="<?=BASEURL;?>assets/lib/css/toastr.min.css" rel="stylesheet">
    <link href="<?=BASEURL;?>assets/user/css/login.css" rel="stylesheet">
</head>
<body>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h1>Log in to your Account</h1>
        <div class="login-form">
            <form action="<?=BASEURL;?>user/userSingIn" method="post">    
              <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="hidden" name="token" value="<?=$key;?>">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
              </div>
              <div class="form-group">
                <i class="fa fa-key"></i>
                <input type="password" name="pass" class="form-control" id="pwd"  placeholder="Password">
              </div>
              <button type="submit" class="btn">Login</button>
            </form>
            <p>Forgot Your Password <a data-toggle="modal" href="#forgotpass">Click here</a></p>		
        </div>
    </div>
    <div class="col-md-4"></div>
</body>
</html>
<script src="<?=BASEURL;?>assets/lib/js/jquery.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/bootstrap.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/toastr.min.js"></script>
<script>
          $(function(){
             toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-bottom-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
           
            <?php 
             if(isset($_SESSION['msg']) && isset($_SESSION['title'])){ ?>
              toastr["<?=$_SESSION['title'];?>"]("<?=$_SESSION['msg'];?>","<?=$_SESSION['title'];?>");
            <?php    
                 unset($_SESSION['msg']);
                unset($_SESSION['title']);
             }
             
          ?>

          });
</script>
<div class="modal fade" id="forgotpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
      </div>
      <div class="modal-body">
        <form action="#" method="post">
            <div class="form-group">
                <label for="">Email address</label>
                <input type="hidden" name="key"  value="<?=$key;?>">
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter Your Email Id" required>
            </div>
            <button type="submit" class="btn mybtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>        