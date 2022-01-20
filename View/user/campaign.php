<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">All Campaigns</h1>
            
            <a href="<?=BASEURL;?>user/emailSend/" type="button" class="btn"><i class="fa fa-send"></i>  Send Campaign</a>
       
        </div>
        <div class="leadpage">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Campaign Name</th>
                    <th>Template Sent</th>
                    <th>Date</th>
                    <th>Opened</th>
                    <th>Not Opened</th>
                    <th>Clicked</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $i = 1;
				$j=0;
                foreach($list as $list){
                
                ?>
                <tr class="gc_row row<?=$i;?>">
                    <td><?=$i;?></td>
                    <td style="text-align:center"><?=$list->campaign;?></td>
                    
                    <td>
                    <a href="<?php
					foreach($temp_id as $temp_id1)
					{
				
						
						if($temp_id1->name==trim($list->template))
						{
						echo BASEURL.'administrator/viewNewsletter/'.$temp_id1->id.'" target="_blank"';
						}
						
					}
					?>" ><?= $list->template; ?></a></td>
                    
                    <td style="text-align:center"><?= date('m-d-y',strtotime($list->date_)); ?></td>
                    <td style="text-align:center"><?= $opened[$j] ?></td>
                    <td style="text-align:center"><?= $not_opened[$j] ?></td>
                    <td style="text-align:center"><?= $clicked[$j] ?></td>
                    <td style="text-align:center"><a  class="btn btn-primary" href="<?php echo 'showCampaign/' .str_replace(' ','_',$list->campaign) ?>"><i class="fa fa-eye"></i> View</a></td>
                </tr>
                <?php $i++; $j++;}?>
            </tbody>
        </table>
    </div> 
    <br/>
    
    </div>            
    </div>
                   
<?php include_once('inc/footer.php');?>