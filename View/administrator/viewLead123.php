<?php include_once('inc/header.php'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="viewLead">
            <div class="row">
                <div class="col-md-4">
                <div class="del_modal_nav"><h5>Are you sure you want to delete this lead?</h5><ul class="main_nav"><li><a  href="javascript:;" class="deletesigLead" data-id="<?=$data->id;?>">Yes</a></li><li><span class="no_nav">No</span></li></ul>
</div>

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

                          if($type != null || $type != ""){


                          	if($leadcurrentstatus != "" || $leadcurrentstatus != ""){

	                                $leadsnext = Lead::find_by_sql("SELECT * FROM leads WHERE id > $cid and leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id LIMIT 1;");
	                                $leadsperv = Lead::find_by_sql("SELECT * FROM leads WHERE id < $cid and leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id DESC LIMIT 1;");
	                                $leadsfist = Lead::find_by_sql("SELECT id FROM leads WHERE leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id ASC LIMIT 1");
	                                $leadslast = Lead::find_by_sql("SELECT id FROM leads WHERE leadfrom = ".$data->leadfrom." and lead_status_id = ".$leadcurrentstatus." ORDER BY id desc LIMIT 1");

	                         }else{
	                                $leadsnext = Lead::find_by_sql("SELECT * FROM leads WHERE id > $cid and leadfrom = ".$data->leadfrom." ORDER BY id LIMIT 1;");
	                                $leadsperv = Lead::find_by_sql("SELECT * FROM leads WHERE id < $cid and leadfrom = ".$data->leadfrom." ORDER BY id DESC LIMIT 1;");
	                                $leadsfist = Lead::find_by_sql("SELECT id FROM leads WHERE leadfrom = ".$data->leadfrom." ORDER BY id ASC LIMIT 1");
	                                $leadslast = Lead::find_by_sql("SELECT id FROM leads WHERE leadfrom = ".$data->leadfrom." ORDER BY id desc LIMIT 1");
	                         }

                          }else{

                          	$leadsnext = Lead::find_by_sql("SELECT * FROM leads WHERE id > $cid ORDER BY id LIMIT 1;");
                          	$leadsperv = Lead::find_by_sql("SELECT * FROM leads WHERE id < $cid ORDER BY id DESC LIMIT 1;");
                          	$leadsfist = Lead::find_by_sql("SELECT id FROM leads WHERE id = (SELECT MIN(id) FROM leads)");
                          	$leadslast = Lead::find_by_sql("SELECT id FROM leads WHERE id = (SELECT MAX(id) FROM leads)");

                          }

                          if($leadsfist[0]->id != $data->id){
                        ?>
                        <a href="<?=BASEURL;?>administrator/viewLead/<?=$leadsperv[0]->id;?><?php if($type != null || $type != ''){echo '/'.$data->leadfrom; } ?><?php if($leadcurrentstatus != null || $leadcurrentstatus != ''){echo '/'.$leadcurrentstatus; } ?>"><i class="fa fa-angle-left"></i></a></li>
                        <?php } if ($leadslast[0]->id != $data->id) {?>
                        <a href="<?=BASEURL;?>administrator/viewLead/<?=$leadsnext[0]->id;?><?php if($type != null || $type != ''){echo '/'.$data->leadfrom; } ?><?php if($leadcurrentstatus != null || $leadcurrentstatus != ''){echo '/'.$leadcurrentstatus; } ?>"><i class="fa fa-angle-right"></i></a></li>
                        <?php } ?>
                      </div>
                      <ul class="viewldlst">

                       <li>

                            <select class="statuschange" data-id="<?=$data->id;?>" >
                            <?php

                                foreach ($leadstatus as $leadstatus){
                            ?>
                            <option <?php if($data->lead_status_id == $leadstatus->id ){echo 'selected';}?> value="<?=$leadstatus->id;?>"> <?=$leadstatus->name;?></option>
                            <?php }?>
                        </select>
                        </li>
                          <li><a href="javascript:;" class="leadsentmail" data-mail="<?=$data->ceo_email;?>" data-id="<?=$data->id;?>">Send Mail</a></li>
                          <li><a href="javascript:;" data-toggle="modal" data-target="#AddNotes">Add Notes</a></li>
                          <li><a href="<?=BASEURL;?>administrator/editLead/<?=$data->id;?>">Edit</a></li>
                          <li id="del_nav_lead"><span><i class="fa fa-trash-o"></i></span></li>
                          <!--<li><a  href="javascript:;" class="deletesigLead" data-id="<?=$data->id;?>"><i class="fa fa-trash-o"></i> </a></li> -->
                          <li><a href="javascript:;" data-toggle="modal" data-target="#editstatus"><i class="fa fa-ellipsis-v"></i></a></li>
<li><a href="javascript:;" data-toggle="modal" data-target="#actionDate"><i class="fa fa-calendar-plus-o"></i></a></li>
                          <li><a href="javascript:;" data-toggle="modal" data-target="#actionDate"><i class="fa fa-repeat"></i></a></li>
                      </ul>
                </div>
            </div>
             <div class="leadinfo">
                <div class="row" style="border-bottom:none; margin:0px;">
                    <div class="col-md-6">
                        <h3>Quick Info </h3>
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
                                    <div class="col-md-4 col-sm-12"><?=Article::find($leadarticle->article_id)->name;?></div>

                                <?php  } ?>
                            </div>
                        </div>
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
                                <span><?=date('d,M Y',$notes->date);?></span></h5>
                              <h6><?=$notes->msg;?></h6>
                              <a class="edit_notee" data-id="<?php echo $notes->id;?>" href="javascript:;" data-msg="<?php echo $notes->msg;?>" data-toggle="modal" data-target="#EditNotes">Edit Note</a>
                              <form class="delete_note" action="<?=BASEURL;?>administrator/deleteNotes" method="post">
                               <input type="hidden" value="<?php echo $notes->id;?>" name="id">
                               <input type="hidden" value="<?php echo $data->id;?>" name="lead_id">
                               <input type="submit" value="delete" name="submit">
                               </form>
                            </li>
                            
                            
                            <?php }?>
                            	
                          </ul>
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
<?php include_once('inc/footer.php'); ?>
<div class="modal fade mailmodl" id="SendMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Mail</h4>
            </div>
            <div class="modal-body" id="editor">
                <form action="<?=BASEURL;?>administrator/sentMail"  id="sentleadmailfrm" method="post">
                    <div class="form-group">
                        <label for="">To</label>
                        <input type="hidden" value="<?=$key;?>" name="token">
                        
                        <input type="hidden" value="<?=$data->id;?>" name="lead_id">
                        <input type="email" name="email" class="form-control" value="<?=$data->ceo_email;?>" id="emailforsentmail" required>
                    </div>
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <textarea id="edit" name="msg" class="form-control" rows="10" required placeholder="Your Message..."></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade addnotesnote" id="editstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<div class="modal fade addnotesnote" id="AddNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Notes</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>administrator/addNotes" id="addNotes" class="notesfromsmt" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?=$key;?>" name="token">
                        <input type="hidden" value="<?=$data->id;?>" name="id">
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

<div class="modal fade addnotesnote" id="EditNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Notes</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>administrator/editNotes" id="addNotes" class="notesfromsmt" method="post">
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
                <h4 class="modal-title" id="myModalLabel">Action Notes</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>administrator/actionDate" id="actionDate" class="" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?=$key;?>" name="token">
                        <input type="hidden" value="<?=$data->id;?>" name="id">
                        <input type="hidden" value="<?=$type;?>" name="type">
                        <input type="hidden" value="<?=$leadcurrentstatus;?>" name="leadcurrentstatus">
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
                    <div class="form-group">
                        <button class="btn" type="submit" style="background:#000;color:#fff;width:100%;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
<script src="<?=BASEURL;?>assets/lib/js/jquery.easing.js"></script>
<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scrollmy").click(function(event){
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
			});
		});
</script>
<script>
                            $('.edit_notee').click(function(){
							var msg=$(this).attr("data-msg");
							var id=$(this).attr("data-id");
							$('#EditNotes textarea').text(msg);
							$('#EditNotes input[name="note_id"]').val(id);	
							});
							
							$('#del_nav_lead').click(function(){
								
							});
							
							$('#del_nav_lead span').click(function(){
							$('.del_modal_nav').fadeIn();	
							});
							$('.main_nav li span').click(function(){
							$('.del_modal_nav').fadeOut();	
							});
                            </script>
                            
                            <style>
							#del_nav_lead span {cursor:pointer; border:1px solid #333; padding:3px 8px;}
                            .del_modal_nav {position:fixed; min-width:300px; width:100%; max-width:350px; transform:translate(-50%,-50%); top:50%; left:50%; background:#00c6d7; z-index:999; padding:25px 20px; border-radius:10px; text-align:center; display:none;}
							
							.del_modal_nav li {list-style:none; float:left; display:inline; padding:3px 12px; background:#fff; margin-left:5px;}                            .del_modal_nav a{color:#333; text-decoration:none}
							.del_modal_nav span {cursor:pointer}
							.del_modal_nav h5 {color:#fff; text-align:center;}
							.main_nav { width:100%; max-width:120px; margin:0 auto; padding-top:10px;}
                            </style>