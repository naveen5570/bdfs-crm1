<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="mydiv">
                    <h4>Information</h4>
                    <form action="<?=BASEURL;?>administrator/updateinfo" method="post">
                        <div class="form-group">
                            <input type="hidden" name="adminId" value="<?=$admins->id;?>">
                            <input type="text" name="name" value="<?=$admins->name?>"class="form-control" placeholder=" Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="mob" value="<?=$admins->mobile;?>"class="form-control" placeholder="Your Mobile No." required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" value="<?=$admins->email;?>" class="form-control" placeholder="Your Email Id" required>
                        </div>
                        <input type="submit" class="btn">
                    </form>
                </div>        
            </div>
            <div class="col-md-6">
                <div class="mydiv">
                    <h4>Password</h4>
                    <form action="<?=BASEURL;?>administrator/changePass" method="post">
                        <div class="form-group">
                            <input type="hidden" name="adminId" vlaue="<?=$admins->id;?>">
                            <input type="password" name="pass" class="form-control" placeholder="Ender Your Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="cpass" class="form-control" placeholder="Ender Your Password" required>
                        </div>
                        <input type="submit" class="btn">
                    </form>
                </div>        
            </div>
        </div>            
    </div>
</div>
<?php include_once('inc/footer.php');?>