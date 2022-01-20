

<?php include_once('inc/header.php'); ?>
<?php
//echo print_r($_SESSION);
// dsfkj adfkk adsfkjk dafkkj adfkjkjdaf kjkjk jadfkkj kjkjk jdafk kjkj daad jjkj askfjkjadf asdfkjkadsf  this is section is for sessin
?>
<?php
$today = strtotime(date('y-m-d'));
    $tomorrow = $today+86400;
$follow = Followup::all();
?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="viewLead">
            <div class="row">
                <div class="col-md-4">

                     <?php 
                            	$leadstatus = Leadstatu::all(['lead_type_id'=>$data->leadfrom]);
                            	
                            	$leadstypes = Leadstype::all(['id'=>$leadstatus[0]->lead_type_id]);
                            	
                    ?>
                    <h1><?="#".sprintf('%04d',$data->id);?> <?=$data->firm_name;?> (<?=ucwords($leadstypes[0]->name);?>)</h1>

                </div>
                <div class="col-md-8">

                    <div class="nextprvlist">
                        <?php
                            $cid = $data->id;
                            $uid = Session::get('userId');
                            
                            if($type != null || $type != ""){

                            	if($leadcurrentstatus != "" || $leadcurrentstatus != ""){

                                  $leadsnext = Lead::find_by_sql("SELECT * FROM leads WHERE id > $cid   and FIND_IN_SET(".$uid.", user_id) and leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id LIMIT 1;");
                                  $leadsperv = Lead::find_by_sql("SELECT * FROM leads WHERE id < $cid  and FIND_IN_SET(".$uid.", user_id)  and leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id DESC LIMIT 1;");
                                  $leadsfist = Lead::find_by_sql("SELECT id FROM leads WHERE FIND_IN_SET(".$uid.", user_id) and leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id ASC LIMIT 1");
                                  $leadslast = Lead::find_by_sql("SELECT id FROM leads WHERE FIND_IN_SET(".$uid.", user_id) and leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id desc LIMIT 1");

                              }else{
                                  $leadsnext = Lead::find_by_sql("SELECT * FROM leads WHERE id > $cid   and FIND_IN_SET(".$uid.", user_id) and leadfrom = ".$data->leadfrom." ORDER BY id LIMIT 1;");
                                  $leadsperv = Lead::find_by_sql("SELECT * FROM leads WHERE id < $cid  and FIND_IN_SET(".$uid.", user_id)  and leadfrom = ".$data->leadfrom." ORDER BY id DESC LIMIT 1;");
                                  $leadsfist = Lead::find_by_sql("SELECT id FROM leads WHERE FIND_IN_SET(".$uid.", user_id) and leadfrom = ".$data->leadfrom." ORDER BY id ASC LIMIT 1");
                                  $leadslast = Lead::find_by_sql("SELECT id FROM leads WHERE FIND_IN_SET(".$uid.", user_id) and leadfrom = ".$data->leadfrom." ORDER BY id desc LIMIT 1");
                              }

                            }else{

                            	$leadsnext = Lead::find_by_sql("SELECT * FROM leads WHERE id > $cid   and FIND_IN_SET(".$uid.", user_id) ORDER BY id LIMIT 1;");
                            	$leadsperv = Lead::find_by_sql("SELECT * FROM leads WHERE id < $cid   and FIND_IN_SET(".$uid.", user_id) ORDER BY id DESC LIMIT 1;");
                              $leadsfist = Lead::find_by_sql("SELECT * from leads where FIND_IN_SET(".$uid.", user_id) ORDER BY id ASC LIMIT 1");
  	                          $leadslast = Lead::find_by_sql("SELECT * from leads where FIND_IN_SET(".$uid.", user_id) ORDER BY id DESC LIMIT 1");

                            }
                              if($leadsfist[0]->id != $data->id){
                        ?>
                            <a href="<?=BASEURL;?>user/viewLead/<?=$leadsperv[0]->id;?><?php if($type != null || $type != ''){echo '/'.$data->leadfrom; } ?><?php if($leadcurrentstatus != null || $leadcurrentstatus != ''){echo '/'.$leadcurrentstatus; } ?>"><i class="fa fa-angle-left"></i></a></li>
                        <?php } if ($leadslast[0]->id != $data->id) {?>
                        <a href="<?=BASEURL;?>user/viewLead/<?=$leadsnext[0]->id;?><?php if($type != null || $type != ''){echo '/'.$data->leadfrom; } ?><?php if($leadcurrentstatus != null || $leadcurrentstatus != ''){echo '/'.$leadcurrentstatus; } ?>"><i class="fa fa-angle-right"></i></a></li>
                        <?php } ?>
                      </div>
                      <ul class="viewldlst">
                          <?php /* ?>
                        <li> 
                            <select class="statuschange" data-id="<?=$data->id;?>" >
                                <?php
                                    $leadstatus = Leadstatu::all(['lead_type_id'=>$data->leadfrom,]);
                                    foreach ($leadstatus as $leadstatus){
                                ?>
                                <option <?php if($data->lead_status_id == $leadstatus->id ){echo 'selected';}?> value="<?=$leadstatus->id;?>"> <?=$leadstatus->name;?></option>
                                <?php }?>
                            </select>
                       </li>
                          <li><a href="javascript:;" class="leadsentmail" data-mail="<?=$data->ceo_email;?>">Send Mail</a></li><?php */ ?>
                          <li><a href="javascript:;" data-toggle="modal" data-target="#AddNotes">Add Notes</a></li>
                          
<li><a href="javascript:;" data-toggle="modal" data-target="#actionDate"><i class="fa fa-calendar-plus-o"></i></a></li>
<li><span class="status_button_nav">Update Status</span></li>
<li><div class="show_notes" style="font-size:13px">View Notes</div></li>
<?php if($_SESSION['userRole']==2)
{
?>
<li><a href="javascript:;" data-toggle="modal" data-target="#editstatus"><i class="fa fa-ellipsis-v"></i></a></li>
<?php
}
?>
<li><span class="followup_button_nav">Follow Ups</span></li>
<li><span class="edits_button_nav">Suggest Edits</span></li>
                      </ul>
                </div>
            </div>
             <div class="leadinfo">
                <div class="row" style="border-bottom:none; margin:0px;">
                    <div class="col-md-6">
                        <h3>Quick Info</h3>
                         <div class="row">
                            <div class="col-md-4">Phone:</div>
                            <div class="col-md-8"><?=$data->phone;?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">CEO Name:</div>
                            <div class="col-md-8"><?=ucwords($data->ceo_name);?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">CEO Linkedin:</div>
                            <div class="col-md-8"><a href="<?=$data->ceo_linkedin;?>" target="_blank"><?=$data->ceo_linkedin;?></a></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">CCO Name:</div>
                            <div class="col-md-8"><?=ucwords($data->cco_name);?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Lead Status</div>
                            <div class="col-md-8">
                               <?php
                                    $leadstatus = Leadstatu::all(['id'=>$data->lead_status_id]);
                                    echo   $leadstatus[0]->name;
                                ?>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-4">Assign User</div>
                            <div class="col-md-8">
                                <?php
                                    if($data->user_id == 0){
                                      echo 'Admin';
                                    }else{
										$data1=explode(',',$data->user_id);
										
										foreach($data1 as $data2)
										{
                                        $users = Subadmin::all(['id'=>$data2]);
                                        echo $users[0]->name.'<br>';
                                    }}
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-5">
                    	<div class="leadinfo">
                            <h3>Articles Send <a href="javascript:;" data-toggle="modal" data-target="#sendarticle" class="btn addbtn right btn-default"> Send Article</a></h3>

                            <div class="row">
                                <?php
                                  $sendarticleids = [];
                                  foreach ($leadarticles as $leadarticle) {
                                    $sendarticleids[] = $leadarticle->article_id;
                                ?>
                                    <div class="col-md-4 col-sm-12"><?=Article::find($leadarticle->article_id)->name;?>,</div>

                                <?php  } ?>
                            </div>
                        </div>
                        
                    </div>

                </div>



            </div>
            <div class="leadinfo">
                <h3>Lead Information</h3>
                 <div class="row">
                    <div class="col-md-2">Phone</div>
                    <div class="col-md-4"><?=$data->phone;?></div>
                    <div class="col-md-2">Website</div>
                    <div class="col-md-4"><?=$data->website;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Address 1</div>
                    <div class="col-md-4"><?=$data->address_1;?></div>
                    <div class="col-md-2">Address 2</div>
                    <div class="col-md-4"><?=$data->address_2;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Address 3</div>
                    <div class="col-md-4"><?=$data->address_3;?></div>
                    <div class="col-md-2">Address 4</div>
                    <div class="col-md-4"><?=$data->address_4;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">City</div>
                    <div class="col-md-4"><?=$data->city;?></div>
                    <div class="col-md-2">State</div>
                    <div class="col-md-4"><?=$data->state;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Zip Code</div>
                    <div class="col-md-4"><?=$data->zipcode;?></div>
                    <div class="col-md-2">Firm CRD</div>
                    <div class="col-md-4"><?=$data->firm_crd;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Lead From</div>
                    <div class="col-md-4">
                        <?php
                            $leadstypes = Leadstype::all(['id'=>$data->leadfrom]);
                            echo ucwords($leadstypes[0]->name);
                        ?>
                    </div>
                    <div class="col-md-2">Business Lines</div>
                    <div class="col-md-4">
                        <?php
						$business_lines = explode(',',$data->industry_id);
						foreach($business_lines as $lines)
						{
							if($lines!=0)
							{
                            $industries = Businessline::all(['id' => $lines]);
                            echo $industries[0]->name.'.<br>';
						
                        
					
						}	
						}
						?>
                    </div>
                </div>
            </div>
            <div class="leadinfo">
                <h3>CEO Information</h3>
                 <div class="row">
                    <div class="col-md-2">New CEO Name</div>
                    <div class="col-md-4"><?=$data->new_ceo_name;?></div>
                    <div class="col-md-2">CEO Name</div>
                    <div class="col-md-4"><?=$data->ceo_name;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Email</div>
                    <div class="col-md-4"><a href="javascript:;" class="leadsentmail" data-mail="<?=$data->ceo_email;?>"><?=$data->ceo_email;?></a></div>
                    <div class="col-md-2">Number</div>
                    <div class="col-md-4"><?=$data->ceo_number;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">CEO Letter</div>
                    <div class="col-md-4"><?=ucwords($data->ceo_letter_type);?></div>
                    <div class="col-md-2">CRD</div>
                    <div class="col-md-4"><?=$data->ceo_crd;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Finop Name</div>
                    <div class="col-md-4"><?=$data->ceo_finop_name;?></div>
                    <div class="col-md-2">Finop Card</div>
                    <div class="col-md-4"><?=$data->ceo_finop_card;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">CEO Linkedin</div>
                    <div class="col-md-10"><a href="<?=$data->ceo_linkedin;?>" target="_blank"><?=$data->ceo_linkedin;?></a></div>
                </div>
            </div>
            <div class="leadinfo">
                <h3>CCO Information</h3>
                 <div class="row">
                    <div class="col-md-2">New CCO Name</div>
                    <div class="col-md-4"><?=$data->new_cco_name;?></div>
                    <div class="col-md-2">CCO Name</div>
                    <div class="col-md-4"><?=$data->cco_name;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Email</div>
                    <div class="col-md-4"><a href="javascript:;" class="leadsentmail" data-mail="<?=$data->cco_email;?>"><?=$data->cco_email;?></a></div>
                    <div class="col-md-2">Number</div>
                    <div class="col-md-4"><?=$data->cco_number;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">State</div>
                    <div class="col-md-4"><?=$data->cco_state;?></div>
                    <div class="col-md-2">CRD</div>
                    <div class="col-md-4"><?=$data->cco_crd;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">CCO Linkedin</div>
                    <div class="col-md-10"><a href="<?=$data->cco_linkedin;?>" target="_blank"><?=$data->cco_linkedin;?></a></div>
                </div>
            </div>
            <div class="leadinfo">
                <h3>INTRODUCING ARRANGEMENTS</h3>
                <div class="row">
                    <div class="col-md-12"><?=$data->aboutlead;?></div>
                </div>
            </div>
        </div>
 </div></div> 
 <div class="overlay_nav"> </div>
<div class="modal_navv">
<span id="close"> X </span>
<ul class="notesbox">
                            <?php
                              $notes = Note::find_by_sql("SELECT * FROM notes WHERE lead_id = $data->id ORDER BY id DESC;");
                             
                              foreach ($notes as $notes) {
                            ?>
                            <li>
                              <h5>
                                <?php
                                    if($notes->user_id == 0){
                                      echo 'Admin';
                                    }else{
                                      $subadmins = Subadmin::all(['id'=> $notes->user_id]);
                                      echo $subadmins[0]->name;
                                    }
                                ?>
                                <span><?=date('m-d-y',$notes->date);?></span></h5>
                              <h6><?=$notes->msg;?></h6>
                              <?php if ($uid==$notes->user_id)
							  {
								  ?>
                            <a class="edit_notee" data-id="<?php echo $notes->id;?>" href="javascript:;" data-msg="<?php echo $notes->msg;?>" data-toggle="modal" data-target="#EditNotes">Edit Note</a>
                              <form class="delete_note" action="<?=BASEURL;?>user/deleteNotes" method="post">
                               <input type="hidden" value="<?php echo $notes->id;?>" name="id">
                               <input type="hidden" value="<?php echo $data->id;?>" name="lead_id">
                               <input type="submit" value="delete" name="submit">
                               </form>
                               <?php } ?>
                            </li>
                            
                            
                            <?php }?>
                            
                            </ul>
</div>
<?php include_once('inc/footer.php'); ?>
<div class="modal fade mailmodl" id="SendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Mail</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>user/sentMail"   id="sentleadmailfrm" method="post">
                    <div class="form-group">
                        <label for="">To</label>
                        <input type="hidden" value="<?=$key;?>" name="token">
                        <input type="email" name="email" class="form-control" value="<?=$data->ceo_email;?>"  id="emailforsentmail"  required>
                    </div>
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <textarea name="msg" class="form-control" rows="10" required placeholder="Your Message..."></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade addnotesnote" id="AddNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Notes</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>user/addNotes" id="addNotes" class="notesfromsmt" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?=$key;?>" name="token">
                        <input type="hidden" value="<?=$data->id;?>" name="id">
<input type="hidden" value="<?=$type;?>" name="type">
                        <input type="hidden" value="<?=$leadcurrentstatus;?>" name="leadcurrentstatus">
                        <textarea name="msg" class="form-control" required ></textarea>
                        <button class="btn" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="modal fade addnotesnote" id="EditNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Notes</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>user/editNotes" id="addNotes" class="notesfromsmt" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?=$key;?>" name="token">
                        <input type="hidden" value="<?=$data->id;?>" name="id">
                        <input type="hidden" value="" name="note_id">
<input type="hidden" value="<?=$type;?>" name="type">
                        <input type="hidden" value="<?=$leadcurrentstatus;?>" name="leadcurrentstatus">
                        <textarea name="msg" class="form-control" required ></textarea>
                        <button class="btn" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>









<div class="modal fade addnotesnote" id="actionDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Follow Ups</h4>
            </div>
            <div class="modal-body">
            <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#regular" aria-controls="activetb" role="tab"
                                data-toggle="tab">
                                <p class="followup-title">Regular Followups</p>
                            </a></li>
                        <li role="presentation"><a href="#recurring" aria-controls="panding" role="tab" data-toggle="tab">
                                <p class="followup-title">Recurring Followups</p>
                            </a></li>
                            </ul>
                            <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="regular">
                            <form action="<?= BASEURL; ?>user/actionDate" id="actionDate" class="" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?= $key; ?>" name="token">
                        <input type="hidden" value="<?= $data->id; ?>" name="id">
                        <input type="hidden" value="<?= $type; ?>" name="type">
                        <input type="hidden" value="<?= $leadcurrentstatus; ?>" name="leadcurrentstatus">
                        <label for="email">Message</label>
                        <textarea class="form-control" name="msg" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Date</label>
                        <div class="input-group date">
                            <input type="text" name="reminddate" class="form-control datepicker" required>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="">Assign Followups to</label>
                        <select multiple name="user[]" class="form-control js-example-basic-multiple" required>
                            <option value="">--select--</option>
                            <option value="0">Admin</option>
                            <?php
                            $users = Subadmin::all(['status' => 1]);
                            foreach ($users as $users) {
                                echo "<option value='" . $users->id . "'>" . $users->name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="email">Priority</label><br>
                        <select name="priority" class="form-control " required>
                            
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                            
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn" type="submit" style="background:#000;color:#fff;width:100%;">Submit</button>
                    </div>
                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="recurring">
                            <form action="<?= BASEURL; ?>user/actionDate" id="actionDate" class="" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?= $key; ?>" name="token">
                        <input type="hidden" value="<?= $data->id; ?>" name="id">
                        <input type="hidden" value="<?= $type; ?>" name="type">
                        <input type="hidden" value="<?= $leadcurrentstatus; ?>" name="leadcurrentstatus">
                        <label for="email">Message</label>
                        <textarea class="form-control" name="msg" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Date</label>
                        <div class="input-group date">
                            <input type="text" name="reminddate" class="form-control datepicker" required>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="">Assign Followups to</label>
                        <select multiple name="user[]" class="form-control js-example-basic-multiple" required>
                            <option value="">--select--</option>
                            <option value="0">Admin</option>
                            <?php
                            $users = Subadmin::all(['status' => 1]);
                            foreach ($users as $users) {
                                echo "<option value='" . $users->id . "'>" . $users->name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="email">Priority</label><br>
                        <select name="priority" class="form-control " required>
                            
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                            
                        </select>
                    </div>
                    <div class="col-md-12"><label>Repeat in</label></div>
                    <div class="row form-group" style="padding:0 15px">
                    <div class="col-md-6">
                    
                    <input type="number" min='0' name="number" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                    <select name="duration" class="form-control">
                    <option value="">--Select--</option>
                    <option value="days">Days</option>
                    <option value="weeks">Weeks</option>
                    <option value="months">Months</option>
                    </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit" style="background:#000;color:#fff;width:100%;">Submit</button>
                    </div>
                </form>
                            </div>
                            </div>
                
            </div>
        
                            
            
            
        </div>
    </div>
</div>



<!--<div class="modal fade addnotesnote" id="actionDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                <h4 class="modal-title" id="myModalLabel">Action Notes</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <form action="<?=BASEURL;?>user/actionDate" id="actionDate" class="" method="post">-->
<!--                    <div class="form-group">-->
<!--                        <input type="hidden" value="<?=$key;?>" name="token">-->
<!--                        <input type="hidden" value="<?=$data->id;?>" name="id">-->
<!--                        <input type="hidden" value="<?=$type;?>" name="type">-->
<!--                        <input type="hidden" value="<?=$leadcurrentstatus;?>" name="leadcurrentstatus">-->
<!--                        <label for="email">Message</label>-->
<!--     mkjk asdklj sadfkkd kkd kkadfkkj asdkfk asdfkk adsfll kladfk lladsf                   <textarea class="form-control" name="msg" rows="2" required></textarea>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label for="email">Date</label>-->
<!--                      adfdafasdf kjkj mnmm,m z,m,zcv daskeriuie adsfkj   <div class="input-group date">-->
<!--                              <input type="text" name="reminddate" class="form-control datepicker" required>-->
<!--                              <div class="input-group-addon">-->
<!--                                  <span class="glyphicon glyphicon-th"></span>-->
<!--                              </div>-->
<!--                          </div>-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <button class="btn" type="submit" style="background:#000;color:#fff;width:100%;">Submit</button>-->
<!--                    </div>-->
<!--                </form> adfasdf adfadsf adsfdaf sadfdsafsd asdffddd ddd ddddd ddd dfdsafdf asdfds-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->




<div class="modal fade sendarticle" id="sendarticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Article</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-3">Article </div>
                    <div class="col-md-7">
					              <select class="form-control selectedArticle" data-id="<?=$data->id;?>">
                            <?php
                                if(count($sendarticleids) > 0){
                                  $articles = Article::all(['conditions'=>"id NOT IN (".implode(",", $sendarticleids).")"]);

                                }else{
                                  $articles = Article::all();

                                }
								                foreach ($articles as $article){
                            ?>
							                     <option  value=<?=$article->id;?> > <?=$article->name;?></option>
				                    <?php }?>
				                </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary sendArticleBtn">Send</button> </div>
                </div>
              </div>
        </div>
    </div>
</div>
<div class="status_popup">
<span class="close_status">X</span>
<form action="<?=BASEURL;?>user/updateLead1" class="leadstsfrm" method="post">
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
                        
                        
                        
                        
                        
                    </div>
                    <div class="creoption" style="float:left;">
                    <input type="hidden" value="<?= $data->id ?>" name="leadid"/>
                     <button class="btn" type="submit">Update Lead</button>
                </div>
</form>
</div>
<div class="followup_popup">
<span class="close_followup">X</span>
<div class="row">
         <div class="col-md-12">
             <div class="dashnoti">
                 <p class="followup-title">Followup Logs</p>
                 <ul data-time = "<?=time();?>" class="notificationlist">
                     <?php
                         foreach ($follow as $reminder) {
							 if($data->id==$reminder->leadid)
							 {
                               $username = "Admin";
                               $leaddetail = Lead::all(['id' => $reminder->leadid]);
                               if(count($leaddetail) > 0){
                                   if($leaddetail[0]->user_id == 0){
                                       $username = "Admin";
                                   }else{
                                       $leaduserid = $leaddetail[0]->user_id;
                                       $users = Subadmin::all(['id'=>$leaduserid]);
                                       if(count($users)>0){
                                           $username = $users[0]->name;
                                       }else{
                                           $username = "";
                                       }
                                   }
                               }else{
                                 continue;
                               }

                     ?>

                     <li>
                       <a href="<?=BASEURL;?>user/viewLead/<?=$reminder->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail[0]->firm_name; ?><span>Assign User : <?=$username;?></span></h5>
                             <span>Added Date : <?=date('m-d-y', $reminder->date);?></span><br>
                             <span>Reminder Date : <?=date('m-d-y', $reminder->reminder_date);?></span>
                             <p><?=$reminder->msg;?></p>
                       </a>
                     </li>
                     <?php  }
					 
					 } 
					 ?>
                 </ul>
             </div>
         </div>
         

        </div>
</div>
<div class="edits_popup">
<span class="close_edits">X</span>
<div class="row">
         <div class="col-md-12">
             <div class="dashnoti">
                 
                 <div class="myform" style="box-shadow:0px 0 0 0 #fff; border:0;">
                    <h6>Suggest Edits</h6>
                    <hr class="myhr">
                    <form action="<?=BASEURL?>user/suggestEdits" method="post">
                    <div class="row"> 
                        <div class="form-group col-md-6 col-sm-6">
                        
                            <label for="">Lead Id</label>
                            <input name="leadid" class="form-control" type="text" readonly value="<?=$data->id?>">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                           <label for="">Lead CRD</label>
                            <input name="crd" class="form-control" type="text" readonly value="<?=$data->firm_crd?>">
                        </div>
                        
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Field to Change</label>
                            
                            <select multiple="" name="fields[]" class="form-control" required="">
                                <option value="">--select--</option>
                                <option value="Firm Name">Firm Name</option>
                                                                
                                     <option value="Phone"> Phone</option>
                                     <option value="Email"> Email</option>
                                                                 
                                     <option value="CEO Name"> CEO Name</option>
                                     <option value="CEO LinkedIn"> CEO LinkedIn</option>
                                                                 
                                     <option value="Address"> Address</option>
                                                                 
                                     <option value="City" >City</option>
                                                                 
                                     <option value="State" > State</option>
                                       <option value="Zipcode" > Zipcode</option> 
                                       <option value="Firm CRD" > Firm CRD</option> 
                                       <option value="Business Lines" > Business Lines</option>                          
                                     
                                                             </select>
                        </div>
                        <div class="col-md-12">
                    <label>Changes Remarks</label>
                    <textarea class="form-control" name="remarks"></textarea>
                    </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <input type="hidden" name="user_id" value=<?=$uid; ?>>
                    <input type="submit" name="submit" class="btn btn-success">
                    </div>
                    </div>
                    </form>
                </div>
             </div>
         </div>
         

        </div>
</div>

<div class="modal fade addnotesnote" id="editstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Lead</h4>
            </div>
            <div class="modal-body">
                <!-- <div class="row form-group">
                    <div class="col-md-3">Lead Status</div>
                    <div class="col-md-9">
                        <select class="form-control statuschange" data-id="<?=$data->id;?>" >
                            <?php
                                $leadstatus = Leadstatu::all(['lead_type_id'=>$data->leadfrom]);
								foreach ($leadstatus as $leadstatus){
                            ?>
							<option <?php if($data->lead_status_id == $leadstatus->id ){echo 'selected';}?> value="<?=$leadstatus->id;?>"> <?=$leadstatus->name;?></option>
				            <?php }?>
				        </select>
                    </div>
                </div> -->
                <div class="row form-group">
                    <div class="col-md-3">Assign User </div>
                    <div class="col-md-9">
                        <select multiple class="form-control userchange" data-id="<?=$data->id;?>">
                            <option value="0" <?php if($data->user_id == 0){echo 'selected';}?>>Admin</option>
                            <?php
							$data1=explode(',',$data->user_id);
                                $users = Subadmin::all(['status'=>1]);
								foreach ($users as $users){
                            ?>
                            <option value="<?=$users->id;?>" <?php 
									 foreach ($data1 as $data2)
									 {
									 if($data2 == $users->id){echo 'selected';}
									 }
									 ?>> <?=$users->name;
									 
									 ?></option>
                            <?php }?>
                        </select>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=BASEURL;?>assets/lib/js/jquery.easing.js"></script>


<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scrollmy").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
			});
			$('.show_notes').click(function(){
$('.modal_navv').toggle( "slide", { direction: "right"  }, 600 );
$('.overlay_nav').fadeIn();
$('body').css({
    overflow: 'hidden'
});
});
$('#close').click(function(){

$('.modal_navv').toggle( "slide", { direction: "right"  }, 600 );
$('.overlay_nav').fadeOut();
$('body').css({
    overflow: 'auto'
});
		});
});
</script>
<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<script>
							
                            $('.edit_notee').click(function(){
							
							var msg=$(this).attr("data-msg");
							var id=$(this).attr("data-id");
							$('#EditNotes textarea').text(msg);
							$('#EditNotes input[name="note_id"]').val(id);	
							});
							$('.status_button_nav').click(function(){
							$('.status_popup').fadeIn();
							});
							$('.close_status').click(function(){
							$('.status_popup').fadeOut();
							});
							$('.followup_button_nav').click(function(){
							$('.followup_popup').fadeIn();
							});
							$('.close_followup').click(function(){
							$('.followup_popup').fadeOut();
							});
							$('.edits_button_nav').click(function(){
							$('.edits_popup').fadeIn();
							});
							$('.close_edits').click(function(){
							$('.edits_popup').fadeOut();
							});
                            </script>
                            <style>
                            .status_popup, .followup_popup, .edits_popup {position:fixed; transform:translate(-50%,-50%); top:50%; left:50%; max-width:600px; width:100%; z-index:9998; background:#00c6d7; padding:50px 60px; border-radius:8px; display:none; }
							.followup_popup, .edits_popup {padding:10px 20px; max-width:650px; width:100%; height:520px }
							.status_button_nav, .followup_button_nav {cursor:pointer}
							.close_status, .close_followup, .close_edits {position:absolute; right:-8px; font-weight:bold; top:-12px; cursor:pointer; border-radius:50%; padding:4px 10px; background:#000; color:#fff;}
							.dashnoti {overflow-y:auto; height:480px;}
							.followup-title{border-bottom:1px solid #ddd}
							ul.viewldlst li span {
    border: 1px solid #333;
    font-size: 12px;
    color: #333;
    outline: none;
    text-decoration: none;
    padding: 3px 12px;
    cursor: pointer;
    display: inline-block;
}

#close {cursor:pointer; font-size: 20px; font-weight: 900; position: absolute; top:0; left: 0px; padding:0 8px; color:#fff; background:#333; border-radius: 0px 50% 50% 0 ;}
.modal_navv{right:0; left:70%; padding:10px 45px; position: fixed; top:0; background-color: #fff; z-index: 99; overflow-y: scroll;  display: none; background:#f3f3f3; box-shadow: 1px 1px 30px 10px #666; height: 100%}
.show_notes {cursor:pointer; border:1px solid #333; padding:3px 5px;}
ul.notesbox {height: auto; width: 100%;}
ul.notesbox li h6 {height:110px; overflow: auto;}
.overlay_nav {width:100%; height:900vh; background:rgba(0,0,0,0.4); position: absolute; z-index: 98; left:0; top:0; display: none}

.select2-container {width:100% !important}
                            </style>