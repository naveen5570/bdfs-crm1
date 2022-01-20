<?php include_once('inc/header.php'); 
$leadst = Leadstype::all(['id'=>$lead_type]);
?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="profile breadcrumbs creoption" style="padding:5px 10px; font-size:12px">
			<a href="<?=BASEURL?>administrator">Home</a> >> <a href="<?=BASEURL?>administrator/leads">All Leads</a> >> <?=$leadst[0]->name;?>
			<a href="#" type="button" class="btn"  data-toggle="modal" data-target="#myModal"><i class="fa fa-info"></i> </a>
			
            </div>


            <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms Used In This Page</h4>
      </div>
      <div class="modal-body">
      <?php

$labels = '';
$labcolor = '';
$leadcount = array();
$leadstatus = Leadstatu::all(['lead_type_id'=>$lead_type]);
$statuscolor = array();
$i=0;
foreach( $leadstatus as $leadst){
    $labels .= ' "'.$leadst->name.'",';
    $color = rendomColor()[$i];
    $labcolor .= ' "'.$color.'",';
    $leadcounts = Lead::find_by_sql("select COUNT(*) as leadcount from leads where leadfrom = $lead_type and lead_status_id = ".$leadst->id." AND status=1");
    array_push($leadcount, $leadcounts[0]->leadcount);
    list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");

    $statuscolor[$leadst->id] = "rgba(".$r.", ".$g.", ".$b.", 0.5)";
    $labelbtnbgcolor[]= $color;
$i++;}
foreach ($leadstatus as $key => $value) {

    echo '<p style="margin-bottom: 1.5em;"><a href="#'.$lead_typename.'/'.str_replace(" ","_",$value->name).'" class="label" style="font-size: 97%;border-bottom:2px solid black;background-color: '.$labelbtnbgcolor[$key].'"><h4>'.$value->name.' : </h4>'.$value->description.' </a></p>';
}
$labels = rtrim($labels,",");
$labcolor = rtrim($labcolor,",");
?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php

//echo $lead_type.'<br>test=>'.$leadcurrentstatus.'<br>type=>'.$lead_typename;
 

?>
        <div class="profile" style="border-bottom:none;">
            <div class="row">
                <div class="col-md-6">
                    <canvas id="pie-chart" width="800" height="450"></canvas>
                </div>
                <div class="col-md-6">
                    <?php

                        $labels = '';
                        $labcolor = '';
                        $leadcount = array();
                        $leadstatus = Leadstatu::all(['lead_type_id'=>$lead_type]);
                        $statuscolor = array();
						$i=0;
                        foreach( $leadstatus as $leadst){
							
                            $labels .= ' "'.$leadst->name.'",';
                            $color = rendomColor()[$i];
                            $labcolor .= ' "'.$color.'",';
                            $leadcounts = Lead::find_by_sql("select COUNT(*) as leadcount from leads where leadfrom = $lead_type and lead_status_id = ".$leadst->id." AND status=1");
							//echo "select COUNT(*) as leadcount from leads where leadfrom = $lead_type and lead_status_id = ".$leadst->id." AND status=1<br>";
                            array_push($leadcount, $leadcounts[0]->leadcount);
                            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");

                            $statuscolor[$leadst->id] = "rgba(".$r.", ".$g.", ".$b.", 0.5)";
                            $labelbtnbgcolor[]= $color;
                        $i++;}
                        foreach ($leadstatus as $key => $value) {

                            echo '<p style="margin-bottom: 0.8em;"><a href="'.BASEURL.'administrator/leadstatus/'.$lead_typename.'/'.str_replace(" ","_",$value->name).'" class="label" style="font-size: 97%;background-color: '.$labelbtnbgcolor[$key].'">'.$value->name.' : '.$leadcount[$key].' leads </a></p>';
                        }
                        $labels = rtrim($labels,",");
                        $labcolor = rtrim($labcolor,",");
?>
                </div>
            </div>
        </div>
        <div class="leadscroll">
          <div class="actionbtnsdiv">
            <div class="btn-group">
                <button type="button" data-toggle="dropdown" class="btn btn-delete dropdown-toggle"><i class="fa fa-square-o" aria-hidden="true"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:;" class="selectall_leads">Select All</a></li>
                    <li><a href="javascript:;" class="selectnone_leads">None</a></li>
                </ul>
            </div>
            <div class="btn-group actionbtns">
                <!-- <button type="button"  class="btn btn-primary"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button> -->
                <button type="button"  class="btn btn-primary assign_checked_leadsbtn" data-toggle="modal" data-target="#multipalassign"> Assign</button>
            </div>
          </div>
          <?php
               $i = 1;
               $leadcurrentstatusid = 0;
               if($leadcurrentstatus){

                 $leadstatus = Leadstatu::all(['lead_type_id'=>$lead_type,'name'=>$leadcurrentstatus]);
                 $leadcurrentstatusid = count($leadstatus) ? $leadstatus[0]->id : 0;
               }
           ?>
		  <table class="table  leads_by_type_datatable">
 
            <thead>
                <tr>
                    <th></th>
                    <th>Lead Id</th>
                    <th>Assign To</th>
                    <th>Firm Name</th>
<th>Firm CRD</th>
                    <!--<th>New CEO Name</th>-->
                    <th>CEO name</th>
                    <th>CEO email</th>
                    <th>Lead Status</th>
					
                    <th>CEO number</th>
                    <th>CEO linkedin</th>
                    <!--<th>CEO letter_type</th> -->
                    <th>CEO crd</th>
                    <th>CEO Finop Name</th>
                    <th>CEO Finop Card</th>
                    <th>CCO Name</th>
                    <th>New CCO Name</th>
                    <th>CCO Email</th>
                    <th>CCO Number</th>
                    <th>CCO Linkedin</th>
                    
                    
                    <th>Address_1</th>
                    <th>Address_2</th>
                    
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
                    <th>Phone</th>
                    <th>Lead From</th>
					
                    <th>Verification status</th>
                    <th>Website</th>



                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
		</div>

    </div>
</div>

<?php include_once('inc/footer.php'); ?>
<script src="<?=BASEURL;?>assets/lib/js/Chart.bundle.min.js">
</script>
<div class="modal fade addnotesnote" id="multipalassign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Assign Leads</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-3">Assign Leads To </div>
                    <div class="col-md-6">
        					    <select multiple="multiple" class="form-control assignleadsuser js-example-basic-multiple" data-id="<?=$data->id;?>">
            					    <option value="0" >Admin</option>
                                        <?php
                                            $users = Subadmin::all(['status'=>1]);
            								foreach ($users as $users){
                                        ?>
            							<option value="<?=$users->id;?>"> <?=$users->name;?></option>
      				            <?php }?>
      				        </select>
                    </div>
                    <div class="col-md-3"><button type="button" class="btn btn-primary assign_btn">Assign</button></div>
                </div>
              </div>
        </div>
    </div>
</div>
<div class="modal fade " id="followup_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Followup</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>administrator/followup" id="followup_frm" class="" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?=$key;?>" name="token">
                        <input type="hidden" value="" name="id" id="followup_leadid">
                        <label for="email">Message</label>
                        <textarea class="form-control" name="msg" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Date</label>
                        <?php $datetime = new DateTime('today');
                          $datetime->format('Y-m-d H:i:s'); ?>
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
<style>
.modal-body p {
    word-wrap: break-word !important;
  
  white-space: nowrap;
  box-decoration-break: clone;
  -webkit-box-decoration-break: clone;
}

 a.btn {
 float: right;
 background-color: aliceblue;
}


.label {
white-space:pre-wrap;
word-wrap: break-word !important;
padding: 0.2em 0.1em .5em !important;
}
.actionbtnsdiv {left:10% !important;}
/* p{
  overflow:auto;
} */
.select2-container {width:200px !important}
</style>

<script>
var statuscolor = <?=json_encode($statuscolor);?>;
// var table = $('.filterdatatable').DataTable();


$('.leads_by_type_datatable').DataTable({
	"dom": 'lBfrtip',
    lengthMenu: [[10, 25, 50, 100, 500, 1000, 2000, 3000, 10000], [10, 25, 50, 100, 500, 1000, 2000, 3000, 'All']],
        buttons : [ {
            extend : 'excel',
            text : 'Export to Excel',
            title : 'Leads',
            exportOptions : {
columns: [1,3,4,5,6,7,8,9,22,23,24,25,26,27,28,29,30],
                modifier : {
                    
                    page : 5000,      // 'all',     'current'
                    search : 'applied',
                    order: 'applied'     // 'none',    'applied', 'removed'
                },
                format: {
                            header: function ( data, columnIdx ) {
								if(columnIdx==1){
                                return 'Lead Id';
                                }
                                if(columnIdx==3){
                                return 'Company Name';
                                }
                                else if(columnIdx==4){
                                return 'Company CRD';
                                }
								else if(columnIdx==7){
								return 'Lead Status';	
								}
								else if(columnIdx==8){
								return 'Lead Substatus';	
								}
								else if(columnIdx==9){
								return 'Lead Subsubstatus';	
								}
                                else if(columnIdx==5){
                                return 'Name';
                                }
                                else if(columnIdx==6){
                                return 'Email';
                                }
                                else if(columnIdx==22){
                                return 'Address 1';
                                }
                                else if(columnIdx==23){
                                return 'Address 2';
                                }
                                else if(columnIdx==24){
                                return 'City';
                                }
                                else if(columnIdx==25){
                                return 'State';
                                }
                                else if(columnIdx==26){
                                return 'Zipcode';
                                }
                                else if(columnIdx==27){
                                return 'Phone';
                                }
                                else if(columnIdx==28){
                                return 'Lead From';
                                }
                                else if(columnIdx==29){
                                return 'Website';
                                }
								else if(columnIdx==30){
                                return 'Verification Status';
                                }
                            }
                        }
            }
        } ],
		
    "processing": true,
    "serverSide": true,
    "pageLength" : 10,
    "ajax": {
        url : "<?=BASEURL;?>administrator/loadTypeWiseLeads/<?=$lead_type;?>/<?=$leadcurrentstatusid;?>",
        type : 'POST'

    },
    "rowCallback": function( row, data, index ) {

        $(row).append("<td><button class='btn btn-default followupbtn' data-id='"+data[30]+"'>Followup</button></td>")
        $('td', row).css('background-color', statuscolor[data[29]]);

    }
});

$('.leads_by_type_datatable thead tr th:last-child').after("<th></th>");

var ctx = document.getElementById('pie-chart');
var mychart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: [<?=$labels;?>],
      datasets: [{
        label: "Leads Status",
        backgroundColor: [<?=$labcolor;?>],
        data: [<?=implode(",", $leadcount);?>]
      }]
    },
    options: {
        title: {
            display: true,
            text: 'Leads Status'
        },
        legend: false
    }
});

ctx.onclick = function(evt) {
      var activePoints = mychart.getElementsAtEvent(evt);
      if (activePoints[0]) {
        var chartData = activePoints[0]['_chart'].config.data;
        var idx = activePoints[0]['_index'];

        var label = chartData.labels[idx];
        var value = chartData.datasets[0].data[idx];

        var reurl = "<?=BASEURL;?>administrator/leadstatus/<?=$lead_typename;?>/"+label.split(' ').join('_');
        window.location.href= reurl;
        // table.columns( 28 ).search(label).draw();
      }
    };
$('.js-example-basic-multiple').select2();
</script>
