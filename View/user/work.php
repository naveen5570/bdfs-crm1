<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Your Work</h1>
        </div>
        <div class="leadpage">
           <div class="row">
             <div class="col-md-2">
               <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default previousdate"><i class="fa fa-caret-left"></i></button>
                <button type="button" class="btn btn-default nextdate"><i class="fa fa-caret-right"></i></button>
              </div>
             </div>
             <div class="col-md-7">
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
                   $userid = Session::get('userId');
                   $today = strtotime(date('y-m-d'));
                   $tomorrow = $today+86400;
                    $leadtypes = Leadstype::all();
                    foreach ($leadtypes as $leadtype) { ?>
                      <ul class="list-group">
                    <?php
                        $leadstatus = Leadstatu::all(['lead_type_id'=>$leadtype->id]);
                        foreach ($leadstatus as $status) {
                          $condition = "createdby = ".$userid." and notifyto = 0 and date >=  ".$today." and date < ".$tomorrow." and lead_status_id = ".$status->id;

                          $notification = Notification::find_by_sql("SELECT count(*) as totalnotification FROM notifications where ".$condition);
                          if($notification[0]->totalnotification > 0){
                    ?>
                         <li class="list-group-item">
                           <span class="badge"><?=$notification[0]->totalnotification;?></span>
                           <?=$leadtype->name;?> : <?=$status->name;?>
                         </li>
                       <?php } } ?>
                       </ul>
              <?php  } ?>

             </div>
           </div>
        </div>
    </div>
</div>
<?php include_once('inc/footer.php')?>
