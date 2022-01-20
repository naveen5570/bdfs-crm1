<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Notification</h1>
        </div>
        <div class="leadpage">
        <div class="notypnl">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#activetb" aria-controls="activetb" role="tab" data-toggle="tab">Today's</a></li>
                <li role="presentation"><a href="#panding" aria-controls="panding" role="tab" data-toggle="tab">Panding</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="activetb">
                    <table class="table table-striped alldatatbl">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>User</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                            $userid = Session::get('userId');
                                $reminds = Remind::all(['status'=>1,'user_id'=>$userid]);
                                foreach($reminds as $data){
                                
                                    $todaydat = date('d/m/y', time());
                                    $datatime = date('d/m/y', $data->reminddate);
                                    if($todaydat == $datatime){
                            ?>
                            <tr class="gc_row row<?=$data->id;?>">
                                <td><?=$i;?></td>
                                <td><?=substr($data->msg,0 ,30);?></td>
                                <td><?=date('d/m/y', $data->createdate);?></td>
                                <td><?php
                                    if($data->user_id == 0){
                                        echo"Administrator";
                                    }else{
                                        echo"Sub Administrator";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?=BASEURL;?>administrator/viewlead/<?=$data->lead_id;?>" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i> View</a>
                                        <a href="javascript:;" class="btn btn-danger deletnoty" data-id="<?=$data->id;?>"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; }}?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="panding">
                    <table class="table table-striped alldatatbl">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>User</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                            
                                $userid = Session::get('userId');
                                $reminds = Remind::all(['status'=>1,'user_id'=>$userid]);
                                foreach($reminds as $data){
                                
                                    $todaydat = date('d/m/y', time());
                                    $datatime = date('d/m/y', $data->reminddate);
                                    if($todaydat != $datatime){
                            ?>
                            <tr class="gc_row row<?=$data->id;?>">
                                <td><?=$i;?></td>
                                <td><?=substr($data->msg,0 ,30);?></td>
                                <td><?=date('d/m/y', $data->createdate);?></td>
                                <td><?php
                                    if($data->user_id == 0){
                                        echo"Administrator";
                                    }else{
                                        echo"Sub Administrator";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?=BASEURL;?>administrator/viewlead/<?=$data->lead_id;?>" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i> View</a>
                                        <a href="javascript:;" class="btn btn-danger deletnoty" data-id="<?=$data->id;?>"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; }}?>
                        </tbody>
                    </table>
                    
                </div>
            </div>

        </div>   
           
           
            
        </div>
    </div>
</div>
<?php include_once('inc/footer.php')?>