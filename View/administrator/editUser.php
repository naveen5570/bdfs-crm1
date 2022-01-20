<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="leadfrm">
            <form action="<?=BASEURL;?>administrator/updateUser" method="post" enctype="multipart/form-data">
                <div class="creoption">
                    <h1 class="headtit">Update User </h1>
                </div>
                <div class="myform">
                    <h6>User Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Full Name</label>
                            <input type="hidden" name="token" value="<?=$key;?>">
                            <input type="hidden" name="id" value="<?=$data->id;?>">
                            <input type="text" class="form-control" name="name"  value="<?=$data->name;?>" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Photo</label>
                            <input type="file" class="form-control" name="photo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Mobile</label>
                            <input type="number" class="form-control" value="<?=$data->mobile;?>"  name="mob" placeholder="Enter Mobile" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email"  value="<?=$data->email;?>" placeholder="Enter Email Id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Password :</label>
                            <input type="password" class="form-control"  name="pass" placeholder="Enter password">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Confirm Password:</label>
                            <input type="password" class="form-control" name="cpass" placeholder="Enter confirm password">
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>Address Information</h6>
                    <hr class="myhr">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text"  value="<?=$data->address;?>" name="address" placeholder="Enter Your Address">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group eventfrm">
                                <label>State</label>
                                <input class="form-control" type="text" value="<?=$data->states;?>" name="state" placeholder="Enter Your state">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group eventfrm">
                                <label>City</label>
                                <input class="form-control" type="text" value="<?=$data->city;?>" name="city" placeholder="Enter Your city">
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