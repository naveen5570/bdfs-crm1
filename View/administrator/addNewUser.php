<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="leadfrm">
            <form action="<?=BASEURL;?>administrator/addUser" method="post" enctype="multipart/form-data">
                <div class="creoption">
                    <h1 class="headtit">Add New User</h1>
                </div>
                <div class="myform">
                    <h6>User Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="">Full Name</label>
                            <input type="hidden" name="token" value="<?=$key;?>">
                            <input type="text" class="form-control" name="name" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="">Photo</label>
                            <input type="file" class="form-control" name="photo">
                        </div>
                        
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="">Role</label>
                            <select class="form-control" name="role">
                            <option value="1">User</option>
                            <option value="2">Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Mobile</label>
                            <input type="number" class="form-control" name="mob" placeholder="Enter Mobile" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email Id" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Password :</label>
                            <input type="password" class="form-control"  name="pass" placeholder="Enter password" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Confirm Password:</label>
                            <input type="password" class="form-control" name="cpass" placeholder="Enter confirm password" required>
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>Address Information</h6>
                    <hr class="myhr">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" name="address" placeholder="Enter Your Address">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group eventfrm">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" placeholder="Enter Your state">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group eventfrm">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" placeholder="Enter Your city">
                            </div>
                        </div>
                </div>
                <div class="creoption">
                    <button class="btn" type="submit">Save User</button>
                </div>
            </form>
        </div>
    </div>    
</div>
<?php include_once('inc/footer.php');?>