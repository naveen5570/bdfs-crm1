<?php include_once('inc/header.php');?>
<div class="container">
    <div class="dashuser">   
        <div class="viewLead">
            <div class="row">
                <div class="col-md-4">
                    <h1><?=$data->firm_name;?></h1>
                </div>
                <div class="col-md-8">
                    <ul class="viewldlst">
                        <li><a href="javascript:;" data-toggle="modal" data-target="#SendMail">Send Mail</a></li>
                        <li><a href="javascript:;" data-toggle="modal" data-target="#notesmodel">Add Notes</a></li>
                        <li><a href="javascript:;">Edit</a></li>
                        <li><a href="javascript:;"><i class="fa fa-ellipsis-h"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="leadinfo">
                <h3>Lead Information</h3>
                 <div class="row">
                    <div class="col-md-2">Phone</div>
                    <div class="col-md-4"><?=$data->phone;?></div>
                    <div class="col-md-2">Website</div>
                    <div class="col-md-4"><?=$data->website;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Address 1</div>
                    <div class="col-md-4"><?=$data->address_1;?></div>
                    <div class="col-md-2">Address 2</div>
                    <div class="col-md-4"><?=$data->address_2;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Address 3</div>
                    <div class="col-md-4"><?=$data->address_3;?></div>
                    <div class="col-md-2">Address 4</div>
                    <div class="col-md-4"><?=$data->address_4;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">City</div>
                    <div class="col-md-4"><?=$data->city;?></div>
                    <div class="col-md-2">State</div>
                    <div class="col-md-4"><?=$data->state;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Zip Code</div>
                    <div class="col-md-4"><?=$data->zipcode;?></div>
                    <div class="col-md-2">Firm CRD</div>
                    <div class="col-md-4"><?=$data->firm_crd;?></div>
                </div>
            </div>
            <div class="leadinfo">
                <h3>CEO Information</h3>
                 <div class="row">
                    <div class="col-md-2">New CEO Name</div>
                    <div class="col-md-4"><?=$data->new_ceo_name;?></div>
                    <div class="col-md-2">CEO Name</div>
                    <div class="col-md-4"><?=$data->ceo_name;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Email</div>
                    <div class="col-md-4"><?=$data->ceo_email;?></div>
                    <div class="col-md-2">Number</div>
                    <div class="col-md-4"><?=$data->ceo_number;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">CEO Letter</div>
                    <div class="col-md-4"><?=ucwords($data->ceo_letter_type);?></div>
                    <div class="col-md-2">CRD</div>
                    <div class="col-md-4"><?=$data->ceo_crd;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Finop Name</div>
                    <div class="col-md-4"><?=$data->ceo_finop_name;?></div>
                    <div class="col-md-2">Finop Card</div>
                    <div class="col-md-4"><?=$data->ceo_finop_card;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">CEO Linkedin</div>
                    <div class="col-md-10"><?=$data->ceo_linkedin;?></div>
                </div>
            </div>
            <div class="leadinfo">
                <h3>CCO Information</h3>
                 <div class="row">
                    <div class="col-md-2">New CCO Name</div>
                    <div class="col-md-4"><?=$data->new_cco_name;?></div>
                    <div class="col-md-2">CCO Name</div>
                    <div class="col-md-4"><?=$data->cco_name;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Email</div>
                    <div class="col-md-4"><?=$data->cco_email;?></div>
                    <div class="col-md-2">Number</div>
                    <div class="col-md-4"><?=$data->cco_number;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">State</div>
                    <div class="col-md-4"><?=$data->cco_state;?></div>
                    <div class="col-md-2">CRD</div>
                    <div class="col-md-4"><?=$data->cco_crd;?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">CCO Linkedin</div>
                    <div class="col-md-10"><?=$data->cco_linkedin;?></div>
                </div>
            </div>
            <div class="leadinfo">
                <h3>INTRODUCING ARRANGEMENTS</h3>
                <div class="row">
                    <div class="col-md-12"><?=$data->aboutlead;?></div>
                </div>
            </div>  
        </div>
    </div>
</div>
<?php include_once('inc/footer.php');?>