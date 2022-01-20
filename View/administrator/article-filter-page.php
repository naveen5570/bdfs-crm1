<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="creoption">
              <h1 class="headtit">Article Filter</h1>
          </div>
        </div>
        <!-- <div class="form-group col-md-5 col-sm-6">
            <label for="" class="col-md-3 col-sm-5 control-label text-right">User</label>
            <div class="col-md-9 col-sm-7">
              <select name="user" class="form-control selecteduser">
                  <option value="">All Users</option>
                  <?php
                      foreach($users as $users){
                          echo "<option value='".$users->id."'>".$users->name."</option>";
                      }
                  ?>
              </select>
            </div>

        </div> -->
       </div>
       <div class="row">
           <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Filter Article</h3>
              </div>
              <div class="panel-body">
                <form class="" method="post" action="<?=BASEURL;?>administrator/showFilterArticle">
                  <div class="form-group col-sm-6">
                    <input type="hidden" name="token" value="<?=$key?>">
                    <label for="inputEmail3" class="col-sm-3 control-label">Article</label>
                    <div class="col-sm-8">
                      <select name="article" class="form-control " required>
                          <option value="">-- Select Article --</option>
                          <?php
                              foreach($articles as $article){
                                  echo "<option value='".$article->id."' ";
                                  if(isset($selectedarticle)){
                                    if($selectedarticle->id == $article->id){
                                      echo " selected ";
                                    }
                                  }
                                  echo ">".$article->name."</option>";
                              }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group  col-sm-6">
                    <label for="inputPassword3" class="col-sm-3 control-label">Show Lead</label>
                    <div class="col-sm-8">
                      <select name="showlead" class="form-control " required>
                          <option value="">-- Which Lead To Show ? --</option>
                          <option value="send"
                          <?php if(isset($showlead)){
                                  if($showlead == 'send'){
                                    echo " selected ";
                                  }
                          } ?>
                          >Send Leads</option>
                          <option value="unsend"
                          <?php if(isset($showlead)){
                                  if($showlead == 'unsend'){
                                    echo " selected ";
                                  }
                          } ?>
                          >Unsend Leads</option>

                      </select>
                    </div>
                  </div>
                  <div class="form-group col-sm-6 leadstsfrm">
                    <label for="inputEmail3" class="col-sm-3 control-label">Lead From</label>
                    <div class="col-sm-8">
                      <select name="leadfrom" class="form-control leadtypeselect">
                          <option value="">-- Select Lead Type --</option>
                          <?php
                              $leadstypes = Leadstype::all(['status'=>1]);
                              foreach($leadstypes as $leadstypes){
                          ?>
                              <option value="<?=$leadstypes->id;?>"
                                <?php if(isset($leadfrom)){
                                  if($leadfrom == $leadstypes->id){
                                    echo " selected ";
                                  }
                                }
                               ?>
                              ><?=ucwords($leadstypes->name);?></option>
                          <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Lead Status</label>
                    <div class="col-sm-8">
                      <select name="lead_status" class="form-control leadstatusbytype">
                          <option value="">-- Choose Status --</option>
                          <?php if(isset($leadfrom)){
                                    $leadstatus = Leadstatu::all(['lead_type_id'=>$leadfrom]);
                                    if(count($leadstatus) > 0){
                                        foreach($leadstatus as $status){
                                    ?>
                                        <option value="<?=$status->id;?>"
                                          <?php if(isset($lead_status)){
                                            if($lead_status == $status->id){
                                              echo " selected ";
                                            }
                                          }
                                         ?>
                                        ><?=ucwords($status->name);?></option>
                                    <?php }
                                    }
                                }
                         ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">Filter</button>
                      <a href="<?=BASEURL;?>administrator/articleFiltaration" class="btn btn-danger">Reset Filter</a>
                    </div>
                  </div>
                </form>
              </div>
           </div>
        </div>

        <div class="row">
           <div class="leadpage">
             <div class="col-md-12 col-sm-12">
                 <table class="table table-striped alldatatbl"  id="">
                   <thead>
                       <tr>
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
                        if(isset($leads)){
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

                                <td>#<?=sprintf('%04d',$data->id);?></td>
                                <td><?=$assignto;?></td>
                                <td><a href="<?=BASEURL;?>administrator/viewLead/<?=$data->id;?>" target="_blank"><?=$data->firm_name?></a></td>
                                <td><?=$data->ceo_name;?></td>
                                <td><?=Leadstype::find($data->leadfrom)->name;?></td>
                                <td><?=Leadstatu::find($data->lead_status_id)->name;?></td>

                            </tr>
                      <?php
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
<?php include_once('inc/footer.php')?>
