<?php include_once('inc/header.php');?>

<div class="dashnoti">
                 
                 <div class="myform" style="box-shadow:0px 0 0 0 #fff; border:0;">
                    <h6>Request Access</h6>
                    <hr class="myhr">
                    <!--<form action="<?=BASEURL.'/user/requestAccessSave';?>" method="post">
                    <div class="row"> 
                        <div class="form-group col-md-6 col-sm-6">
                        
                            <label for="">Lead Id</label>
                            <input name="leadid" class="form-control" type="text">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                           <label for="">Lead CRD</label>
                            <input name="crd" class="form-control" type="text" >
                        </div>
                        
                        
                        <div class="col-md-12">
                    <label>Comments</label>
                    <textarea class="form-control" name="comments"></textarea>
                    </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <input type="hidden" name="user_id" value="15">
                    <input type="submit" name="submit" class="btn btn-success">
                    </div>
                    </div>
                    </form> -->
                    
                    <input class="form-control" id="email" type="email" name="email" placeholder="Enter Email..." required/> <br>
                    <button class="btn btn-success" id="search_email">Lookup</button>
                    
                    <table id="lookUp_result">
                    <tr>
                    <th>
                    Lead
                    </th>
                    <th>
                    Action
                    </th>
                    </tr>
                    <tr>
                    <td>
                    <div id="get_result"></div>
                    </td>
                    <td>
                    <div id="request_access"></div>
                    </td>
                    </tr>
                    </table>
                </div>
             </div>
 
<style>
table td, th{ border:1px solid #ddd; padding:0 12px;}
#lookUp_result {display:none;}
</style>           
<?php include_once('inc/footer.php');?>             