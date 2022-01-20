<?php include_once('inc/header.php');
$arr=[];
error_reporting(0);
$max_crd = Lead::find_by_sql('SELECT MAX(`firm_crd`) as minimum FROM `leads`');
//echo $max_crd[0]->minimum;	

?>
<div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="creoption">
              <h1 class="headtit">Lead Filter</h1>
          </div>
        </div>
       </div>
       <div class="row">
           <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Filter Leads </h3>
              </div>
              <div class="panel-body">
                <form class="" method="post" action="<?=BASEURL;?>administrator/showFilterLeads">
                    <div class="col-md-1"><label for="inputEmail3" class="control-label">Search Type</label></div>
                <div class="form-group col-md-8" style="margin-bottom:40px;">
                
                <select name="query_type" class="form-control">
                <option value="or" <?php if(isset($query)){if($query=='or'){echo 'selected';}} ?> >OR</option>
                <option value="and" <?php if(isset($query)){if($query=='and'){echo 'selected';}} ?> >AND</option>
                </select>
                </div>
                <div class="col-md-2">
                <label  class="col-sm-12 control-label">Max CRD: <?=$max_crd[0]->minimum; ?></label>
                </div>
                  <div class="form-group col-sm-12">
                    <label for="inputEmail3" class="col-sm-12 control-label">Bussiness Lines</label>
                    
                          
                          <?php
							foreach ($business_lines as $business_line) 
							{
						   ?>
                           <div class="col-sm-6">
                      <div class="">
                        <div class="checkbox">
                           <label>
							<input type="checkbox" name="business_lines[]" 
                            <?php 
							//die(print_r($businesslines));
							if(isset($businesslines)){
                              if (in_array($business_line->id, $businesslines))
                              {
								  array_push($arr, $business_line->name);
                              echo " checked ";
                              }
                            } ?>
                            
                            value="<?= $business_line->id ?>"> <?= $business_line->name; ?>
							
							
                           </label> 
                           </div>
                      </div>
                    </div>
                           <?php
                            }
							?>
                        
                  </div>
                  <?php /* ?>
                  <div class="form-group col-sm-4">
                    <input type="hidden" name="token" value="<?=$key?>">
                    <label for="inputEmail3" class="col-sm-5 control-label">Assign User</label>
                    <div class="col-sm-7">
                      <select name="user" class="form-control">
                          <option value="">All Users</option>
                          <?php
                              foreach($users as $user){
                                  echo "<option value='".$user->id."'";
                                  if(isset($selecteduser)){
                                    if($selecteduser == $user->id){
                                      echo " selected ";
                                    }
                                  }
                                  echo ">".$user->name."</option>";
                              }
                          ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group col-sm-4 leadstsfrm">
                    <label for="inputEmail3" class="col-sm-5 control-label">Lead From</label>
                    <div class="col-sm-7">
                      <select name="leadfrom" class="form-control leadtypeselect">
                          <option value="">-- Select Lead Type --</option>
                          <?php
                              $leadstypes = Leadstype::all(['status'=>1]);
                              foreach($leadstypes as $leadstypes){
                          ?>
                              <option value="<?=$leadstypes->id;?>"
                                <?php if(isset($leadfrom)){
                                  if($leadfrom == $leadstypes->id){
                                    echo " selected ";
                                  }
                                }
                               ?>
                              ><?=ucwords($leadstypes->name);?></option>
                          <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="inputEmail3" class="col-sm-5 control-label">Lead Status</label>
                    <div class="col-sm-7">
                      <select name="lead_status" class="form-control leadstatusbytype">
                          <option value="">-- Choose Status --</option>
                          <?php if(isset($leadfrom)){
                                    $leadstatus = Leadstatu::all(['lead_type_id'=>$leadfrom]);
                                    if(count($leadstatus) > 0){
                                        foreach($leadstatus as $status){
                                    ?>
                                        <option value="<?=$status->id;?>"
                                          <?php if(isset($lead_status)){
                                            if($lead_status == $status->id){
                                              echo " selected ";
                                            }
                                          }
                                         ?>
                                        ><?=ucwords($status->name);?></option>
                                    <?php }
                                    }
                                }
                         ?>
                      </select>
                    </div>
                  </div>
                  <?php */ ?>
				  <div class="form-group col-sm-8">
                    <label for="inputEmail3" class="col-sm-3 control-label">Lead Status</label>
                    <div class="col-sm-9">
                      <select name="lead_status" class="form-control leadstatusbytype">
                          <option value="">-- Choose Status --</option>
                          <?php 
                                    $leadstatus = Leadstatu::all(['lead_type_id'=>1]);
                                    if(count($leadstatus) > 0){
                                        foreach($leadstatus as $status){
                                    ?>
                                        <option value="<?=$status->id;?>"
                                          <?php if(isset($lead_status)){
                                            if($lead_status == $status->id){
                                              echo " selected ";
                                            }
                                          }
                                         ?>
                                        ><?=ucwords($status->name);?></option>
                                    <?php }
                                    }
                                
                         ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-sm-12">
                  <label  class="col-sm-2 control-label">Rom Branch Count</label>
                  <div class="col-sm-4">
                  <?php /* ?>
                  <select name="rom_branch_counts" class="form-control leadstatusbytype">
                  <option value="">-- Select Branch Counts --</option>
                  <option value="< 5" <?php if($rom_branch_count=="< 5"){ echo "selected"; } ?> >Less than 5</option>
                  <option value="BETWEEN 5 AND 10" <?php if($rom_branch_count=="BETWEEN 5 AND 10"){ echo "selected"; } ?>>Between 5 and 10</option>
                  <option value="BETWEEN 10 AND 15" <?php if($rom_branch_count=="BETWEEN 10 AND 15"){ echo "selected"; } ?>>Between 10 and 15</option>
                  <option value="BETWEEN 15 AND 20" <?php if($rom_branch_count=="BETWEEN 15 AND 20"){ echo "selected"; } ?>>Between 15 and 20</option>
                  <option value="BETWEEN 20 AND 25" <?php if($rom_branch_count=="BETWEEN 20 AND 25"){ echo "selected"; } ?>>Between 20 and 25</option>
                  <option value="BETWEEN 25 AND 30" <?php if($rom_branch_count=="BETWEEN 25 AND 30"){ echo "selected"; } ?>>Between 25 and 30</option>
                  <option value="> 30" <?php if($rom_branch_count=="> 30"){ echo "selected"; } ?> >30 and above</option>
                  </select>
				  <?php */ ?>
                  <select name="value_type" class="form-control value_type">
                  <option value="single" <?php if($value_type=='single'){echo "selected";}?> >Single Value</option>
                  <option value="range" <?php if($value_type=='range'){echo "selected";}?> >Range</option>
                  </select>
                  </div>
                  <div class="col-md-2">
                  <input type="text" name="value1" class="form-control" placeholder="value" required="required" value="<?php if(isset($value1)){echo $value1;}?>" />
                  </div>
                  <div class="col-md-2">
                  <input type="text" name="value2" class="form-control value2" placeholder="value" value="<?php if(isset($value2)){echo $value2;}?>"  />
                  </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">Filter</button>
                      <a href="<?=BASEURL;?>administrator/leadFiltaration" class="btn btn-danger">Reset Filter</a>
                    </div>
                  </div>
                </form>
              </div>
           </div>
        </div>
        <div class="tags_main">

<?php
foreach ($arr as $arr1)
{
echo '<div class="tags_nav">'.$arr1.'</div>';	
}
?>


<?php
if(isset($value_type))
{
?>
<div class="col-md-8" style="padding-left:5px;">
<div class="tags_nav" style="background:#09F;">
<?php	
if($value_type=='range')
{
echo 'Selected Branch Counts Range From '.$value1.' to '.$value2; 
}
else
{
echo 'Selected Branch Count is '.$value1;
}
?>
</div>
</div>
<?php
}
?>


<div class="col-md-8" style="padding-left:5px;">
<div class="tags_nav" style="background:#C90;">
<?php 
foreach($leadstatus as $status){
if($lead_status==$status->id)
{
echo 'Selected Lead Type Status is "'. $status->name.'"';	
}
}
?>

</div>
</div>
</div>
        <div class="row">
           <div class="leadpage">
               <div class="counts_nav1" style="text-align:center;"><?php echo $_GET['msg']?></div>
               <div class="counts_nav"></div>
             <div class="col-md-12 col-sm-12">
             <form action="http://bdforsale.com/administrator/sendFilterCampaign" method="post" id="myform" >
 <input type="submit" name="submit" value="Send Campaign" class="fff btn btn-success" /> 
 </form>
                 <table class="table table-striped alldatatbl"  id="example">
                 <thead>
                 <tr>
                 <th>
                <div class="btn-group">
                <button type="button" data-toggle="dropdown" class="btn btn-delete dropdown-toggle"><i class="fa fa-square-o" aria-hidden="true"></i> <span class="caret"></span></button>
                	<ul class="dropdown-menu">
                    <li><a href="javascript:;" class="selectall_leads">Select All</a></li>
                    <li><a href="javascript:;" class="selectnone_leads">None</a></li>
                </ul>
            
            
            
          </div></th>
                           <th>Lead Id</th>
                           <th>Assign To</th>
                           <th>Firm Name</th>
                           <th>CRD</th>
                           <th>CEO name</th>
                           <th>Lead Type</th>
                           <th>Lead Status</th>
                       </tr>
                   </thead>
                   <tbody>
                     <?php
                        if(isset($leads)){
                          foreach($leads as $data){

                            if($data->user_id == 0){
                              $assignto = 'Admin';
                            }else{
                                $assignusers = Subadmin::all(['id'=>$data->user_id]);
                                $assignto = $assignusers[0]->name;
                            }
                           //  $leadtype = Leadstype::find($data->leadfrom)->name;
                           //  $leadtype = $leadtype->name;
                      ?>
                            <tr>
<td class="sorting_1"><input type="checkbox" name="checkedleads[]" class="leads_checkbox" value="<?= $data->ceo_email ?>"></td>
                                <td>#<?=sprintf('%04d',$data->id);?></td>
                                <td><?=$assignto;?></td>
                                <td><a href="<?=BASEURL;?>administrator/viewLead/<?=$data->id;?>" target="_blank"><?=$data->firm_name?></a></td><td><?=$data->firm_crd;?></td>
                                <td><?=$data->ceo_name;?></td>
                                <td><?=Leadstype::find($data->leadfrom)->name;?></td>
                                <td><?=Leadstatu::find($data->lead_status_id)->name;?></td>

                            </tr>
                      <?php
                          }
                        }
                      ?>
                   </tbody>
                 </table>
             </div>
           </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(e) {

$('.fff').click(function(){
	var checkedleads = 0;
	var leadsid = [];
$('.leads_checkbox').each(function(index){
            // $(this).prop('checked','checked');
            if($(this).prop('checked') == true){
              checkedleads = checkedleads+1;
			  leadsid.push($(this).val());
            }
        });
	
$('#myform').submit(function(){
$('<input />').attr('type', 'hidden').attr('name', 'emails[]').attr('value', leadsid).appendTo('#myform');
});
});
var table = $('#example').DataTable(
{
	"dom": 'lBfrtip',
        buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
			title:'leads',
			text:'Export as Excel'
        } ],
	"lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]} );
//var table = $('#example').DataTable({"lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]} );
//var table = $('#example').DataTable();
var cc = table.rows().count();
$('.counts_nav').text(cc+' records Found');

$('.value_type').change(function(){
//alert($(this).val());
if($(this).val()=='range')
{
$('.value2').show();
$('.value2').attr('required','required');	
}
else
{
$('.value2').hide();	
}	
});
});

</script>
<?php if(isset($value2))
{
?>
<script>
$(document).ready(function(){
$('.value2').show();

});
</script>

<?php
}
?>
<style>
.counts_nav {text-align:center; color:green; font-size:16px;}
.value2 {display:none;}

</style>
<?php include_once('inc/footer.php')?>
