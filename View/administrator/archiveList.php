<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Archive Leads</h1>
            </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Lead Id</th>
                    
                    <th>Lead CRD</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date Added</th>
                    
                   <th>Action</th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
				$j=0;
                foreach($archives as $list){
                $va = Lead::all(['id'=>$list->leadid]);
                ?>
                <tr class="gc_row row<?=$i;?>">
                    <td><?=$i;?></td>
                    <td style="text-align:center"><?=$list->leadid;?></td>
                    <td style="text-align:center"><?=$list->lead_crd;?></td>
                    <td style="text-align:center"><?php if(isset($va[0])){ echo $va[0]->ceo_email;} ?></td>
                    <td style="text-align:center"><?php if(isset($va[0])){echo $va[0]->phone;}?></td>
                    <td style="text-align:center"><?=date('m-d-y',$list->date);?></td>
                    <td style="text-align:center"><a class="btn btn-info" href="<?=BASEURL?>administrator/restoreLead/<?=$list->id?>">Restore</a></td>
                </tr>
                <?php $i++; $j++;}?>
            </tbody>
        </table>
    </div> 
    <br/>
    
    </div>            
    </div>
    
    
                   
<?php include_once('inc/footer.php');?>