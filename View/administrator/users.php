<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Users</h1>
            <a href="<?=BASEURL;?>administrator/addNewUser/" type="button" class="btn"><i class="fa fa-plus"></i> Add New User</a>
        </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
                foreach($users as $data){
                    
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><?=$data->name;?></td>
                    <td><?=$data->email;?></td>
                    <td><?=$data->mobile;?></td>
                    <td>
                        <div class="btn-group">
                            <a href="<?=BASEURL;?>administrator/editUser/<?=$data->id;?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="<?=BASEURL;?>administrator/profile/<?=$data->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                            <a href="javascript:;" class="btn btn-danger deleteUser" data-id="<?=$data->id;?>"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                   </td>
                </tr>
                <?php $i++;}?>
            </tbody>
        </table>
    </div> 
    </div>            
    </div>
</div>
<?php include_once('inc/footer.php')?>




				