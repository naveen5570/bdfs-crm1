<?php include_once('inc/header.php');?>
<div class="container">
    <div class="dashuser">
        <div class="creoption">
            <h1 class="headtit">All Notification</h1>
        </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Post</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
                foreach($connects as $data){
                    
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><?=substr($data->msg,0 ,30);?></td>
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
                            <a href="<?=BASEURL;?>user/view_notification/<?=$data->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                        </div>
                   </td>
                </tr>
                <?php $i++;}?>
            </tbody>
        </table>
    </div> 
    </div>            
</div>
<?php include_once('inc/footer.php')?>