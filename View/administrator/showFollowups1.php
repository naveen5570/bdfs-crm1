<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Followups</h1>
        </div>
        <div class="leadpage">
        <div class="notypnl">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#activetb" aria-controls="activetb" role="tab" data-toggle="tab">Previous</a></li>
                <li role="presentation"><a href="#panding" aria-controls="panding" role="tab" data-toggle="tab">Today</a></li>
                <li role="presentation"><a href="#future" aria-controls="future" role="tab" data-toggle="tab">Future</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="activetb">
                    <table class="table table-striped alldatatbl">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Lead</th>
                                <th>Message</th>
                                <th>Reminder Date</th>
                                <th>Added By</th>
                                <th>Status</th>
                                 </tr>
                        </thead>
                        <tbody>
   <?php foreach ($list_prev as $prev)
   {
	 $qu = "Select * from leads where id=".$prev->leadid; 
	 $query = Lead::find_by_sql($qu);  
	 $user1 ="Select * from subadmins where id=".$prev->user_id; 
   $u1 = Subadmin::find_by_sql($user1);              
   ?>         
                            <tr class="gc_row row<?=$prev->id;?>">
                                <td><?=$prev->id;?></td>
                                
                                <?php if(isset($query[0]->firm_name))
								{
								?>
                                <td><a href="<?=BASEURL?>/administrator/viewLead/<?=$prev->leadid;?>"><?=$query[0]->firm_name;?></a></td>
                                <?php
								}
								else
								{
								?>
                                <td><?=$prev->leadid;?></td>
                                <?php
								}
								?>
                                <td><?=$prev->msg;?></td>
                                <td><?= date('d/m/y', $prev->reminder_date); ?>
                                </td>
                                <?php if(isset($u1[0]->name))
								{
								?>
                                <td><?=$u1[0]->name;?></td>
                                <?php
								}
								else
								{
								?>
                                <td><?php 
								if($prev->user_id==0)
								{
								echo 'admin'; 
								}
								else
								{
								echo $prev->user_id;	
								}
								?></td>
                                
                                <?php
								}
								?>
                                <td><?php if($prev->status==0){ echo "Pending";} else{ echo "Completed";} ?></td>
                            </tr>
     <?php
   }
	 ?>                       
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="panding">
                    <table class="table table-striped alldatatbl">
                        <thead>
                           <tr>
                                <th>S.No</th>
                                <th>Lead</th>
                                <th>Message</th>
                                <th>Reminder Date</th>
                                <th>Added By</th>
                                <th>Status</th>
                                 </tr> 
                        </thead>
                        <tbody>
                            
                           <?php foreach ($list_today as $today)
   {    
   $qu1 = "Select * from leads where id=".$today->leadid; 
   $query1 = Lead::find_by_sql($qu1); 
   $user ="Select * from subadmins where id=".$today->user_id; 
   $u = Subadmin::find_by_sql($user); 
   ?>         
                            <tr class="gc_row row<?=$today->id;?>">
                                <td><?=$today->id;?></td>
                                
                                <?php if(isset($query1[0]->firm_name))
								{
								?>
                                <td><a href="<?=BASEURL?>/administrator/viewLead/<?=$today->leadid;?>"><?=$query1[0]->firm_name;?></a></td>
                                <?php
								}
								else
								{
								?>
                                <td><?=$today->leadid;?></td>
                                <?php
								}
								?>
                                <td><?=$today->msg;?></td>
                                <td><?= date('d/m/y', $today->reminder_date); ?>
                                </td>
                                <?php if(isset($u[0]->name))
								{
								?>
                                <td><?=$u[0]->name;?></td>
                                <?php
								}
								else
								{
								?>
                                <td><?php 
								if($today->user_id==0)
								{
								echo 'admin'; 
								}
								else
								{
								echo $today->user_id;	
								}
								?></td>
                                
                                <?php
								}
								?>
                                <td><?php if($today->status==0){ echo "Pending";} else{ echo "Completed";} ?></td>
                            </tr>
     <?php
   }
	 ?>  
                            
                        </tbody>
                    </table>
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="future">
                    <table class="table table-striped alldatatbl">
                        <thead>
                           <tr>
                                <th>S.No</th>
                                <th>Lead Id</th>
                                <th>Message</th>
                                <th>Reminder Date</th>
                                <th>Added By</th>
                                <th>Status</th>
                                 </tr> 
                        </thead>
                        <tbody>
                            
                           <?php foreach ($list_future as $future)
   {
	   $qu2 = "Select * from leads where id=".$future->leadid; 
	 $query2 = Lead::find_by_sql($qu2);
	 $user2 ="Select * from subadmins where id=".$future->user_id; 
   $u2 = Subadmin::find_by_sql($user2);                 
   ?>         
                            <tr class="gc_row row<?=$future->id;?>">
                                <td><?=$future->id;?></td>
                                <?php if(isset($query2[0]->firm_name))
								{
								?>
                                <td><a href="<?=BASEURL?>/administrator/viewLead/<?=$future->leadid;?>"><?=$query2[0]->firm_name;?></a></td>
                                <?php
								}
								else
								{
								?>
                                <td><?=$future->leadid;?></td>
                                <?php
								}
								?>
                                <td><?=$future->msg;?></td>
                                <td><?= date('d/m/y', $future->reminder_date); ?>
                                </td>
                                <?php if(isset($u2[0]->name))
								{
								?>
                                <td><?=$u2[0]->name;?></td>
                                <?php
								}
								else
								{
								?>
                                <td><?php 
								if($future->user_id==0)
								{
								echo 'admin'; 
								}
								else
								{
								echo $future->user_id;	
								}
								?></td>
                                
                                <?php
								}
								?>
                                <td><?php if($future->status==0){ echo "Pending";} else{ echo "Completed";} ?></td>
                            </tr>
     <?php
   }
	 ?>  
                            
                        </tbody>
                    </table>
                    
                </div>
            </div>

        </div>   
           
           
            
        </div>
    </div>
</div>
<?php include_once('inc/footer.php')?>
