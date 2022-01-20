<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Leads Type</h1>
        </div>
        <div class="leadpage">
        <table class="table table-striped">
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
                foreach($leadstypes as $data){

                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><?=ucwords($data->name);?></td>
                    <td>
                        <div class="btn-group">
                            <a href="<?=BASEURL;?>administrator/leadfrom/<?=$data->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
							<a href="#editTypeModel"  data-toggle="modal" class="btn btn-info editLeadsData" data-id="<?=$data->id;?>"  data-name="<?=$data->name;?>"><i class="fa fa-pencil"></i> Edit</a>
							
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
<div class="modal fade" id="editTypeModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Leads Type</h4>
      </div>
      <div class="modal-body">
        <form action="<?=BASEURL;?>administrator/updateLeadsfrom" method="post">
            <div class="form-group">
                <label for="">Name</label>
                <input type="hidden" value="" name="id" class="getvalFrmid">
                <input type="text" name="name" class="form-control getvalFrmdta" placeholder="Enter Name" required>
            </div>
            <button type="submit" class="btn mybtn">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
