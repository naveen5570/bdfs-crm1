<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="creoption">
              <h1 class="headtit">Lead Filter</h1>
          </div>
        </div>
       </div>
       <div class="row">
           <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Filter Leads</h3>
              </div>
              <div class="panel-body">
                <form class="" method="post" action="<?=BASEURL;?>user/showFilterLeads">
                  <div class="form-group col-sm-12">
                    <label for="inputEmail3" class="col-sm-12 control-label">Bussiness Lines</label>
                    <div class="col-sm-6">
                      <div class="">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer making inter-dealer markets in corporate securities over-the-counter", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer making inter-dealer markets in corporate securities over-the-counter"> Broker or dealer making inter-dealer markets in corporate securities over-the-counter
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer retailing corporate equity securities over-the-counter", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer retailing corporate equity securities over-the-counter"> Broker or dealer retailing corporate equity securities over-the-counter
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling corporate debt securities", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling corporate debt securities"> Broker or dealer selling corporate debt securities
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling interests in mortgages or other receivables", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling interests in mortgages or other receivables"> Broker or dealer selling interests in mortgages or other receivables
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling oil and gas interests", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling oil and gas interests"> Broker or dealer selling oil and gas interests
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling securities of non-profit organizations (e.g., churches, hospitals)", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling securities of non-profit organizations (e.g., churches, hospitals)"> Broker or dealer selling securities of non-profit organizations (e.g., churches, hospitals)
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling securities of only one issuer or associate issuers (other than mutual funds)", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling securities of only one issuer or associate issuers (other than mutual funds)"> Broker or dealer selling securities of only one issuer or associate issuers (other than mutual funds)
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling tax shelters or limited partnerships in primary distributions", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling tax shelters or limited partnerships in primary distributions"> Broker or dealer selling tax shelters or limited partnerships in primary distributions
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling tax shelters or limited partnerships in the secondary market", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling tax shelters or limited partnerships in the secondary market"> Broker or dealer selling tax shelters or limited partnerships in the secondary market
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Broker or dealer selling variable life insurance or annuities", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Broker or dealer selling variable life insurance or annuities"> Broker or dealer selling variable life insurance or annuities
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Exchange member engaged in exchange commission business other than floor activities", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Exchange member engaged in exchange commission business other than floor activities"> Exchange member engaged in exchange commission business other than floor activities
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Exchange member engaged in floor activities", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Exchange member engaged in floor activities"> Exchange member engaged in floor activities
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="">

                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Investment advisory services", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Investment advisory services"> Investment advisory services
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Municipal securities broker", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Municipal securities broker"> Municipal securities broker
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Municipal securities dealer", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Municipal securities dealer"> Municipal securities dealer
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Mutual fund retailer", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Mutual fund retailer"> Mutual fund retailer
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Non-exchange member arranging for transactions in listed securities by exchange member", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Non-exchange member arranging for transactions in listed securities by exchange member"> Non-exchange member arranging for transactions in listed securities by exchange member
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Private placements of securities", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Private placements of securities"> Private placements of securities
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Put and call broker or dealer or option writer", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Put and call broker or dealer or option writer"> Put and call broker or dealer or option writer
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Real estate syndicator", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Real estate syndicator"> Real estate syndicator
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Solicitor of time deposits in a financial institution", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Solicitor of time deposits in a financial institution"> Solicitor of time deposits in a financial institution
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Trading securities for own account", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Trading securities for own account"> Trading securities for own account
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("Underwriter or selling group participant (corporate securities other than mutual funds", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="Underwriter or selling group participant (corporate securities other than mutual funds"> Underwriter or selling group participant (corporate securities other than mutual funds
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("U S. government securities broker", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="U S. government securities broker"> U.S. government securities broker
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="business_lines[]"
                            <?php if(isset($business_lines)){
                              if (in_array("U S. government securities dealer", $business_lines))
                              {
                              echo " checked ";
                              }
                            } ?> value="U S. government securities dealer"> U.S. government securities dealer
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-sm-6 leadstsfrm">
                    <label for="inputEmail3" class="col-sm-5 control-label">Lead From</label>
                    <div class="col-sm-7">
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
                    <label for="inputEmail3" class="col-sm-5 control-label">Lead Status</label>
                    <div class="col-sm-7">
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
                      <a href="<?=BASEURL;?>user/leadFiltaration" class="btn btn-danger">Reset Filter</a>
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

                      ?>
                            <tr>

                                <td>#<?=sprintf('%04d',$data->id);?></td>
                                <td><a href="<?=BASEURL;?>user/viewLead/<?=$data->id;?>" target="_blank"><?=$data->firm_name?></a></td>
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
