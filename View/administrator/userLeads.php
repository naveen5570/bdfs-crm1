<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        
        <div class="leadpage">
        
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Lead Name</th>
                    <th>Lead Id</th>
                    <th>Added By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
                foreach($leads as $data){
                    
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td style="text-align:center"><a href="<?=BASEURL.'administrator/viewLead/'.$data->leadid?>"><?=$data->lead?></a></td>
                    <td style="text-align:center"><?=$data->leadid?></td>
                    <td style="text-align:center">
                    <?php
                    $val = Subadmin::all(['id'=>$data->added_by]);

                    echo $val[0]->name;
                    ?>   
                    </td>
                    <td style="text-align:center"><?=$data->date?></td>
                </tr>
                <?php $i++;}?>
            </tbody>
        </table>
        
    </div> 
    <br/>
    
    </div>            
    </div>
  
               
<?php include_once('inc/footer.php');?>