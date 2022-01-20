<?php include_once('inc/header.php'); ?>
<?php $uid = Session::get('userId'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="dashnoti">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#activetb" aria-controls="activetb" role="tab"
                                data-toggle="tab">
                                <p class="followup-title">Today's Followups</p>
                            </a></li>
                        <li role="presentation"><a href="#panding" aria-controls="panding" role="tab" data-toggle="tab">
                                <p class="followup-title">Pending Followups</p>
                            </a></li>

                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="activetb">
                            <ul data-time="<?=time();?>" class="notificationlist">
                                <?php
                         foreach ($reminders as $reminder) {
                             if($reminder->status==0 && $reminder->assigned_by == 17 ||$reminder->assigned_by == 15 ||$reminder->assigned_by == 19 || $reminder->assigned_by == 20 ||$reminder->assigned_by == 18  || $reminder->user_id == $uid)
                           
                             {
                               $leaddetail = Lead::all(['id' => $reminder->leadid]);
                               if (count($leaddetail) > 0) {
                                if ($leaddetail[0]->user_id == 0) {
                                    $username = "Admin";
                                } else {
                                    $leaduserid = $leaddetail[0]->user_id;
                                    $users = Subadmin::all(['id' => $leaduserid]);
                                    $assigned = Subadmin::all(['id'=>$reminder->user_id]);
                                    if (count($users) > 0) {
                                        $username = $users[0]->name;
                                    } else {
                                        $username = "";
                                    }
                                }
                            } else {
                                continue;
                            }
                     ?>

                                <li>
                                    <a href="<?=BASEURL;?>user/viewLead/<?=$reminder->leadid;?>" target="_blank">


                                        <h5>Lead: <?=$leaddetail[0]->firm_name; ?><span>Assign From :
                                                <?=$username;?></span><span>Added
                                                date:<?=date('m-d-Y',$reminder->date);?></span><span>Reminder
                                                date:<?=date('m-d-Y',$reminder->reminder_date);?></span></h5>

                                        <p><?=$reminder->msg;?></p>
                                        <p>Assign To:
                                            <?php if($reminder->user_id==0){echo "Admin";} else {echo $assigned[0]->name;}?>
                                        </p>
                                    </a>
                                    <a href="<?=BASEURL;?>user/followMarkComplete/<?=$reminder->id?>"
                                        class="btn btn-success"
                                        style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as
                                        Complete</a>&nbsp;<a href="<?=BASEURL;?>user/editFollowup/<?=$reminder->id?>"
                                        class="btn btn-info"
                                        style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a
                                        href="<?=BASEURL;?>user/deleteFollowup/<?=$reminder->id?>"
                                        class="btn btn-danger"
                                        style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>

                                </li>
                                <?php  
                             }
                     } ?>
                            </ul>
                        </div>
					
					
					
					<div role="tabpanel" class="tab-pane" id="panding">
					<ul data-time = "<?=time();?>" class="notificationlist">
                     <?php
                         foreach ($reminders1 as $reminder1) {
                             if($reminder1->status==0 && $reminder1->user_id==$uid)
                             {
                               $leaddetail1 = Lead::all(['id' => $reminder1->leadid]);
                             /*  if(count($leaddetail) > 0){
                                   if($leaddetail[0]->user_id != $uid){
                                       continue;
                                   }
                               }else{
                                 continue;
                               }
*/
                     ?>

                     <li>
                       <a href="<?=BASEURL;?>user/viewLead/<?=$reminder1->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail1[0]->firm_name; ?><span>Added date:<?=date('m-d-y',$reminder1->date);?></span><span>Reminder date:<?=date('m-d-y',$reminder1->reminder_date);?></span></h5>
                             <p><?=$reminder1->msg;?></p>
                       </a>
                       <a href="<?=BASEURL;?>user/followMarkComplete/<?=$reminder1->id?>" class="btn btn-success" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as Complete</a>&nbsp;<a href="<?=BASEURL;?>user/editFollowup/<?=$reminder1->id?>" class="btn btn-info" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a href="<?=BASEURL;?>user/deleteFollowup/<?=$reminder1->id?>" class="btn btn-danger" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>

                     </li>
                     <?php  
                             }
                     } ?>
                 </ul>
					</div>
				 </div>
					
					
             </div>
         </div>
         
         <div class="col-md-12">
<div class="dashnoti">
<table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>Id</th>
                    <th style="text-align: center;">Firm Name</th>
                    
                    <th style="text-align: center;">Lead CRD</th>
                    <th style="text-align: center;">Lead From</th>
                    
                   <th style="text-align: center;">CEO Name</th>
                   <th style="text-align: center;">CEO Email</th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
        $j=0;
                foreach($leads as $list){
                
                ?>
                <tr class="gc_row row<?=$i;?>">
                    <td><?=$list->id;?></td>
                    <td style="text-align:center"><a href="<?=BASEURL;?>user/viewLead/<?=$list->id?>"><?=$list->firm_name;?></a></td>
                    <td style="text-align:center"><?=$list->firm_crd;?></td>
                    <td style="text-align:center">
                     <?php 
$val = Leadstype::all(['id'=>$list->leadfrom]);
echo $val[0]->name;
                     ?>   

                    </td>
                    <td style="text-align:center"><?=$list->ceo_name;?></td>
                    <td style="text-align:center"><?=$list->ceo_email;?></td>
                    
                </tr>
                <?php $i++; $j++;}?>
            </tbody>
        </table>
</div>
         </div>
            <div class="col-md-12">
                <div class="dashnoti display_nn">
                    <ul>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="dashgraph">
                   <div class="row">
                       <div class="col-md-3">
                            <a href="<?=BASEURL;?>user/leads/" class="admbox">
                                <i class="fa fa-linkedin"></i>
                                <h4><?=count($leads=Lead::all(['user_id'=> $uid]));?></h4>
                                <h6>All Leads</h6>
                            </a>
                       </div>
                       <div class="col-md-3">
                            <?php $leadstype =Leadstype::all(['id' =>1])[0]; ?>
                            <a href="<?=BASEURL;?>user/lead/<?=$leadstype->name;?>/" class="admbox">
                                <i class="fa fa-linkedin"></i>
                                <h4><?=count($leads=Lead::all(['leadfrom' =>1,'user_id'=> $uid]));?></h4>
                                <h6><?=ucwords($leadstype->name);?></h6>
                            </a>
                       </div>
                       <div class="col-md-3">
                            <?php $leadstype =Leadstype::all(['id' =>2])[0]; ?>
                            <a href="<?=BASEURL;?>user/lead/<?=$leadstype->name;?>/" class="admbox">
                                <i class="fa fa-envelope"></i>
                                <h4><?=count($leads=Lead::all(['leadfrom' =>2,'user_id'=> $uid]));?></h4>
                                <h6><?=ucwords($leadstype->name);?></h6>
                            </a>
                       </div>
                       <div class="col-md-3">
                            <?php $leadstype =Leadstype::all(['id' =>3])[0]; ?>
                            <a href="<?=BASEURL;?>user/lead/<?=$leadstype->name;?>/" class="admbox">
                                <i class="fa fa-phone"></i>
                                <h4><?=count($leads=Lead::all(['leadfrom' =>3,'user_id'=> $uid]));?></h4>
                                <h6><?=ucwords($leadstype->name);?></h6>
                            </a>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.display_nn {display:none;}
input[type="search"] {width:600px; min-height: 30px; background:#f7f7f7; border:1px solid #999;}
.dataTables_length {display: none;}
</style>
<?php include_once('inc/footer.php'); ?>
