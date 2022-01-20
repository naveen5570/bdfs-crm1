<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Notifications</h1>
        </div>
        <div class="dashnoti">
                    <ul data-time = "<?=time();?>" class="notificationlist">
                        <?php 
                            foreach ($notifications as $notification) { 
                                if($notification->createdby == 0){
                                    $username = "Admin";
                                    $userimg = "";
                                }else{
                                    $users = Subadmin::all(['id'=>$notification->createdby]);
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
                            <a href="<?=BASEURL;?>administrator/view_notification/">
                                <?php if($userimg == ""){ ?>
                                    <img src="<?=BASEURL;?>assets/administrator/img/user.png" alt="">
                                <?php }else{ ?>
                                    <img src="<?=BASEURL;?>uploads/images/<?=$userimg;?>" alt="">
                                <?php } ?>
                                
                                <h5><?=$username;?><span><?=timerFormat($notification->date,time())." ago"?></span></h5>
                                <p><?=$notification->msg;?> 
                                    <?php if($notification->leadid !=0 ){
                                        $leadofnoti = Lead::all(['id' => $notification->leadid]);
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