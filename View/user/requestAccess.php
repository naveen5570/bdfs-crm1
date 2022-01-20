<?php include_once('inc/header.php');?>

<div class="dashnoti">
                 
                 <div class="myform" style="box-shadow:0px 0 0 0 #fff; border:0;">
                    <h6>Request Access</h6>
                    <hr class="myhr">
                    <form action="<?=BASEURL.'/user/requestAccessSave1';?>" method="post">
                    <div class="row"> 
                        <div class="form-group col-md-6 col-sm-6">
                        
                            <label for="">Lead Id</label>
                            <input name="leadid" class="form-control" type="text" readonly value="<?=$lead[0]->id?>">
                        </div>
                        
                        
                        
                        
                        <div class="form-group col-md-6 col-sm-6">
                        
                            <label for="">Lead Name</label>
                            <input name="leadname" class="form-control" type="text" readonly value="<?=$lead[0]->firm_name?>">
                        </div>
                        
                        <div class="col-md-12">
                    <label>Comments</label>
                    <textarea class="form-control" name="comments"></textarea>
                    </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <input type="hidden" name="user_id" value="15">
                        
                            <input name="crd" class="form-control" type="hidden" readonly value="<?=$lead[0]->firm_crd?>">
                        
                    <input type="submit" name="submit" class="btn btn-success" value="Request Access">
                    </div>
                    </div>
                    </form>
                    
                    
                </div>
             </div>
 
          
<?php include_once('inc/footer.php');?>             