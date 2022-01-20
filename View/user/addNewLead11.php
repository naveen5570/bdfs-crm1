<?php include_once('inc/header.php'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="leadfrm">
            <form action="<?=BASEURL;?>user/addlead"  class="leadstsfrm" method="post">
                <div class="creoption">
                    <h1 class="headtit">Create Lead</h1>
                    <button class="btn">Cancel</button>
                    <button class="btn" type="submit">Save and New</button>
                </div>
                <div class="myform">
                    <h6>Lead Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Name of Firm</label>
                            <input type="hidden" name="token" value="<?=$key?>">
                            <input type="text" class="form-control" name="firm_name" placeholder="Enter Firm Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 1</label>
                            <input type="text" class="form-control" name="address_1" placeholder="Enter Address line 1" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 2</label>
                            <input type="text" class="form-control" name="address_2" placeholder="Enter Address line 2">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 3</label>
                            <input type="text" class="form-control" name="address_3" placeholder="Enter Address line 3">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Address 4</label>
                            <input type="text" class="form-control" name="address_4" placeholder="Enter Address line 4">
                        </div>
                         <div class="form-group col-md-6 col-sm-6">
                            <label for="">City</label>
                            <input type="text" class="form-control" name="city" placeholder="Enter City" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">State</label>
                            <input type="text" class="form-control" name="state" placeholder="Enter state" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Zip Code</label>
                            <input type="number" class="form-control" name="zipcode" placeholder="Enter Zip Code">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" placeholder="Enter Phone number" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Firm CRD</label>
                            <input type="text" class="form-control" name="firm_crd" placeholder="Enter Firm CRD">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Website</label>
                            <input type="text" class="form-control" name="website" placeholder="Enter Website">
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>CEO Information</h6>
                    <hr class="myhr">
                    <div class="row">
                       <div class="form-group col-md-6 col-sm-6">
                            <label for="">New CEO Name</label>
                            <input type="text" class="form-control" name="new_ceo_name" placeholder="Enter New CEO Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="field">CEO Name</label>
                            <input type="text" class="form-control" name="ceo_name" placeholder="Enter CEO Name" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO Email</label>
                            <input type="email" class="form-control" name="ceo_email" placeholder="Enter CEO Email" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO Cell Number</label>
                            <input type="number" class="form-control" name="ceo_number" placeholder="Enter CEO Cell Number" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO Linkedin</label>
                            <input type="text" class="form-control" name="ceo_linkedin" placeholder="Enter CEO Linkedin url">
                        </div>
                        <div class="col-md-6 col-sm-6 form-group">
                            <label for="">Letter Type</label>
                            <div class="form-group" name="ceo_letter_type" >
                                <label class="radio-inline"><input type="radio" name="optradio" value="yes" checked>Accepted Connect?</label>
                                <label class="radio-inline"><input type="radio" name="optradio" value="no">No Accept</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CEO CRD</label>
                            <input type="text" class="form-control" name="ceo_crd" placeholder="Enter CEO CRD" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">FINOP Name</label>
                            <input type="text" class="form-control" name="ceo_finop_name" placeholder="Enter FINOP Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">FINOP Card</label>
                            <input type="text" class="form-control" name="ceo_finop_card" placeholder="Enter FINOP Card">
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>CCO Information</h6>
                    <hr class="myhr">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="field">CCO Name</label>
                            <input type="text" id="field" class="form-control" name="cco_name"  placeholder="Enter CCO Name" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">New CCO Name</label>
                            <input type="text" class="form-control" name="new_cco_name" placeholder="Enter New CCO Name " >
                        </div>

                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO Email</label>
                            <input type="email" class="form-control" name="cco_email" placeholder="Enter CCO Email">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO Cell Number</label>
                            <input type="number" class="form-control" name="cco_number" placeholder="Enter CCO Cell Number">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO Linkedin</label>
                            <input type="text" class="form-control" name="cco_linkedin" placeholder="Enter CCO Linkedin url">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">CCO CRD</label>
                            <input type="text" class="form-control" name="cco_crd" placeholder="Enter CCO CRD" >
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">State</label>
                            <input type="text" class="form-control" name="cco_state" placeholder="Enter State">
                        </div>
                    </div>
                </div>
                <div class="myform">
                    <h6>Lead Details</h6>
                    <hr class="myhr">
                    <div class="row">
                       <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead From</label>
                            <select name="leadfrom" class="form-control leadtypeselect" >
                                <option value="">--select--</option>
                                <?php
                                    $leadstypes = Leadstype::all(['status'=>1]);
                                    foreach($leadstypes as $leadstypes){
                                ?>
                                    <option value="<?=$leadstypes->id;?>"><?=ucwords($leadstypes->name);?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Lead Status</label>
                            <select name="lead_status" class="form-control leadstatusbytype" >
                                <option value="">Choose Status</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label for="">Industry</label>
                            <!-- <select name="industry" class="form-control" required>
                                <option value="">--select--</option>
                                <?php
                                    $industries = Industry::all(['status'=>1]);
                                    foreach($industries as $industries){
                                        echo "<option value='".$industries->id."'>".$industries->name."</option>";
                                    }
                                ?>
                            </select> -->
                            <input type="text" class="form-control" name="industry" placeholder="Enter industry">
                        </div>

                    </div>
                </div>
                <div class="myform">
                    <h6>INTRODUCING ARRANGEMENTS</h6>
                    <hr class="myhr">
                    <div class="form-group">
                        <textarea rows="5"  class="form-control" name="aboutlead" ></textarea>
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
