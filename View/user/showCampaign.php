<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit"><?php
			foreach($list as $head)
			{}
			echo $head->campaign;
			?></h1>
            <a href="<?=BASEURL;?>user/emailer/" type="button" class="btn"><i class="fa fa-plus"></i> Add New Emailer</a>
        </div>
        <div class="leadpage">
        
        <table id="example" class="display" style="width:100%">
        <thead>
                <tr>
                    <th>S.No</th>
                    
                    <th>Subject</th>
                    <th>CEO Name</th>
                    <th>CEO Email</th>
                    <th  class="tt">status</th>
                </tr>
            </thead>
       <tbody>
            
               <?php
                $i = 1;
                foreach($list as $data){
                    
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    
                    <td style="text-align:center"><?=$data->subject;?></td>
                    <td style="text-align:center"><?=$data->ceo_name;?></td>
                    <td style="text-align:center"><?=$data->email_id;?></td>
                    <td style="text-align:center"><?=$data->status;?></td>
                </tr>
                <?php $i++;}?>
            </tbody>
        <tfoot>
            <tr>
                    <th>S.No</th>
                    
                    <th>Subject</th>
                    <th>CEO Name</th>
                    <th>CEO Email</th>
                    <th>status</th>
                </tr>
        </tfoot>
    </table>
        
    </div> 
    <br/>
    
    </div>            
    </div>
  
               
<?php include_once('inc/footer.php');?>