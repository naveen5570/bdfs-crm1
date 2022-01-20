<?php include_once('inc/header.php');
      $uid = Session::get('userId');
?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="profile breadcrumbs" style="padding:5px 10px; font-size:12px">
				<a href="<?=BASEURL?>user">Home</a> >> All Leads
			</div>
      <div class="profile" style="border-bottom:none;">
          <div class="row">
              <div class="col-md-6">
                  <canvas id="pie-chart" width="800" height="450"></canvas>
              </div>
              <div class="col-md-6">
                  <?php


                      $leadcount = array();
                      $statuscolor = array();
                      $labels = ' "Broker-dealers", "BD-Purchasers","Shell-BD-Sellers", "Producing-BD-Sellers", "CXG-Non-BD-Buyers" ';
                      $color = ["#0084bf", "#e42f2f", "#0A8F2C", "#e22acc", "#f49a00", "#d89aff"];
                    $labcolor = ' "#0084bf","#e42f2f","#0A8F2C","#e22acc","#f49a00","#d89aff"';
                      $leadstypes =Leadstype::all();
                      foreach ($leadstypes as $key => $ltype) {

                        $leadcounts = Lead::find_by_sql("select COUNT(*) as leadcount from leads where leadfrom = ".$ltype->id." and status=1 and FIND_IN_SET(".$uid.", user_id)");
                        array_push($leadcount, $leadcounts[0]->leadcount);
                        list($r, $g, $b) = sscanf($color[$key], "#%02x%02x%02x");
                        $statuscolor[$ltype->id] = "rgba(".$r.", ".$g.", ".$b.", 0.5)";

                        echo '<p style="margin-bottom: 0.5em;"><a href="'.BASEURL.'user/lead/'.$ltype->name.'" class="label" style="font-size: 97%;background-color: '.$color[$key].'">'.ucwords($ltype->name).' : '.$leadcount[$key].' leads </a></p>';
                      }


                  ?>
              </div>
          </div>
      </div>
        <div class="leadscroll">
        
        <div class="datascrlusr">
        <?php if($_SESSION['userRole']==2)
{
?>
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
}
?>
          <table class="table table-striped"  id="loadleaddatatable">
            <thead>
                <tr>
                    <th></th>
                    <th>Lead Id</th>
                    
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
                    <th>CCO CRD</th>
                    <th>CCO State</th>

                    <th>Address_1</th>
                    <th>Address_2</th>
                    <th>Address_3</th>
                    <th>Address_4</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
                    <th>Phone</th>
                    
                    <th>Website</th>

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
     </div>
    </div>
</div>
<?php include_once('inc/footer.php'); ?>
<script src="<?=BASEURL;?>assets/lib/js/Chart.bundle.min.js">
</script>
<div class="modal fade " id="followup_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Followup</h4>
            </div>
            <div class="modal-body">
                <form action="<?=BASEURL;?>user/followup" id="followup_frm" class="" method="post">
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
        					    <select multiple class="form-control assignleadsuser" data-id="<?=$data->id;?>">
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
<script>
var statuscolor = <?=json_encode($statuscolor);?>;
var ctx = document.getElementById('pie-chart');
var mychart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: [<?=$labels;?>],
      datasets: [{
        label: "Leads Type",
        backgroundColor: [<?=$labcolor;?>],
        data: [<?=implode(",", $leadcount);?>]
      }]
    },
    options: {
        title: {
            display: true,
            text: 'Leads Type'
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

        var reurl = "<?=BASEURL;?>user/lead/"+label.toLowerCase();
        window.location.href= reurl;
        // table.columns( 28 ).search(label).draw();
      }
    };
</script>
