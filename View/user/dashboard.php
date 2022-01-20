<?php include_once('inc/header.php'); ?>
<?php $uid = Session::get('userId'); ?>
<style>

 #loader {
			border: 12px solid #f3f3f3;
			border-radius: 50%;
			border-top: 12px solid #444444;
			width: 70px;
			height: 70px;
			animation: spin 1s linear infinite;
		}</style>

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
                        <li role="presentation"><a href="#assigned" aria-controls="assigned" role="tab"
                                data-toggle="tab">
                                <p class="followup-title">Assigned Followups</p>
                            </a></li>
                            <li role="presentation"><a href="#recurring" aria-controls="recurring" role="tab"
                                data-toggle="tab">
                                <p class="followup-title">Recurring Followups</p>
                            </a></li>

                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="activetb">
                        <ul data-time="<?=time();?>" class="notificationlist">
                                <?php
                            foreach ($reminders2 as $reminder2) {
                                $temp_arr = explode(',',$reminder2->user_id);
                                if($reminder2->status==0)
                            
                                {
                                $leaddetail2 = Lead::all(['id' => $reminder2->leadid]);
                                if (count($leaddetail2) > 0) {
                                if ($leaddetail2[0]->user_id == 0) {
                                    $username = "Admin";
                                } else {
                                    $leaduserid = $leaddetail2[0]->user_id;
                                    $users = Subadmin::all(['id' => $leaduserid]);
                                    $arr = [];
									foreach($temp_arr as $tmp)
									{
                                    if($tmp!=0)
									{
                                    $assigned = Subadmin::all(['id'=>$tmp]);
									array_push($arr,$assigned[0]->name);
									}
									else
									{
									array_push($arr,'Admin');	
									}
									}
									$arr = implode(', ',$arr);
                                    
                                    
                                    
                                    if (count($users) > 0) {
                                        $username = $users[0]->name;
                                    } else {
                                        $username = "";
                                    }
                                }
                            } else {
                                continue;
                            }
                            $today_assign = Subadmin::all(['id'=>$reminder2->assigned_by]);
                    ?>

                               <li>
                                   <?php
							   if($reminder2->priority==0)
							   {
							   ?>
                               <div class="low_nav priority"></div>
                               <?php
							   }
							   else if($reminder2->priority==1)
							   {
								  
							   ?>
                               <div class="medium_nav priority"></div>
                               <?php
							   
							   }
							   else
							   {
							   ?>
                               <div class="high_nav priority"></div>
                               <?php
							   }
							   ?>
                                   <a href="<?=BASEURL;?>user/viewLead/<?=$reminder2->leadid;?>" target="_blank">


                                       <h5>Lead: <?=$leaddetail2[0]->firm_name; ?><span>Assign From :
                                               <?php if($reminder2->assigned_by==0){echo "Admin";} else {echo $today_assign[0]->name;}?></span><span>Added
                                               date:<?=date('m-d-Y',$reminder2->date);?></span><span>Reminder
                                               date:<?=date('m-d-Y',$reminder2->reminder_date);?></span></h5>

                                       <p><?=$reminder2->msg;?></p>
                                       <p>Assign To:
                                           <?php print_r($arr);?>
                                       </p>
                                   </a>
                                   <a href="<?=BASEURL;?>user/followMarkComplete/<?=$reminder2->id?>"
                                       class="btn btn-success"
                                       style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as
                                       Complete</a>&nbsp;<a href="<?=BASEURL;?>user/editFollowup/<?=$reminder2->id?>"
                                       class="btn btn-info"
                                       style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a
                                       href="<?=BASEURL;?>user/deleteFollowup/<?=$reminder2->id?>"
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
                             if($reminder1->status==0 )
                             {
                                 $temp_arr1 = explode(',',$reminder1->user_id);
                               $leaddetail1 = Lead::all(['id' => $reminder1->leadid]);
                             /*  if(count($leaddetail) > 0){
                                   if($leaddetail[0]->user_id != $uid){
                                       continue;
                                   }
                               }else{
                                 continue;
                               }
*/
$pending_assign = Subadmin::all(['id'=>$reminder1->assigned_by]);
$arr1 = [];
									foreach($temp_arr1 as $tmp1)
									{
                                    if($tmp1!=0)
									{
                                    $assigned1 = Subadmin::all(['id'=>$tmp1]);
									array_push($arr1,$assigned1[0]->name);
									}
									else
									{
									array_push($arr1,'Admin');	
									}
									}
									$pending_assign_to = implode(', ',$arr1);
                     ?>

                     <li>
                         
                         <?php
							   if($reminder1->priority==0)
							   {
							   ?>
                               <div class="low_nav priority"></div>
                               <?php
							   }
							   else if($reminder1->priority==1)
							   {
								  
							   ?>
                               <div class="medium_nav priority"></div>
                               <?php
							   
							   }
							   else
							   {
							   ?>
                               <div class="high_nav priority"></div>
                               <?php
							   }
							   ?>
                       <a href="<?=BASEURL;?>user/viewLead/<?=$reminder1->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail1[0]->firm_name; ?><span>Assign From :
                                               <?php if($reminder1->assigned_by==0){echo "Admin";} else {echo $pending_assign[0]->name;}?></span><span>Added date:<?=date('m-d-y',$reminder1->date);?></span><span>Reminder date:<?=date('m-d-y',$reminder1->reminder_date);?></span></h5>
                             <p><?=$reminder1->msg;?></p>
                             <p>Assign To:
                                             <?=$pending_assign_to; ?>
                                         </p>
                       </a>
                       <a href="<?=BASEURL;?>user/followMarkComplete/<?=$reminder1->id?>" class="btn btn-success" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as Complete</a>&nbsp;<a href="<?=BASEURL;?>user/editFollowup/<?=$reminder1->id?>" class="btn btn-info" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a href="<?=BASEURL;?>user/deleteFollowup/<?=$reminder1->id?>" class="btn btn-danger" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>

                     </li>
                     <?php  
                             }
                     } ?>
                 </ul>
                        </div>



<div role="tabpanel" class="tab-pane" id="assigned">
<ul data-time="<?=time();?>" class="notificationlist">
                                <?php
                         foreach ($reminders as $reminder) {
                             $temp_arr2 = explode(',',$reminder->user_id);
                            if($reminder->status==0)
                            {
                                $leaddetail = Lead::all(['id' => $reminder->leadid]);
                                if (count($leaddetail) > 0) {
                                 if ($leaddetail[0]->user_id == 0) {
                                     $username = "Admin";
                                 } else {
                                     $leaduserid = $leaddetail[0]->user_id;
                                     $users = Subadmin::all(['id' => $leaduserid]);
                                     $arr2=[];
                                     foreach($temp_arr2 as $tmp2)
									{
									if($tmp2!=0)
									{
                                    $assigned2 = Subadmin::all(['id'=>$tmp2]);
									array_push($arr2,$assigned2[0]->name);
									}
									else
									{
									array_push($arr2,'Admin');	
									}
									}
									$arr2 = implode(', ',$arr2);
                                     if (count($users) > 0) {
                                         $username = $users[0]->name;
                                     } else {
                                         $username = "";
                                     }
                                 }
                             } else {
                                 continue;
                             }
                             
                             $assign_assign = Subadmin::all(['id'=>$reminder->assigned_by]);
                      ?>
 
                                 <li>
                                     <?php
							   if($reminder->priority==0)
							   {
							   ?>
                               <div class="low_nav priority"></div>
                               <?php
							   }
							   else if($reminder->priority==1)
							   {
								  
							   ?>
                               <div class="medium_nav priority"></div>
                               <?php
							   
							   }
							   else
							   {
							   ?>
                               <div class="high_nav priority"></div>
                               <?php
							   }
							   ?>
                                     <a href="<?=BASEURL;?>user/viewLead/<?=$reminder->leadid;?>" target="_blank">
 
 
                                         <h5>Lead: <?=$leaddetail[0]->firm_name; ?><span>Assign From :
                                               <?php if($reminder->assigned_by==0){echo "Admin";} else {echo $assign_assign[0]->name;}?></span><span>Added
                                                 date:<?=date('m-d-Y',$reminder->date);?></span><span>Reminder
                                                 date:<?=date('m-d-Y',$reminder->reminder_date);?></span></h5>
 
                                         <p><?=$reminder->msg;?></p>
                                         <p>Assign To:
                                             <?=$arr2;?>
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
<div role="tabpanel" class="tab-pane" id="recurring">
<ul data-time="<?=time();?>" class="notificationlist">
                                <?php
                         foreach ($reminders3 as $reminder3) {
                             $temp_arr2 = explode(',',$reminder3->user_id);
                            if($reminder3->status==0)
                            {
                                $leaddetail = Lead::all(['id' => $reminder3->leadid]);
                                if (count($leaddetail) > 0) {
                                 if ($leaddetail[0]->user_id == 0) {
                                     $username = "Admin";
                                 } else {
                                     $leaduserid = $leaddetail[0]->user_id;
                                     $users = Subadmin::all(['id' => $leaduserid]);
                                     $arr2=[];
                                     foreach($temp_arr2 as $tmp2)
									{
									if($tmp2!=0)
									{
                                    $assigned2 = Subadmin::all(['id'=>$tmp2]);
									array_push($arr2,$assigned2[0]->name);
									}
									else
									{
									array_push($arr2,'Admin');	
									}
									}
									$arr2 = implode(', ',$arr2);
                                     if (count($users) > 0) {
                                         $username = $users[0]->name;
                                     } else {
                                         $username = "";
                                     }
                                 }
                             } else {
                                 continue;
                             }
                             
                             $assign_assign = Subadmin::all(['id'=>$reminder3->assigned_by]);
                      ?>
 
                                 <li>
                                     <?php
							   if($reminder3->priority==0)
							   {
							   ?>
                               <div class="low_nav priority"></div>
                               <?php
							   }
							   else if($reminder3->priority==1)
							   {
								  
							   ?>
                               <div class="medium_nav priority"></div>
                               <?php
							   
							   }
							   else
							   {
							   ?>
                               <div class="high_nav priority"></div>
                               <?php
							   }
							   ?>
                                     <a href="<?=BASEURL;?>user/viewLead/<?=$reminder3->leadid;?>" target="_blank">
 
 
                                         <h5>Lead: <?=$leaddetail[0]->firm_name; ?><span>Assign From :
                                               <?php if($reminder3->assigned_by==0){echo "Admin";} else {echo $assign_assign[0]->name;}?></span><span>Added
                                                 date:<?=date('m-d-Y',$reminder3->date);?></span><span>Reminder
                                                 date:<?=date('m-d-Y',$reminder3->reminder_date);?></span></h5>
 
                                         <p><?=$reminder3->msg;?></p>
                                         <p>Assign To:
                                             <?=$arr2;?>
                                         </p>
                                     </a>
                                     <a href="<?=BASEURL;?>user/followMarkComplete/<?=$reminder3->id?>"
                                         class="btn btn-success"
                                         style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as
                                         Complete</a>&nbsp;<a href="<?=BASEURL;?>user/editFollowup/<?=$reminder3->id?>"
                                         class="btn btn-info"
                                         style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a
                                         href="<?=BASEURL;?>user/deleteFollowup/<?=$reminder3->id?>"
                                         class="btn btn-danger"
                                         style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>
 
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
            
                <div class="dashnoti dash_nav"  >
                
                    <table class="table table-striped alldatatbl" >
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
                                <td style="text-align:center"><a
                                        href="<?=BASEURL;?>user/viewLead/<?=$list->id?>"><?=$list->firm_name;?></a></td>
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
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam
                                    at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam
                                    at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam
                                    at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
                            </a>
                        </li>
                        <li>
                            <a href="<?=BASEURL;?>user/view_notification/">
                                <img src="<?=BASEURL;?>assets/user/img/user.png" alt="">
                                <h5>Mark Johnson<span>5m ago</span></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit consequatur magnam
                                    at, commodi laboriosam delectus veniam, culpa repudiandae expedita vitae.</p>
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

input[type="search"] {
    width: 600px;
    min-height: 30px;
    background: #f7f7f7;
    border: 1px solid #999;
}

.dataTables_length {
    display: none;
}


.priority{min-height:85px; width:15px; float:left; margin-right:10px}
.low_nav {background:#0C0}
.medium_nav {background:orange}
.high_nav {background:red}

</style>


<?php include_once('inc/footer.php'); ?>