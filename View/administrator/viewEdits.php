<?php include_once('inc/header.php'); ?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="viewLead">
            
             <div class="leadinfo">
                <div class="row" style="border-bottom:none; margin:0px;">
                    <div class="col-md-6">
                        <h3>View Edit Request </h3>
                         <div class="row">
                            <div class="col-md-4"><strong>Lead:</strong></div>
                            <div class="col-md-8">
                            <a href="<?=BASEURL?>administrator/viewLead/<?=$data[0]->leadid;?>">
                            <?php
							$lead = Lead::all(['id'=>$data[0]->leadid]);
							echo $lead[0]->firm_name;
							?>
                            </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Lead Crd:</strong></div>
                            <div class="col-md-8"><?=$data[0]->crd;?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Fields to Edit:</strong></div>
                            <div class="col-md-8">
                            <?php 
							$ex = explode(',',$data[0]->fields); 
							foreach ($ex as $ex1)
							{
								echo $ex1.'<br>'; 
							}
							?>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-4"><strong>Remarks:</strong></div>
                            <div class="col-md-8"><?=ucwords($data[0]->remarks);?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Date:</strong></div>
                            <div class="col-md-8">
                               <?= $data[0]->date ?>
                            </div>
                        </div>
						
                    </div>
                    <div class="col-md-1">
                    </div>
                    

                </div>



            </div>
            
            
        </div>
</div></div>
<?php include_once('inc/footer.php'); ?>
