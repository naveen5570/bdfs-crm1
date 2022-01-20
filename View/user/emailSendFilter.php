<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Email Form</h1>
            </div>
            <h3 style="text-align:center; color:green; padding-bottom:15px;"><?php
            if(isset($_GET['msg']))
            {
            echo $_GET['msg'];
            }
            ?></h3>
          <div class="modal_nav"><span class="close_nav">x</span><div id="ccc"></div></div>
          <?php 
		  if($emails!='')
		  {
			  ?>
          <div class="num_of_leads"><?= 'Number of Leads:'.$count ?></div>
          <?php
          }
		  else
		  {
			
		  ?>
          <div class="num_of_leads"><?= 'Number of Leads:0' ?></div>
          <?php
		  }
		  ?>
          <form role="form" id="formfield" class="myform" method="post" action="<?=BASEURL;?>user/sendLeadFilterCampaign" >
          
          <input type="hidden" name="action" value="add_form" />
          <div class="row">
         <div class="form-group col-md-6">

          <input class="form-control" type="text" name="campaign" required placeholder="Campaign Name" id="campaign_name">
          </div>
          <div class="form-group col-md-6">
          <input class="form-control" type="text" name="email_subject" required placeholder="Email Subject" id="subject" >
          </div>

          <!--<div class="form-group col-md-6">
         <input class="form-control" type="text" name="receiver_email" required placeholder="Receiver's Email">
          </div> -->
           <?php /*  ?>
          <div class="form-group">
          <textarea name="email_body"></textarea>
          </div><?php */ ?>
          
          
         
      <div class="form-group col-md-12">
          <select class="form-control" name="email_body" id="emailer">
          <option value=""><strong>Select Emailer</strong></option>
          <?php foreach($list as $list1)
          {
          ?>
          <option value="<?php echo htmlspecialchars($list1->code, ENT_QUOTES, 'UTF-8') ?>">
          <?php echo $list1->name; ?>
          </option>
          <?php
          }
          ?>
          </select>
          
         </div>
         

          </div>
          <div class="form-group">
         <input type="hidden" id="template" name="template" />
         <input type="hidden" id="count" name="count" value="<?=$count?>"/>
         <input type="hidden" value="<?php echo $emails; ?>" name="emails">
         <div class="processing_nav"><img src="<?=BASEURL?>/assets/administrator/img/200.gif" width="40"/></div>
         <input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-default" />
          </div>

          </form>




          <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Are you sure you want to submit the following details?
                <table class="table">
                    <tr>
                        <th>Campaign Name</th>
                        <td id="c_name"></td>
                    </tr>
                    <tr>
                        <th>Email Subject</th>
                        <td id="sub"></td>
                    </tr>
                    
                    <tr>
                        <th>Sent Emailer</th>
                        <td id="sent_emailer"></td>
                    </tr>
                    <tr>
                        <th>No. of people to get this emailer:</th>
                        <td id="sent_emailer1"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success success" id="submit11">Submit</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<style>
#ccc{overflow-y:auto;
overflow-x:hidden;
padding:0 5px;
width: 100%;
position:relative;
max-height:500px;
background:#fff;
}
.modal_nav{display:none; min-height:500px; width100%; padding:10px; max-width:900px; position:absolute; z-index:999; left:35%; background:#00c6d7;}
.modal_nav .close_nav {cursor:pointer; font-weight:bold; font-size:20px; top:-15px; color:#fff; left:-15px; position:absolute; z-index:1; background:#000; border-radius:30px; padding:3px 12px;}
.processing_nav {display:none;; float:left; width:100%;}
.num_of_leads {text-align:center; font-size:22px; padding-bottom:12px; color:green;}
</style>

<script>
$(document).ready(function(){
    $('#status').on('change', function(){
        var status = $(this).val();
		 var type=$('#type').val();
        if(status){
            $.ajax({
                type:'POST',
                url:'<?php echo BASEURL."user/getCount"?>',
				beforeSend: function(){$('.processing_nav').css('display','block')},
                data:{"status": status, "type": type},
				
                success:function(text){
					$('.processing_nav').css('display','none'),
					$('[name="count"]').val(text); 
                }
            }); 
        }else{
            $('[name="count"]').val(0); 
        }
    });
});
</script>
<script>
$("#emailer").change(function () {
      var selectedText2 =$("#emailer option:selected").text();
      var selectedText1=$('#emailer option:selected').val();
      $('[id="ccc"]').html(selectedText1);
         //alert("You selected :" + selectedText2 );
           $('[name="template"]').val(selectedText2);
	       $('.modal_nav').fadeIn();
	   
    });
$('.close_nav').click(function(){
$('.modal_nav').fadeOut();	
});

$("#type").change(function(){
$("#status").val($(this).find('option:first').val())	
});


$('#submitBtn').click(function() {
     $('#c_name').text($('#campaign_name').val());
     $('#sub').text($('#subject').val());
     $('#l_type').text($('#type').find('option:selected').text());
     $('#l_status').text($('#status').find('option:selected').text());
     $('#sent_emailer').text($('#emailer').find('option:selected').text());
	 $('#sent_emailer1').text($('#count').val());

});

$('#submit11').click(function(){
    //alert('submitting');
    $('#formfield').submit();
});

</script>




<?php include_once('inc/footer.php'); ?>