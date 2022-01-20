<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit"><?=ucwords($leadsubstatus->name);?> Sub Status</h1>
            <a data-toggle="modal" data-target="#addModel" class="btn addbtn">
            <i class="fa fa-plus"></i> Add New Sub-substatus</a>
        </div>
        <div class="leadpage">
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
		$leadsubsubstatus = Leadsubsubstatu::all(['lead_substatus_id' =>$leadsubstatus->id]);
                foreach($leadsubsubstatus as $data){

                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><?=ucwords($data->name);?></td>
                    <td>
                        
                        <div class="btn-group">
                        <?php 
                        	if($data->id == 8){
                        	
                        	}elseif($data->id == 37){
                        	
                        	}elseif($data->id == 55){
                        	
                        	}else{
                        ?>
                            <a href="javascript:;" class="btn btn-danger deleteSubsubstatus" data-id="<?=$data->id;?>" ><i class="fa fa-trash"></i> Delete</a>
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
        <h4 class="modal-title" id="myModalLabel">Add New Sub-substatus</h4>
      </div>
      <div class="modal-body">
        <form action="<?=BASEURL;?>administrator/addSubsubstatus" method="post">
            <div class="form-group">
                <label for="">Name</label>
                <input type="hidden" value="<?=$key;?>" name="token">
                <input type="hidden" value="<?=$leadsubstatus->id;?>" name="leadstypes">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            </div>
            <button type="submit" class="btn mybtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>