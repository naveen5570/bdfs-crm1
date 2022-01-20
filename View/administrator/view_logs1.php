<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Logs</h1>
        </div>
        <div class="dashnoti">
                    <ul data-time = "<?=time();?>" class="notificationlist">
                        <?php 
                            foreach ($logs as $log) { 
                                if($log->createdby == 0){
                                    $username = "Admin";
                                    $userimg = "";
                                }else{
                                    $users = Subadmin::all(['id'=>$log->createdby]);
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
                        <?php
						$lead = Lead::all(['id'=>$log->leadid]);
					
						?>
                        
                            <a href="<?=BASEURL;?>administrator/view_logs/">
                                <?php if($userimg == ""){ ?>
                                    <img src="<?=BASEURL;?>assets/administrator/img/user.png" alt="">
                                <?php }else{ ?>
                                    <img src="<?=BASEURL;?>uploads/images/<?=$userimg;?>" alt="">
                                <?php } ?>
                                <h4 style="font-size:16px; font-weight:600; margin-bottom:5px;"><?= $lead[0]->firm_name; ?></h4>
                                <h5><?=$username;?><span><?=timerFormat($log->date,time())." ago"?></span></h5>
                                <p><?=$log->msg;?> 
                                    <?php if($log->leadid !=0 ){
                                        $leadofnoti = Lead::all(['id' => $log->leadid]);
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
<?php include_once('inc/footer.php')?>