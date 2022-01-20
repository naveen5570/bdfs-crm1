<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="notypnl">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#activetb" aria-controls="activetb" role="tab" data-toggle="tab">Pending</a></li>
                <li role="presentation"><a href="#panding" aria-controls="panding" role="tab" data-toggle="tab">Completed</a></li>
                
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="activetb">
                    <table class="table table-striped alldatatbl">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Lead</th>
                                <th>Date</th>
                                <th>Fields To Edit</th>
                                <th>Added By</th>
                                 </tr>
                        </thead>
                        <tbody>
               <?php
                $i = 1;
                foreach($useredits as $data)
				{
					if($data->status==0)
					{
          $lead = Lead::all(['id'=>$data->leadid]);
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><a href="<?=BASEURL;?>administrator/viewLead/<?=$data->leadid;?>"><?=$lead[0]->firm_name;?></a></td>
                    <td><?=$data->date;?></td>
                    <td><?=$data->fields;?></td>
                    <td>
                     <?php 
                     $user = Subadmin::all(['id'=>$data->user_id]);
                     echo $user[0]->name;

                      ?>

                    </td>
                    <td>
                        <div class="btn-group">
                          <a class="btn btn-primary" href="<?=BASEURL;?>administrator/viewEdits/<?=$data->id;?>" ><i class="fa fa-eye"></i> View</a>
                          <a class="btn btn-primary" href="<?=BASEURL;?>administrator/markComplete/<?=$data->id;?>" ><i class="fa fa-eye"></i> Mark Complete</a>
                            <a href="<?=BASEURL;?>administrator/deleteEdits/<?=$data->id;?>"  class="btn btn-danger "><i class="fa fa-trash"></i> Delete</a>

                        </div>
                   </td>
                </tr>
                <?php $i++;
					}
				}
				?>
            </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="panding">
                    <table class="table table-striped alldatatbl">
                        <thead>
                           <tr>
                                <th>S.No</th>
                                <th>Lead</th>
                                <th>Date</th>
                                <th>Fields To Edit</th>
                                <th>Added By</th>
                                 </tr> 
                        </thead>
                        <tbody>
               <?php
                $i = 1;
                foreach($useredits as $data){
					if($data->status==1)
					{
          $lead = Lead::all(['id'=>$data->leadid]);
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><a href="<?=BASEURL;?>administrator/viewLead/<?=$data->leadid;?>"><?=$lead[0]->firm_name;?></a></td>
                    <td><?=$data->date;?></td>
                    <td><?=$data->fields;?></td>
                    <td>
                     <?php 
                     $user = Subadmin::all(['id'=>$data->user_id]);
                     echo $user[0]->name;

                      ?>

                    </td>
                    <td>
                        <div class="btn-group">
                          <a class="btn btn-primary" href="<?=BASEURL;?>administrator/viewEdits/<?=$data->id;?>" ><i class="fa fa-eye"></i> View</a>
                            <a href="<?=BASEURL;?>administrator/deleteEdits/<?=$data->id;?>"  class="btn btn-danger "><i class="fa fa-trash"></i> Delete</a>

                        </div>
                   </td>
                </tr>
                <?php $i++;
				}
				}
				?>
            </tbody>
                    </table>
                    
                </div>
                
            </div>

        </div>
        
    </div>
</div>
<?php include_once('inc/footer.php'); ?>
