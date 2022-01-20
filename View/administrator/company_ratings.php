<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Ratings</h1>
            <a data-toggle="modal" data-target="#addModel" class="btn addbtn">
            <i class="fa fa-plus"></i> Add New Rating</a>
        </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
                foreach($ratings as $data){
                    
                ?>
                <tr>
                    <td><?=$i;?></td>
                    <td><?=$data->name;?></td>
                    <td><?php
                        if($data->status == 1){
                            echo"<span class='label label-success'>Active</span>";
                        }else{
                             echo"<span class='label label-danger'>Deactive</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="javascript:;" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                   </td>
                </tr>
                <?php $i++;}?>
            </tbody>
        </table>
    </div> 
    </div>            
    </div>
<?php include_once('inc/footer.php'); ?>
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Ratings</h4>
      </div>
      <div class="modal-body">
        <form action="<?=BASEURL;?>administrator/addRatings" method="post">
            <div class="form-group">
                <label for="">Name</label>
                <input type="hidden" value="<?=$key;?>" name="token">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            </div>
            <button type="submit" class="btn mybtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>




				