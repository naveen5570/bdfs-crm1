<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
		
        
		<div class="row">
        <div class="col-md-7 col-sm-6">
          <div class="creoption">
              <h1 class="headtit">Logs</h1>
          </div>
        </div>
        <div class="form-group col-md-5 col-sm-6" style="display: none;">
            <label for="" class="col-md-3 col-sm-5 control-label text-right">User</label>
            <div class="col-md-9 col-sm-7">
              <select name="user" class="form-control selecteduser">
                  <option value="">All</option>
                  
              </select>
            </div>

        </div>
       </div>
		<div class="leadpage">
           <div class="row">
             <div class="col-md-2">
               <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default previousdate"><i class="fa fa-caret-left"></i></button>
                <button type="button" class="btn btn-default nextdate"><i class="fa fa-caret-right"></i></button>
              </div>
             </div>
             <div class="col-md-7 creoption">
			 <a href="#" type="button" class="btn"  data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i> </a>
               <h3 class="text-center workdate" data-date="<?=date('Y-m-d');?>"><?=date('d M Y');?></h3>
             </div>
             <div class="col-md-3">
               <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                  <!-- <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1"> -->
                  <input type="text" class="form-control selecteddate datepicker" name="" value="<?=date('m/d/Y');?>" >
                </div>
             </div>
           </div>
	
           <div class="row">
             <div class="col-md-12 notificationcountlist">
               <?php
                   $today = strtotime(date('y-m-d'));
                   $tomorrow = $today+86400;
                    $leadtypes = Leadstype::all();
                     ?>
                      <ul class="list-group">
                    <?php
                        
                        
                          $condition = "date >=  ".$today." and date < ".$tomorrow;

                          $notification = Statuslog::find_by_sql("SELECT count(*) as totalnotification FROM statuslogs where ".$condition);
						  $notif = Statuslog::find_by_sql("SELECT * FROM statuslogs where ".$condition);
                          if($notification[0]->totalnotification > 0){
                        ?>
						  <table class="table table-striped alldatatbl">
						<thead>
						  <tr>
						  <td>Lead ID</td>
						  <td>Lead</td>
						  <td>Previous Status</td>
						  <td>New Status</td>
						  <td>Changed By</td>
						  <td>Date Of Change</td>
						  </tr>
							</thead>
						  <?php
						  foreach ($notif as $not)
			              {
						  ?>
						 <tbody>
							<tr>
						
						 <td>
						<?php echo $not->leadid;?>
                        </td>
							 <td>
						<?php 
							  $name = Lead::all(['id'=>$not->leadid]);
							  echo $name[0]->firm_name;?>
                        </td>
							 <td>
						<?php 
							  $prev = Leadstype::all(['id'=>$not->prev_type]);
							  $prev1 = Leadstatu::all(['id'=>$not->prev_status]);
							  $prev2 = Leadsubstatu::all(['id'=>$not->prev_substatus]);
							  $prev3 = Leadsubsubstatu::all(['id'=>$not->prev_subsubstatus]);
							  if(empty($prev2))
							  {$prev_sub='';}
							  else
							  {$prev_sub=' > '.$prev2[0]->name;}
							  if(empty($prev3))
							  {$prev_subsub='';}
							  else
							  {
							  $prev_subsub= ' > '.$prev3[0]->name;	  
							  }
							  echo $prev[0]->name.' > '.$prev1[0]->name.$prev_sub.$prev_subsub;
								 
						?>
                        </td>
							 <td>
						<?php 
							  $new = Leadstype::all(['id'=>$not->new_type]);
							  $new1 = Leadstatu::all(['id'=>$not->new_status]);
							  $new2 = Leadsubstatu::all(['id'=>$not->new_substatus]);
							  $new3 = Leadsubsubstatu::all(['id'=>$not->new_subsubstatus]);
							  if(empty($new2))
							  {$new_sub='';}
							  else
							  {$new_sub=' > '.$new2[0]->name;}
							  if(empty($new3))
							  {$new_subsub='';}
							  else
							  {
							  $new_subsub= ' > '.$new3[0]->name;	  
							  }
							  echo $new[0]->name.' > '.$new1[0]->name.$new_sub.$new_subsub;
								 
						?>
                        </td>
							 <td>
						<?php 
							  if($not->changed_by!=0)
							  {
								$user = Subadmin::all(['id'=>$not->changed_by]);  
							echo $user[0]->name;	  
							  }
							  else
							  {
							echo "Admin";	  
							  }
							  ?>
                        </td>
							 <td>
						<?php echo date('m-d-Y',$not->date);?>
                        </td>
							 
							</tr></tbody> 
                       <?php  
						  }
					    ?>
						  </table>
						<?php
						  }
						  ?>
                       </ul>
              

             </div>
           </div>
        </div>
         
		<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Status Logs Dates</h4>
      </div>
      <div class="modal-body">
<?php
$servername = "localhost";
$username = "crm_f1";
$password = "jgsrcgmy_crm_f1";
$dbname = "jgsrcgmy_crm_f1";

$conn = new mysqli ($servername , $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection Failed :" . $conn->connect_error);
}

$sql = "SELECT DISTINCT date FROM statuslogs";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
	
	while ($row = $result->fetch_assoc()) {
		
		$start = date($row['date']);
			echo ' <p style="margin-bottom: 0.5em;"> Date: '.
			$row = date('m-d-Y', $start);
			
	}

	
} else {
		echo "No results";
	}
$conn->close();


?>

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
         
    </div>            
</div>

<?php include_once('inc/footer.php')?>