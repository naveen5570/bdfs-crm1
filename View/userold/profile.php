<?php include_once('inc/header.php');?>
<div class="container">
    <div class="dashuser">
       <div class="row">
           <div class="col-md-3">
                <div class="userbox">
                    <i class="fa fa-user"></i>
                    <?php $uid = Session::get('userId'); ?>
                    <h3><?=count(Lead::all(['user_id'=> $uid]));?></h3>
                    <h6>All Leads</h6>
                </div>
           </div>
           <div class="col-md-3">
                <div class="userbox">
                    <i class="fa fa-user"></i>
                    <h3>22</h3>
                    <h6>All Leads</h6>
                </div>
           </div>
           <div class="col-md-3">
                <div class="userbox">
                    <i class="fa fa-user"></i>
                    <h3>22</h3>
                    <h6>All Leads</h6>
                </div>
           </div>
           <div class="col-md-3">
                <div class="userbox">
                    <i class="fa fa-user"></i>
                    <h3>22</h3>
                    <h6>Convert  Leads</h6>
                </div>
           </div>
       </div>
    </div>
</div>
<?php include_once('inc/footer.php');?>
