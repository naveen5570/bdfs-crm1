<?php include_once('inc/header.php');?>
<div class="container">
    <div class="dashuser">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="paddwordbox">
                    <h3>Change Password</h3>
                    <form action="<?=BASEURL;?>user/userPass" method="post">
                        <div class="form-group">
                            <input type="hidden" name="token" value="<?=$key;?>">
                            <input type="password" name="pass"  class="form-control" placeholder="Enter New Password " required>
                        </div>
                        <div class="form-group">
                          <input type="password" name="cpass"  class="form-control" placeholder="Enter confirm Password " required>
                        </div>
                        <div class="form-group"> 
                            <button class="btn btnSubmit">Update Password</button>
                        </div>
                    </form>
               </div>
          </div>
          <div class="col-md-3"></div>
      </div>    
    </div>
</div>
<?php include_once('inc/footer.php');?>