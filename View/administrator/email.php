<?php include_once('inc/header.php'); ?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="profile" style="border-bottom:none;">
            <div class="row">
                <div class="col-md-6">
                    <canvas id="pie-chart" width="800" height="450"></canvas>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>
        <div class="leadscroll">
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
                </tr>
            </thead>
            <tbody>
               <?php
                    $i = 1;
                    $leads = Lead::all(['leadfrom' =>2]);
                    foreach($leads as $data){
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    <td><a href="<?=BASEURL;?>administrator/viewLead/<?=$data->id;?>"><?=$data->firm_name;?></a></td>
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
                </tr>
                <?php
                    $i++;}
                ?>
            </tbody>
        </table>
		</div> 
    </div>
</div>
<?php include_once('inc/footer.php'); ?>
<script src="<?=BASEURL;?>assets/lib/js/Chart.min.js">
</script>
<script>
 new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ["New leads", "Never Contacted", "Initial Contact", "No Response","Follow up","Proposal"],
      datasets: [{
        label: "Leads Status",
        backgroundColor: ["#3e95cd", "#ffcd56","#3cba9f","#ff6384","#5cb85c","#f44336"],
        data: [6,8,4,3,12,1]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Email leads status'
      }
    }
});
</script>    