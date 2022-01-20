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
                                <th>Added Date</th>
                                <th>Actions</th>
                                 </tr>
                        </thead>
                        <tbody>
   <?php foreach ($list_prev as $prev)
   {
	 $qu = "Select * from leads where id=".$prev->leadid; 
	 $query = Lead::find_by_sql($qu);
	 
   ?>         
                            <tr class="gc_row row<?=$prev->id;?>">
                                <td><?=$prev->id;?></td>
                                
                                <td><a href="<?=BASEURL?>/user/viewLead/<?=$prev->leadid;?>"><?=$query[0]->firm_name;?></a></td>
                                <td><?=$prev->msg;?></td>
                                <td><?= date('d/m/y', $prev->reminder_date); ?></td>
                                <td><?= date('d/m/y', $prev->date); ?>
                                </td>
                                <td><a class="btn btn-info" href="<?=BASEURL?>user/editFollowup/<?=$prev->id;?>"><i class="fa fa-pencil"></i></a><a class="btn btn-danger" href="<?=BASEURL?>user/deleteFollowup/<?=$prev->id;?>"><i class="fa fa-trash"></i></a></td>
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
                                <th>Added Date</th>
                                <th>Actions</th>
                                 </tr> 
                        </thead>
                        <tbody>
                            
                           <?php foreach ($list_today as $today)
   {    
   $qu1 = "Select * from leads where id=".$today->leadid; 
   $query1 = Lead::find_by_sql($qu1);            
   ?>         
                            <tr class="gc_row row<?=$today->id;?>">
                                <td><?=$today->id;?></td>
                                
                                <td><a href="<?=BASEURL?>/user/viewLead/<?=$today->leadid;?>"><?=$query1[0]->firm_name;?></a></td>
                                <td><?=$today->msg;?></td>
                                <td><?= date('d/m/y', $today->reminder_date); ?>
                                </td>
                                <td><?= date('d/m/y', $today->date); ?>
                                </td>
                                <td><a class="btn btn-info" href="<?=BASEURL?>user/editFollowup/<?=$today->id;?>"><i class="fa fa-pencil"></i></a><a class="btn btn-danger" href="<?=BASEURL?>user/deleteFollowup/<?=$today->id;?>"><i class="fa fa-trash"></i></a></td>
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
                                <th>Added Date</th>
                                <th>Actions</th>
                                 </tr> 
                        </thead>
                        <tbody>
                            
                           <?php foreach ($list_future as $future)
   {
	   $qu2 = "Select * from leads where id=".$future->leadid; 
	 $query2 = Lead::find_by_sql($qu2);                 
   ?>         
                            <tr class="gc_row row<?=$future->id;?>">
                                <td><?=$future->id;?></td>
                                <td><a href="<?=BASEURL?>/user/viewLead/<?=$future->leadid;?>"><?=$query2[0]->firm_name;?></a></td>
                                <td><?=$future->msg;?></td>
                                <td><?= date('d/m/y', $future->reminder_date); ?>
                                </td>
                                <td><?= date('d/m/y', $future->date); ?>
                                </td>
                                <td><a class="btn btn-info" href="<?=BASEURL?>user/editFollowup/<?=$future->id;?>"><i class="fa fa-pencil"></i></a><a class="btn btn-danger" href="<?=BASEURL?>user/deleteFollowup/<?=$future->id;?>"><i class="fa fa-trash"></i></a></td>
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
