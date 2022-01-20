<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="leadfrm">
            <form action="<?=BASEURL;?>administrator/updateLead" class="leadstsfrm" method="post">
                <div class="creoption">
                    <h1 class="headtit">Update Lead</h1>
                    <button class="btn" type="submit">Update Lead</button>
                </div>
                <div class="myform">
                    <h6>Lead Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Name of Firm</label>
                            <input type="hidden" name="leadid" value="<?=$data->id;?>">
                            <input type="text" class="form-control" name="firm_name" value="<?=$data->firm_name;?>" placeholder="Enter Firm Name" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 1</label>
                            <input type="text" class="form-control" name="address_1" value="<?=$data->address_1;?>"  placeholder="Enter Address line 1" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 2</label>
                            <input type="text" class="form-control" name="address_2" value="<?=$data->address_2;?>" placeholder="Enter Address line 2">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 3</label>
                            <input type="text" class="form-control" name="address_3" value="<?=$data->address_3;?>" placeholder="Enter Address line 3">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 4</label>
                            <input type="text" class="form-control" name="address_4" value="<?=$data->address_4;?>" placeholder="Enter Address line 4">
                        </div>
                         <div class="form-group col-md-6 col-sm-6">
                            <label for="">City</label>
                            <input type="text" class="form-control" name="city" value="<?=$data->city;?>" placeholder="Enter City" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">State</label>
                            <input type="text" class="form-control" name="state" value="<?=$data->state;?>" placeholder="Enter state" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Zip Code</label>
                            <input type="text" class="form-control" name="zipcode" value="<?=$data->zipcode;?>" placeholder="Enter Zip Code">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?=$data->phone;?>" placeholder="Enter Phone number" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Firm CRD</label>
                            <input type="text" class="form-control" name="firm_crd" value="<?=$data->firm_crd;?>" placeholder="Enter Firm CRD">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Website</label>
                            <input type="text" class="form-control" name="website" value="<?=$data->website;?>" placeholder="Enter Website">
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>CEO Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <?php /* ?>
                       <div class="form-group col-md-6 col-sm-6">
                            <label for="">New CEO Name</label>
                            <input type="text" class="form-control" name="new_ceo_name" value="<?=$data->new_ceo_name;?>" placeholder="Enter New CEO Name" >
                        </div>
                        <?php */
                        ?>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="field">CEO Name</label>
                            <input type="text" class="form-control" name="ceo_name" value="<?=$data->ceo_name;?>" placeholder="Enter CEO Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO Email</label>
                            <input type="email" class="form-control" name="ceo_email" value="<?=$data->ceo_email;?>" placeholder="Enter CEO Email" >
                        </div>
                        <?php /*
                        ?>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO Cell Number</label>
                            <input type="number" class="form-control" name="ceo_number" value="<?=$data->ceo_number;?>" placeholder="Enter CEO Cell Number">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO Linkedin</label>
                            <input type="text" class="form-control" name="ceo_linkedin" value="<?=$data->ceo_linkedin;?>" placeholder="Enter CEO Linkedin url">
                        </div>
                        <div class="col-md-6 col-sm-6 form-group">
                            <label for="">Letter Type</label>
                            <div class="form-group" name="ceo_letter_type" required>
                                <label class="radio-inline"><input type="radio" name="optradio" <?php if($data->ceo_letter_type == 'yes'){echo 'checked';}?> value="yes" >Accepted Connect?</label>
                                <label class="radio-inline"><input type="radio" name="optradio" <?php if($data->ceo_letter_type == 'no'){echo 'checked';}?> value="no">No Accept</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO CRD</label>
                            <input type="text" class="form-control" name="ceo_crd" value="<?=$data->ceo_crd;?>" placeholder="Enter CEO CRD" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">FINOP Name</label>
                            <input type="text" class="form-control" name="ceo_finop_name" value="<?=$data->ceo_finop_name;?>" placeholder="Enter FINOP Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">FINOP Card</label>
                            <input type="text" class="form-control" name="ceo_finop_card" value="<?=$data->ceo_finop_card;?>" placeholder="Enter FINOP Card">
                        </div>
                        <?php
                        */
                        ?>
                    </div>
                </div>
                <?php
                /*
                ?>
                <div class="myform">
                    <h6>CCO Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="field">CCO Name</label>
                            <input type="text" id="field" class="form-control" name="cco_name" value="<?=$data->cco_name;?>"  placeholder="Enter CCO Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">New CCO Name</label>
                            <input type="text" class="form-control" name="new_cco_name" value="<?=$data->new_cco_name;?>"  placeholder="Enter New CCO Name " >
                        </div>

                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO Email</label>
                            <input type="email" class="form-control" name="cco_email" value="<?=$data->cco_email;?>" placeholder="Enter CCO Email">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO Cell Number</label>
                            <input type="number" class="form-control" name="cco_number" value="<?=$data->cco_number;?>" placeholder="Enter CCO Cell Number">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO Linkedin</label>
                            <input type="text" class="form-control" name="cco_linkedin" value="<?=$data->cco_linkedin;?>" placeholder="Enter CCO Linkedin url">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO CRD</label>
                            <input type="text" class="form-control" name="cco_crd" value="<?=$data->cco_crd;?>" placeholder="Enter CCO CRD" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">State</label>
                            <input type="text" class="form-control" name="cco_state" value="<?=$data->cco_state;?>" placeholder="Enter State">
                        </div>
                    </div>
                </div>
                <?php
                */
                ?>
                <div class="myform">
                    <h6>Lead Details</h6>
                    <hr class="myhr">
                    <div class="row"> 
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead From</label>
                            <select name="leadfrom" class="form-control leadtypeselect" required>
                                <option value="">--select--</option>
                                <?php
                                    $leadstypes = Leadstype::all(['status'=>1]);
                                    foreach($leadstypes as $leadstypes){
                                    
                                ?>
                                    <option value="<?=$leadstypes->id;?>" <?php if($data->leadfrom == $leadstypes->id){echo 'selected';}?>><?=ucwords($leadstypes->name);?></option>
                                <?php }?>
                            </select>
                        </div>
                           
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead Status</label>
                            <select name="lead_status" class="form-control leadstatusbytype" required>
                               <?php
                                    $leadstatus = Leadstatu::all(['lead_type_id'=>$data->leadfrom]);
                                    
                                    foreach($leadstatus as $leadstatus){
                                ?>
                                <option value="<?=$leadstatus->id;?>" <?php if($data->lead_status_id == $leadstatus->id){echo 'selected';}?>><?=$leadstatus->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead Substatus</label>
                            <select name="lead_substatus" class="form-control leadsubstatusbystatus">
                               <?php
                                    $leadsubstatus = Leadsubstatu::all(['lead_status_id'=>$data->lead_status_id]);
                                    foreach($leadsubstatus as $leadsubstatus){
                                ?>
                                <option value="<?=$leadsubstatus->id;?>" <?php if($data->lead_substatus_id == $leadsubstatus->id){echo 'selected';}?>><?=$leadsubstatus->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead Sub-substatus</label>
                            <select name="lead_subsubstatus" class="form-control leadsubsubstatusbysubstatus">
                               <?php
                                    $leadsubsubstatus = Leadsubsubstatu::all(['lead_substatus_id'=>$data->lead_substatus_id]);
                                    foreach($leadsubsubstatus as $leadsubsubstatus){
                                ?>
                                <option value="<?=$leadsubsubstatus->id;?>" <?php if($data->lead_subsubstatus_id == $leadsubsubstatus->id){echo 'selected';}?>><?=$leadsubsubstatus->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4 col-sm-4">
                        <label for="">Enter type of value</label>
                        <select class="form-control change_nav" name="bus_type">
                        <option value="number">Enter value in numbers</option>
                        <option value="names">Enter value in names</option>
                        </select>
                        </div>
                        <div class="form-group col-md-8 col-sm-8 bus_number">
                            <label for="">Select Business Line Ids</label>
                            <select  multiple name="business_lines1[]" class="form-control js-example-basic-multiple" >
                                
                                
                                <?php
                                    $users = Subadmin::all(['status'=>1]);
                                    foreach($business_lines as $business_lines1){
                                        $arr = explode(',',$data->industry_id);
                                        ?>

                                        <option <?php if(in_array($business_lines1->id,$arr)){echo "selected";}?> value="<?=$business_lines1->id;?>"><?=$business_lines1->id;?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    
                    
                        <div class="form-group col-md-8 col-sm-8 bus_names">

                            <label for="">Select Business Line Names</label>
                            <select  multiple name="business_lines[]" class="form-control js-example-basic-multiple" >
                                
                                <?php
                                    $users = Subadmin::all(['status'=>1]);
                                    foreach($business_lines as $business_lines2){
                                        $arr = explode(',',$data->industry_id);
                                        ?>

                                        <option <?php if(in_array($business_lines2->id,$arr)){echo "selected";}?> value="<?=$business_lines2->id;?>">(<?=$business_lines2->id;?>) <?=$business_lines2->name;?></option>
                                        <?php
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Assign Lead to</label>
                            
                            <select multiple name="user[]" class="form-control js-example-basic-multiple" required>
                                <option value="">--select--</option>
                                <option value="0" <?php if($data->user_id == 0){echo 'selected';}?>>Admin</option>
                                <?php
								
								$data1=explode(',',$data->user_id);
								
                                    $users = Subadmin::all(['status'=>1]);
                                    foreach($users as $users){
								
								?>
                                
                                     <option value="<?=$users->id;?>" <?php 
									 foreach ($data1 as $data2)
									 {
									 if($data2 == $users->id){echo 'selected';}
									 }
									 ?>> <?=$users->name;
									 
									 ?></option>
                                 <?php   } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Rom Branch Count</label>
                            
                            <input name="rom_branch_count" type="number" value="<?=$data->rom_branch_count;?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>INTRODUCING ARRANGEMENTS</h6>
                    <hr class="myhr">
                    <div class="form-group">
                        <textarea rows="5"  class="form-control" name="aboutlead" ><?=$data->aboutlead;?></textarea>
                    </div>
                </div>
                <div class="creoption">
                     <button class="btn" type="submit">Update Lead</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
.bus_names{display:none;}
.select2-container {width:100% !important;}
</style>
<script>
$(document).ready(function() {
$('.js-example-basic-multiple').select2();

$('.change_nav').change(function(){
if($(this).val()=='number')
{
$('.bus_names').css('display','none');
$('.bus_number').css('display','inline');    
}
else
{
$('.bus_number').css('display','none');
$('.bus_names').css('display','inline'); 

}
});
});
</script>
<?php include_once('inc/footer.php');?>
