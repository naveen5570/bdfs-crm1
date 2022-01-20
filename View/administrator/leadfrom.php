<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit"><?=ucwords($leadstypes->name);?> Status</h1>
            <a data-toggle="modal" data-target="#addModel" class="btn addbtn">
            <i class="fa fa-plus"></i> Add New Status</a>
        </div>
        <div class="leadpage">
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th></th>l
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
		$leadstatus = Leadstatu::all(['lead_type_id' =>$leadstypes->id]);
                foreach($leadstatus as $data){

                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><?=ucwords($data->name);?></td>
                    <td>
                        
                        <div class="btn-group">
                        <?php 
                        	if($data->id == 8){
                        	
                        	}elseif($data->id == 37){
                        	?>
                             <a href="http://bdforsale.com/administrator/leadstatusdetail/37" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                            <?php
                        	}elseif($data->id == 55){
                        	?>
                           <a href="http://bdforsale.com/administrator/leadstatusdetail/55" class="btn btn-primary"><i class="fa fa-eye"></i> View</a> 
                            <?php
                        	}else{
                        ?>
                        <a href="http://bdforsale.com/administrator/leadstatusdetail/<?=$data->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                            <a href="javascript:;" class="btn btn-danger deleteStatus" data-id="<?=$data->id;?>" ><i class="fa fa-trash"></i> Delete</a>
                            <?php }?>
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
        <h4 class="modal-title" id="myModalLabel">Add New Status</h4>
      </div>
      <div class="modal-body">
        <form action="<?=BASEURL;?>administrator/addStatus" method="post">
            <div class="form-group">
                <label for="">Name</label>
                <input type="hidden" value="<?=$key;?>" name="token">
                <input type="hidden" value="<?=$leadstypes->id;?>" name="leadstypes">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            </div>
            <button type="submit" class="btn mybtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>