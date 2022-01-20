<?php include_once('inc/header.php'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
       <div class="row">
         <div class="col-md-12">
             <div class="dashnoti">
				 <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#activetb" aria-controls="activetb" role="tab" data-toggle="tab"><p class="followup-title">Today's Followups</p></a></li>
                <li role="presentation"><a href="#panding" aria-controls="panding" role="tab" data-toggle="tab"><p class="followup-title">Pending Followups</p></a></li>
                <li role="presentation"><a href="#assigned" aria-controls="assigned" role="tab" data-toggle="tab"><p class="followup-title">Assigned Followups</p></a></li>
                <li role="presentation"><a href="#recurring" aria-controls="recurring" role="tab"
                                data-toggle="tab">
                                <p class="followup-title">Recurring Followups</p>
                            </a></li>
                
            </ul>
                 <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="activetb">
                 <ul data-time = "<?=time();?>" class="notificationlist">
                     <?php
                         foreach ($reminders as $reminder) {
                             $temp_arr = explode(',',$reminder->user_id);
							 if($reminder->status==0)
							 {
                               $username = "Admin";
                               $leaddetail = Lead::all(['id' => $reminder->leadid]);
                               if(count($leaddetail) > 0){
                                   if($leaddetail[0]->user_id == 0){
                                       $username = "Admin";
                                   }else{
                                       $leaduserid = $leaddetail[0]->user_id;
                                       $users = Subadmin::all(['id'=>$leaduserid]);
									   $uu = Subadmin::all(['id'=>$reminder->user_id]);
                                       if(count($users)>0){
                                           $username = $users[0]->name;
                                       }else{
                                           $username = "";
                                       }
                                   }
                               }else{
                                 continue;
                               }
							   
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
							   if($reminder->assigned_by==0)
								  {
									$assign1 = 'Admin';  
								  }
								  else
								  {
								  $assign1 = Subadmin::all(['id'=>$reminder->assigned_by]);
								  }

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
                       <a href="<?=BASEURL;?>administrator/viewLead/<?=$reminder->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail[0]->firm_name; ?><span>Assigned From : <?php if($reminder->assigned_by==0){echo "Admin";} else {echo $assign1[0]->name;}?></span><span>Added date:<?=date('m-d-y',$reminder->date);?></span><span>Reminder date:<?=date('m-d-y',$reminder->reminder_date);?></span></h5>
                             <p><?=$reminder->msg;?></p>
                             <p>Assigned To: <?php print_r($arr);?></p>
                             
                       </a>
                       <a href="<?=BASEURL;?>administrator/followMarkComplete/<?=$reminder->id?>" class="btn btn-success" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as Complete</a>
                       <a href="<?=BASEURL;?>administrator/editFollowup/<?=$reminder->id?>" class="btn btn-info" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a href="<?=BASEURL;?>administrator/deleteFollowup/<?=$reminder->id?>" class="btn btn-danger" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>
                     </li>
                     <?php  
					 }
						 }
					  ?>
                 </ul>
					 </div>
				 
				 
			<div role="tabpanel" class="tab-pane" id="panding">
                 <ul data-time = "<?=time();?>" class="notificationlist">
                     
                     
                     <?php
                     
                     
                     
                     
                         foreach ($reminders1 as $reminder1) {
                             $temp_arr1 = explode(',',$reminder1->user_id);
							 if($reminder1->status==0)
							 {
                               $username1 = "Admin";
                               $leaddetail1 = Lead::all(['id' => $reminder1->leadid]);
                               if(count($leaddetail1) > 0){
                                   if($leaddetail1[0]->user_id == 0){
                                       $username1 = "Admin";
                                   }else{
                                       $leaduserid1 = $leaddetail1[0]->user_id;
                                       $users1 = Subadmin::all(['id'=>$leaduserid1]);
									   $uu1 = Subadmin::all(['id'=>$reminder1->user_id]);
                                       if(count($users1)>0){
                                           $username1 = $users1[0]->name;
                                       }else{
                                           $username1 = "";
                                       }
									   $assign_pending = Subadmin::all(['id'=>$reminder1->assigned_by]);
                                       if(count($assign_pending)>0){
                                           $username_pending = $assign_pending[0]->name;
                                       }else{
                                           $username_pending = "";
                                       }
                                   }
                               }else{
                                 continue;
                               }
							   
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
                       <a href="<?=BASEURL;?>administrator/viewLead/<?=$reminder1->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail1[0]->firm_name; ?><span>Assigned From : <?php if($reminder1->assigned_by==0){echo "Admin";} else {echo $username_pending;}?></span><span>Added date:<?=date('m-d-y',$reminder1->date);?></span><span>Reminder date:<?=date('m-d-y',$reminder1->reminder_date);?></span></h5>
                             <p><?=$reminder1->msg;?></p>
                             <p>Assigned to: <?=$pending_assign_to; ?></p>
                             
                       </a>
                       <a href="<?=BASEURL;?>administrator/followMarkComplete/<?=$reminder1->id?>" class="btn btn-success" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as Complete</a>
                       <a href="<?=BASEURL;?>administrator/editFollowup/<?=$reminder1->id?>" class="btn btn-info" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a href="<?=BASEURL;?>administrator/deleteFollowup/<?=$reminder1->id?>" class="btn btn-danger" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>
                     </li>
                     <?php  
					 }
						 }
					  ?>
                 </ul>
					 </div>		 
					 
					 
				 
				 <div role="tabpanel" class="tab-pane" id="assigned">
                 <ul data-time = "<?=time();?>" class="notificationlist">
                     
                     
                     <?php
                     
                     
                     
                     
                         foreach ($reminders2 as $reminder2) {
                             $temp_arr2 = explode(',',$reminder2->user_id);
							 if($reminder2->status==0)
							 {
                               $username2 = "Admin";
                               $leaddetail2 = Lead::all(['id' => $reminder2->leadid]);
                               if(count($leaddetail2) > 0){
                                   if($leaddetail2[0]->user_id == 0){
                                       $username2 = "Admin";
                                   }else{
                                       $leaduserid2 = $leaddetail2[0]->user_id;
                                       $users2 = Subadmin::all(['id'=>$leaduserid2]);
									   $uu2 = Subadmin::all(['id'=>$reminder2->user_id]);
                                       if(count($users2)>0){
                                           $username2 = $users2[0]->name;
                                       }else{
                                           $username2 = "";
                                       }
                                   }
								   
								  if($reminder2->assigned_by==0)
								  {
									$assign = 'Admin';  
								  }
								  else
								  {
								  $assign = Subadmin::all(['id'=>$reminder2->assigned_by]);
								  }
								   
								   
								   
                               }else{
                                 continue;
                               }
                               
                               
                               $arr2 = [];
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
                       <a href="<?=BASEURL;?>administrator/viewLead/<?=$reminder2->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail2[0]->firm_name; ?><span>Assigned From : <?php print_r($assign);?></span><span>Added date:<?=date('m-d-y',$reminder2->date);?></span><span>Reminder date:<?=date('m-d-y',$reminder2->reminder_date);?></span></h5>
                             <p><?=$reminder2->msg;?></p>
                             <p>Assigned to: <?=$arr2;?></p>
                             
                       </a>
                       <a href="<?=BASEURL;?>administrator/followMarkComplete/<?=$reminder2->id?>" class="btn btn-success" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as Complete</a>
                       <a href="<?=BASEURL;?>administrator/editFollowup/<?=$reminder2->id?>" class="btn btn-info" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a href="<?=BASEURL;?>administrator/deleteFollowup/<?=$reminder2->id?>" class="btn btn-danger" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>
                     </li>
                     <?php  
					 }
						 }
					  ?>
                 </ul>
					 </div>
				 <div role="tabpanel" class="tab-pane" id="recurring">
                 <ul data-time = "<?=time();?>" class="notificationlist">
                     
                     
                     <?php
                     
                     
                     
                     
                         foreach ($reminders3 as $reminder3) {
                             $temp_arr3 = explode(',',$reminder3->user_id);
							 if($reminder3->status==0)
							 {
                               $username3 = "Admin";
                               $leaddetail3 = Lead::all(['id' => $reminder3->leadid]);
                               if(count($leaddetail3) > 0){
                                   if($leaddetail3[0]->user_id == 0){
                                       $username3 = "Admin";
                                   }else{
                                       $leaduserid3 = $leaddetail3[0]->user_id;
                                       $users3 = Subadmin::all(['id'=>$leaduserid3]);
									   $uu3 = Subadmin::all(['id'=>$reminder3->user_id]);
                                       if(count($users3)>0){
                                           $username3 = $users3[0]->name;
                                       }else{
                                           $username3 = "";
                                       }
                                   }
								   
								  if($reminder3->assigned_by==0)
								  {
									$assign = 'Admin';  
								  }
								  else
								  {
								  $assign = Subadmin::all(['id'=>$reminder3->assigned_by]);
								  }
								   
								   
								   
                               }else{
                                 continue;
                               }
                               
                               
                               $arr3 = [];
									foreach($temp_arr3 as $tmp3)
									{
									if($tmp3!=0)
									{
                                    $assigned3 = Subadmin::all(['id'=>$tmp3]);
									array_push($arr3,$assigned3[0]->name);
									}
									else
									{
									array_push($arr3,'Admin');	
									}
									}
									$arr3 = implode(', ',$arr3);

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
                       <a href="<?=BASEURL;?>administrator/viewLead/<?=$reminder3->leadid;?>" target="_blank">


                             <h5>Lead: <?=$leaddetail3[0]->firm_name; ?><span>Assigned From : <?php print_r($assign);?></span><span>Added date:<?=date('m-d-y',$reminder3->date);?></span><span>Reminder date:<?=date('m-d-y',$reminder3->reminder_date);?></span></h5>
                             <p><?=$reminder3->msg;?></p>
                             <p>Assigned to: <?=$arr3;?></p>
                             
                       </a>
                       <a href="<?=BASEURL;?>administrator/followMarkComplete/<?=$reminder3->id?>" class="btn btn-success" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">Mark as Complete</a>
                       <a href="<?=BASEURL;?>administrator/editFollowup/<?=$reminder3->id?>" class="btn btn-info" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">edit</a>&nbsp;<a href="<?=BASEURL;?>administrator/deleteFollowup/<?=$reminder2->id?>" class="btn btn-danger" style="color:#fff; padding:2px 6px; font-size:12px; margin-top:8px">delete</a>
                     </li>
                     <?php  
					 }
						 }
					  ?>
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
                    
                    
                   <th style="text-align: center;">CEO Name</th>
                   <th style="text-align: center;">CEO Email</th>
                </tr>
            </thead>
            <tfoot>
            
        </tfoot>
        </table>
</div>
         </div>
         <?php
         /*
         ?>
         <div class="col-md-12">
         <div class="dashnoti">
         <form id="leadType1" action="" method="post">
         <select name="leadType" id="leadType">
         <?php $type = Leadstype::all(); 
		 foreach($type as $type)
		 {
			 
		 ?>
            <option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
            <?php 
			}
		 ?>
         </select>
         </form>
         
         <div id="statusContainer">
         <?php  $status = Leadstatu::all(['lead_type_id'=>1]);
		 $i=1;
		 foreach ($status as $status)
		 {
			 $details = Lead::all(['lead_status_id'=>$status->id]);
			 $cc = count($details);
		echo '<li data-item="'.$i.'" id="tt'.$i.'"><a href="'.BASEURL.'administrator/dashboard/'.str_replace(" ", "_", $status->name).'/1">'.$status->name." (".$cc.") </a></li>";	 
		$i++;
		 }
		  ?>
          
          </div>
         </div>
         </div>
         <?php
         */
         ?>
            <div class="col-md-12">
                <div class="dashnoti display_nn">
                    <ul data-time = "<?=time();?>" class="notificationlist">
                        <?php
                            foreach ($notifications as $notification) {
                                if($notification->createdby == 0){
                                    $username = "Admin";
                                    $userimg = "";
                                }else{
                                    $users = Subadmin::all(['id'=>$notification->createdby]);
                                    if(count($users)>0){
                                        $username = $users[0]->name;
                                        $userimg = $users[0]->photo;
                                    }else{
                                        $username = "";
                                        $userimg = "";
                                    }
                                }
                        ?>

                        <li>
                            <a href="<?=BASEURL;?>administrator/view_notification/">
                                <?php if($userimg == ""){ ?>
                                    <img src="<?=BASEURL;?>assets/administrator/img/user.png" alt="">
                                <?php }else{ ?>
                                    <img src="<?=BASEURL;?>uploads/images/<?=$userimg;?>" alt="">
                                <?php } ?>

                                <h5><?=$username;?><span><?=timerFormat($notification->date,time())." ago"?></span></h5>
                                <p><?=$notification->msg;?>
                                    <?php if($notification->leadid !=0 ){
                                        $leadofnoti = Lead::all(['id' => $notification->leadid]);
                                        if(count($leadofnoti) > 0){

                                        }
                                    }?>
                                </p>
                            </a>
                        </li>
                        <?php  } ?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="dashgraph">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Linkedin</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        	$users = Subadmin::all(['status'=>1]);
                     		$i = 1;
                        	foreach($users as $us){
                        ?>

                            <tr>
                                <td><?=$i;?></td>
                                <td><a href="<?=BASEURL;?>administrator/profile/<?=$us->id;?>" target="_blank"><?=$us->name;?></a></td>
                                <td><?=$us->email;?></td>
                                <td><?=count($leads = Lead::all(['user_id'=>$us->id,'leadfrom' =>1]));?></td>
                                <td><?=count($leads = Lead::all(['user_id'=>$us->id,'leadfrom' =>2]));?></td>
                                <td><?=count($leads = Lead::all(['user_id'=>$us->id,'leadfrom' =>3]));?></td>
                                <td><?=count($leads = Lead::all(['user_id'=>$us->id]));?></td>
                            </tr>
                        <?php
                        	$i++; }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!--<div class="dashgraph">
                    <canvas id="pie-chart" width="800" height="450"></canvas>
                </div>-->
            </div>
            
        </div>
    </div>
</div>
<?php include_once('inc/footer.php'); ?>
<script src="<?=BASEURL;?>assets/lib/js/Chart.min.js">
</script>
<script>
 new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ["New leads", "Never Contacted", "Initial Contact", "No Response","Follow up","Proposal"],
      datasets: [{
        label: "Leads Status",
        backgroundColor: ["#3e95cd", "#ffcd56","#3cba9f","#ff6384","#5cb85c","#f44336"],
        data: [6,8,4,3,12,1]
      }]
    }
});
</script>
<script type="text/javascript">
  $(function(){
    setInterval( function() {
        var time = $('ul.notificationlist').data('time');
        var url = "<?=BASEURL;?>administrator/getAdminNewNotifications";

          $.post(url,{'time': time},function(o){

            if(o.result === 'success'){
                if(o.totalnewnotifications > 0){
                  $('ul.notificationlist').data('time',o.time);
                  $('ul.notificationlist').prepend(o.html);
                }
            }
         },"json");

    }, 1000);
  });
</script>

<script>
$(document).ready(function(e) {
var colors = ["#d82c35", "#22ac32", "#1b6197", "#588341", "#b77c30", "#2d26c5", "#878b12", "#232a20", "#467fff", "#de45d5"];

var i = 2;
var ww=500;
for(i;i<=5;i++)
{
	var random11 = colors[Math.floor(Math.random()*colors.length)];
ww = ww-80;
$('#tt'+i).css('width', ww);
$('#tt'+i).css('background', random11);	
colors.splice(colors.indexOf(random11), 1 );	
}  
});
</script>

<style>
#statusContainer{float:right; text-align:center; max-width:500px; width:100%; z-index:2; position:relative;}
#statusContainer li:nth-child(1){background:#F00; width:100%; }
#statusContainer li {list-style:none; color:#fff; margin:0 auto; margin-top:0px; padding:10px 0; clip-path: 
    polygon(
      0% 0%,     /* top left */
      5% 0%,     /* top left */
      80% 5%,    /* top right */
      100% 2%,   /* top right */
      100% 15%,  /* bottom right */
      95% 100%,  /* bottom right */
      8% 100%,   /* bottom left */
      0% 5%      /* bottom left */
    );}

#statusContainer li a {color:#fff; text-decoration:none;}


.dashnoti {position:relative}
.display_nn {display:none;}
input[type="search"] {width:600px; min-height: 30px; background:#f7f7f7; border:1px solid #999;}
.dataTables_length {display: none;}
.priority{min-height:85px; width:15px; float:left; margin-right:10px}
.low_nav {background:#0C0}
.medium_nav {background:orange}
.high_nav {background:red}
table.dataTable thead .sorting {text-align:left !important}
</style>
