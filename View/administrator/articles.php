<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Articles</h1>
            <a href="<?=BASEURL;?>administrator/addNewArticle/" class="btn addbtn">
            <i class="fa fa-plus"></i> Add New Article</a>
        </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Article Name</th>
                    <th>Date</th>
                    <th>Send to Total Leads</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
                foreach($articles as $data){

                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><?=ucwords($data->name);?></td>
                    <td><?=date("j M, Y",$data->date);?></td>
                    <td><?=count(LeadArticle::all(["article_id" => $data->id]));?></td>
                    <td>
                        <div class="btn-group">
                          <a class="btn btn-primary" href="<?=BASEURL;?>administrator/editArticle/<?=$data->id;?>" ><i class="fa fa-pencil"></i> Edit</a>
                            <a data-id="<?=$data->id;?>" class="btn btn-danger deleteArticle"><i class="fa fa-trash"></i> Delete</a>

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
