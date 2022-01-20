<?php include_once('inc/header.php'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="leadfrm">
            <form action="<?=BASEURL;?>administrator/updateArticle"  class="leadstsfrm" method="post">
                <div class="creoption">
                    <h1 class="headtit">Create Article</h1>
                    <a href="<?=BASEURL;?>administrator/articles/" class="btn addbtn">Cancel</a>
                    <button class="btn" type="submit">Save and New</button>
                </div>
                <div class="myform">
                    <h6>Article Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12">
                            <label for="">Article Name</label>
                            <input type="hidden" name="token" value="<?=$key?>">
                            <input type="hidden" name="article_id" value="<?=$article->id;?>">
                            <input type="text" class="form-control" name="name" placeholder="Enter Article Name" required value="<?=$article->name;?>">
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                            <label for="">Article Content</label>
                            <textarea rows="5"  class="form-control" name="content" required><?=$article->description;?></textarea>
                        </div>


                    </div>
                </div>
                <div class="myform">
                    <h6>Select Article Send Leads</h6>
                    <hr class="myhr">
                    <div class="row">

                      <div class="form-group col-md-12 col-sm-12">
                          <table class="table table-striped alldatatbl"  id="">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lead Id</th>
                                    <th>Assign To</th>
                                    <th>Firm Name</th>
                                    <th>CEO name</th>
                                    <th>Lead Type</th>
                                    <th>Lead Status</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php

                                   foreach($leads as $data){

                                     if($data->user_id == 0){
                                       $assignto = 'Admin';
                                     }else{
                                         $assignusers = Subadmin::all(['id'=>$data->user_id]);
                                         $assignto = $assignusers[0]->name;
                                     }
                                    //  $leadtype = Leadstype::find($data->leadfrom)->name;
                                    //  $leadtype = $leadtype->name;
                               ?>
                                     <tr>

                                         <td><Input type="checkbox" name="leadids[]" class="leads_checkbox" value=<?=$data->id;?> <?php if(in_array($data->id,$artical_leadids)){echo " checked";} ?>></td>
                                         <td>#<?=sprintf('%04d',$data->id);?></td>
                                         <td><?=$assignto;?></td>
                                         <td><a href="<?=BASEURL;?>administrator/viewLead/<?=$data->id;?>" target="_blank"><?=$data->firm_name?></a></td>
                                         <td><?=$data->ceo_name;?></td>
                                         <td><?=Leadstype::find($data->leadfrom)->name;?></td>
                                         <td><?=Leadstatu::find($data->lead_status_id)->name;?></td>

                                     </tr>
                               <?php
                                   }
                               ?>
                            </tbody>
                          </table>
                      </div>

                    </div>
                </div>

                <div class="creoption">
                    <button class="btn">Cancel</button>
                    <button class="btn" type="submit">Save and New</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('inc/footer.php');?>
