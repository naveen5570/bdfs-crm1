<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Users</h1>
            <a href="<?=BASEURL;?>administrator/emailer/" type="button" class="btn"><i class="fa fa-plus"></i> Add New Emailer</a>
        </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
                foreach($list as $data){
                    
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td style="text-align:center"><?=$data->name;?></td>
                    <td><div class="btn-group">
                            
                            <a href="<?=BASEURL;?>administrator/viewNewsletter/<?=$data->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                        </div></td>
                        <td><div class="btn-group">
                            
                            <a href="<?=BASEURL;?>administrator/emaileditor/<?=$data->id;?>" class="btn btn-info"><i class="fa fa-pencil"></i>  Edit</a>
                        </div></td>
                        
                        <td style="text-align:center;"><div class="btn-group">
                            
                            <a href="<?=BASEURL;?>administrator/deleteNewsletter/<?=$data->id;?>" class="btn btn-danger"><i class="fa fa-trash"></i>  Delete</a>
                        </div></td>
                        
                        
                 </tr>
                <?php $i++;}?>
            </tbody>
        </table>
    </div> 
    <br/>
    
    </div>            
    </div>
                   
<?php include_once('inc/footer.php');?>