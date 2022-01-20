<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="notypnl">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#activetb" aria-controls="activetb" role="tab" data-toggle="tab">Pending</a></li>
                <li role="presentation"><a href="#panding" aria-controls="panding" role="tab" data-toggle="tab">Completed</a></li>
                 <li role="presentation"><a href="#rejected" aria-controls="rejected" role="tab" data-toggle="tab">Rejected</a></li>
                
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="activetb">
                    <table class="table table-striped alldatatbl">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Lead</th>
                                <th>Date</th>
                                <th>Comments</th>
                                 </tr>
                        </thead>
                        <tbody>
               <?php
                $i = 1;
                foreach($access as $data)
				{
					if($data->status==0)
					{
          $lead = Lead::all(['id'=>$data->leadid]);
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><a href="<?=BASEURL;?>user/viewLead/<?=$data->leadid;?>"><?=$lead[0]->firm_name;?></a></td>
                    <td><?=date('m-d-y',strtotime($data->date));?></td>
                    <td><?=$data->comments;?></td>
                    
                </tr>
                <?php $i++;
					}
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
                                <th>Date</th>
                                <th>Comments</th>
                                 </tr> 
                        </thead>
                        <tbody>
               <?php
                $i = 1;
                foreach($access as $data){
					if($data->status==1)
					{
          $lead = Lead::all(['id'=>$data->leadid]);
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><a href="<?=BASEURL;?>user/viewLead/<?=$data->leadid;?>"><?=$lead[0]->firm_name;?></a></td>
                    <td><?=date('m-d-y',strtotime($data->date));?></td>
                    <td><?=$data->comments;?></td>
                    
                </tr>
                <?php $i++;
				}
				}
				?>
            </tbody>
                    </table>
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="rejected">
                    <table class="table table-striped alldatatbl">
                        <thead>
                           <tr>
                                <th>S.No</th>
                                <th>Lead</th>
                                <th>Date</th>
                                
                                <th>Comments</th>
                                
                                 </tr> 
                        </thead>
                        <tbody>
               <?php
                $i = 1;
                foreach($access as $data){
					if($data->status==2)
					{
          $lead = Lead::all(['id'=>$data->leadid]);
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><a href="<?=BASEURL;?>user/viewLead/<?=$data->leadid;?>"><?=$lead[0]->firm_name;?></a></td>
                    <td><?=date('m-d-y',strtotime($data->date));?></td>
                    
                    <td><?=$data->comments;?></td>
                    
                </tr>
                <?php $i++;
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
<div class="followup_popup">
    <span class="close_followup">X</span>
    <form action="<?=BASEURL;?>user/replyEdits" class="leadstsfrm" method="post">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <label for="">Reply</label>
                <textarea style="width:100%; min-height:200px" class="form-control" name="reply"></textarea>
            </div>
</div>
        <div class="creoption" style="float:left;">
            <input type="hidden" value="" name="id" />
            <button class="btn" type="submit">Reply</button>
        </div>
    </form>
</div>
<style>
.close_followup{
    position: absolute;
    right: -8px;
    font-weight: bold;
    top: -12px;
    cursor: pointer;
    border-radius: 50%;
    padding: 4px 10px;
    background: #000;
    color: #fff;
}
.followup_popup {
    position: fixed;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    max-width: 600px;
    width: 100%;
    z-index: 9998;
    background: #00c6d7;
    padding: 50px 60px;
    border-radius: 8px;
    display: none;
	max-width: 650px;
    width: 100%;
    height: 520px;
}




.followup_button_nav {
    cursor: pointer
}

</style>
<script>
$('.followup_button_nav').click(function() {
    $('.followup_popup').fadeIn();
	var d = $(this).data('id');
	$('input[name="id"]').attr('value',d);
});
$('.close_followup').click(function() {
    $('.followup_popup').fadeOut();
});
</script>
<?php include_once('inc/footer.php'); ?>
