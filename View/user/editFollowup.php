<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="leadfrm">
            <form action="<?=BASEURL;?>user/updateFollowup" method="post" enctype="multipart/form-data">
                <div class="creoption">
                    <h1 class="headtit">Update Followup</h1>
                </div>
                <div class="myform">
                    <h6>Followup Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead Id</label>
							<select name="leadid" class="form-control" required>
                            <?php
							$leads = Lead::all();
							foreach ($leads as $lead)
							{
							?>
							<option <?php if($lead->id==$data[0]->leadid){echo "selected";} ?> value="<?=$lead->id;?>"><?=$lead->firm_name;?></option>
							<?php
							}
								?>
							</select>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Message</label>
                            <input type="text" class="form-control" value="<?=$data[0]->msg;?>"  name="msg" placeholder="Enter Msg" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Followup Date</label>
                            <div class="input-group date">
                            <input type="text" class="form-control datepicker" value="<?=date('m/d/Y',$data[0]->reminder_date);?>"  name="reminder_date" placeholder="Enter Date" required>
                            <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                              </div>
                              </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                        <label for="email">Priority</label>
                        <select name="priority" class="form-control js-example-basic-multiple" required>
                            
                            <option value="0" <?php if($data[0]->priority==0){echo "selected";}?>>Low</option>
                            <option value="1" <?php if($data[0]->priority==1){echo "selected";}?>>Medium</option>
                            <option value="2" <?php if($data[0]->priority==2){echo "selected";}?>>High</option>
                            
                        </select>
                    </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                        <label for="">Assign Lead to</label>
                        <?php  //print_r($data[0]->user_id);?>
                        <select multiple name="user[]" class="form-control js-example-basic-multiple" required>
                            <option value="">--select--</option>
                            <?php $du = explode(',', $data[0]->user_id); ?>
                            <option <?php if(in_array('0',$du)){echo "selected";} ?> value="0">Admin</option>
                            <?php
                            $users = Subadmin::all(['status' => 1]);
							
                            foreach ($users as $users) {
								?>
                                
                                <option <?php if(in_array($users->id,$du)){echo 'selected';} ?>  value='<?=$users->id?>'><?=$users->name;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                        </div>
                </div>
                
                <div class="creoption">
                    <input type="hidden" name="assigned_by" value="<?=$data[0]->assigned_by?>">
					<input type="hidden" name="id" value="<?=$data[0]->id?>">
                    <button class="btn" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>    
</div>
<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<?php include_once('inc/footer.php');?>