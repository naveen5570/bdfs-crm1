<?php include_once('inc/header.php');?>
<div class="container">
    <div class="dashuser">
       <div class="leadspg">
        <table class="table table-striped alldatatbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Firm Name</th>
                    <th>Address_1</th>
                    <th>Address_2</th>
                    <th>Address_3</th>
                    <th>Address_4</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zipcode</th>
                    <th>Phone</th>
                    <th>Firm CRD</th>
                    <th>Website</th>
                    <th>New CEO Name</th>
                    <th>CEO name</th>
                    <th>CEO email</th>
                    <th>CEO number</th>
                    <th>CEO linkedin</th>
                    <th>CEO letter_type</th>
                    <th>CEO crd</th>
                    <th>CEO Finop Name</th>
                    <th>CEO Finop Card</th>
                    <th>CCO Name</th>
                    <th>New CCO Name</th>
                    <th>CCO Email</th>
                    <th>CCO Number</th>
                    <th>CCO Linkedin</th>
                    <th>CCO CRD</th>
                    <th>CCO State</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>
               <?php
                    $i = 1;
                    foreach($leads as $data){
                ?>
                <tr>

                    <td><?=$i;?></td>
                    <td><?=$data->firm_name;?></td>
                    <td><?=$data->address_1;?></td>
                    <td><?=$data->address_2;?></td>
                    <td><?=$data->address_3;?></td>
                    <td><?=$data->address_4;?></td>
                    <td><?=$data->city;?></td>
                    <td><?=$data->state;?></td>
                    <td><?=$data->zipcode;?></td>
                    <td><?=$data->phone;?></td>
                    <td><?=$data->firm_crd;?></td>
                    <td><?=$data->website;?></td>
                    <td><?=$data->new_ceo_name;?></td>
                    <td><?=$data->ceo_name;?></td>
                    <td><?=$data->ceo_email;?></td>
                    <td><?=$data->ceo_number;?></td>
                    <td><?=$data->ceo_linkedin;?></td>
                    <td><?=$data->ceo_letter_type;?></td>
                    <td><?=$data->ceo_crd;?></td>
                    <td><?=$data->ceo_finop_name;?></td>
                    <td><?=$data->ceo_finop_card;?></td>
                    <td><?=$data->cco_name;?></td>
                    <td><?=$data->new_cco_name;?></td>
                    <td><?=$data->cco_email;?></td>
                    <td><?=$data->cco_number;?></td>
                    <td><?=$data->cco_linkedin;?></td>
                    <td><?=$data->cco_crd;?></td>
                    <td><?=$data->cco_state;?></td>
                    <td>
                        <div class="btn-group">
                            <a href="javascript:;" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="<?=BASEURL;?>user/viewLead/<?=$data->id;?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                        </div>
                   </td>
                </tr>
                <?php
                    $i++;
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php include_once('inc/footer.php')?>
