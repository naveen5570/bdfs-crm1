$(function(){
//var BASEURL = 'http://bdforsale.com/';
var BASEURL = 'http://localhost/bdfs-crm1/';
// var BASEURL = 'http://crm.brokerdealerforsale.com/';
// var BASEURL = 'http://localhost/crm/';


	function timeRefresh(timeoutPeriod) {
				setTimeout("location.reload(true);", timeoutPeriod);
			}
		
		
$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    
    $('.datepicker').datepicker({
      autoclose: true,
      todayBtn : "linked",
      todayHighlight : true,
    });

$(".mainmenu").click(function(){
  	var a = $(this).attr("class");

  	if(a != "mainmenu active"){
  		$(".mainmenu span").removeClass("fa-caret-down");
  		$(".mainmenu span").addClass("fa-caret-right");
  		$(this).find("span").removeClass("fa-caret-right");
  		$(this).find("span").addClass("fa-caret-down");
  		$(".mainmenu").find("ul").slideUp();
  	    $(".mainmenu").removeClass("active");
  		$(this).find("ul").slideDown();
  	    $(this).addClass("active");
  	}
  	if(a == "mainmenu active"){

  	    $(this).find("span").addClass("fa-caret-right");
  		$(this).find("span").removeClass("fa-caret-down");
  		$(this).find("ul").slideToggle();
  	    $(this).removeClass("active");

  	}

  });
    $('.alldatatbl').dataTable({
		"processing": true,
        "serverSide": true,
        "ajax": "http://localhost/server_side.php" //ajax source

		},
		
		);
		
	$('.alldatatbll').dataTable();
    //$(".nav-tabs li:first-child").addClass('active');
    //$(".tab-pane:first-child").addClass('active');
    $('table').on('click','.followupbtn',function(){
        id = $(this).data('id');
        $('#followup_frm #followup_leadid').val(id);
        $('#followup_frm [name="msg"]').val("");
        $('#followup_frm [name="reminddate"]').val("");
        $('#followup_modal').modal('show');
    });

    $('#followup_frm').submit(function(e){
        e.preventDefault();
        data = $( this ).serialize();
        var url = BASEURL+"administrator/followup";
        $.post(url,data,function(o){

            if(o.result === 'success'){
                toastr['success']('Follow Reminder Created Successfully.');
                $('#followup_modal').modal('hide');
            }else{
                toastr['error'](o.result);
            }

        },"json");
    });

    $('#loadleaddatatable').DataTable({
		    
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        "ajax": {
            url : BASEURL+"administrator/loadAllLeads",
            type : 'POST'
        },
        "rowCallback": function( row, data, index ) {

            $(row).append("<td><button class='btn btn-default followupbtn' data-id='"+data[30]+"'>Followup</button></td>")
            $('td', row).css('background-color', statuscolor[data[29]]);

        },
		
		"dom": 'lBfrtip',
    lengthMenu: [[10, 25, 50, 100, 500, 1000, 2000, 3000, 10000], [10, 25, 50, 100, 500, 1000, 2000, 3000, 'All']],
        buttons : [ {
            extend : 'excel',
            text : 'Export to Excel',
            title : 'Leads',
            exportOptions : {
columns: [1,3,4,5,6,7,8,9,22,23,24,25,26,27,28,29,30,31],
                modifier : {
                    
                    page : 5000,      // 'all',     'current'
                    search : 'applied',
                    order: 'applied'     // 'none',    'applied', 'removed'
                },
                format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==1){
                                return 'Lead Id';
                                }
                                else if(columnIdx==3){
                                return 'Company Name';
                                }
                                else if(columnIdx==4){
                                return 'Company CRD';
                                }
								else if(columnIdx==7){
								return 'Lead Status';	
								}
								else if(columnIdx==8){
								return 'Lead Substatus';	
								}
								else if(columnIdx==9){
								return 'Lead Subsubstatus';	
								}
                                else if(columnIdx==5){
                                return 'Name';
                                }
                                else if(columnIdx==6){
                                return 'Email';
                                }
                                else if(columnIdx==22){
                                return 'Address 1';
                                }
                                else if(columnIdx==23){
                                return 'Address 2';
                                }
                                else if(columnIdx==24){
                                return 'City';
                                }
                                else if(columnIdx==25){
                                return 'State';
                                }
                                else if(columnIdx==26){
                                return 'Zipcode';
                                }
                                else if(columnIdx==27){
                                return 'Phone';
                                }
                                else if(columnIdx==28){
                                return 'Website';
                                }
                                else if(columnIdx==29){
                                return 'Lead From';
                                }
								else if(columnIdx==30){
                                return 'Verification Status';
                                }
								else if(columnIdx==31){
                                return 'Last Updated On';
                                }
                            }
                        }
            }
        } ]
			
    });
	
	
    $('#loadleaddatatable thead tr th:last-child').after("<th></th>");

    $('.selectall_leads').click(function(){
        $('.leads_checkbox').each(function(index){
            // $(this).prop('checked','checked');
            $(this).prop('checked',true);
        });
        $('.actionbtns').css('display','inline-block');
    });
    $('.selectnone_leads').click(function(){
        $('.leads_checkbox').each(function(index){
            // $(this).removeAttr('checked');
            $(this).prop('checked',false);
        });
        $('.actionbtns').css('display','none');
    });
    $('table').on('click','.leads_checkbox',function(index){
        var checkedleads = 0;
        $('.leads_checkbox').each(function(index){
            // $(this).prop('checked','checked');
            if($(this).prop('checked') == true){
              checkedleads = checkedleads+1;
            }
        });
        if(checkedleads > 0){
          $('.actionbtns').css('display','inline-block');
        }
    });

    $('.assign_btn').click(function(){
      var userid = $('.assignleadsuser').val();
	  //alert('test'+userid);
	  userid=userid.join(',');
	  //alert(userid);
      var leadsid = [];
      $('#multipalassign').modal('hide');
      $('.leads_checkbox').each(function(index){
          // $(this).prop('checked','checked');
          if($(this).prop('checked') == true){
            leadsid.push($(this).val());
          }
      });
      if(leadsid.length > 0){
        var url = BASEURL+"administrator/assignSelectedLeads";
        $.post(url,{'userid':userid,'leadsid':leadsid},function(o){

            if(o.result === 'success'){
            	$('.leads_checkbox').each(function(index){
                    // $(this).removeAttr('checked');
                    if($(this).prop('checked') == true){
                      //$(this).parent('td').next().next().html(o.assignedUser);
                    }
                    $(this).prop('checked',false);
                });
                $('.actionbtns').css('display','none');
                toastr['success']('Leads Assign successfully.');
					timeRefresh(5000);
            }else{
                toastr['error'](o.result);
            }

        },"json");
      }else{
        toastr['error']("select atleast one lead to assign");

      }
    });

    $(".deleteUser").click(function(){

        var url = BASEURL+"administrator/deleteUser";
        var flag = confirm("Are you sure you wann delete this user");
        if(flag == true){
            var id = $(this).data("id");
            $.post(url,{'id':id},function(o){

                if(o.result === 'success'){
                    toastr['success']('User has been deleted successfully.');
                    $(".row"+id).remove();
                }else{
                    toastr['error'](o.result);
                }

            },"json");
        }

    });
	//delete Lead
	$(".deletesigLead").click(function(){
$('.del_modal_nav').fadeOut();
        var url = BASEURL+"administrator/deletesigLead";
       /* var flag = confirm("Are you sure you wann delete this Lead");
        if(flag == true){
            var id = $(this).data("id");
            $.post(url,{'id':id},function(o){

                if(o.result === 'success'){
                    toastr['success']('Lead has been deleted successfully.');
                    var reurl = BASEURL+"administrator/leads/"
                    setTimeout(function(){ window.location.href= reurl; }, 2000);
                }else{
                    toastr['error'](o.result);
                }

            },"json");
        }
*/

var id = $(this).data("id");
            $.post(url,{'id':id},function(o){

                if(o.result === 'success'){
                    toastr['success']('Lead has been deleted successfully.');
                    var reurl = BASEURL+"administrator/leads/"
                    setTimeout(function(){ window.location.href= reurl; }, 2000);
                }else{
                    toastr['error'](o.result);
                }

            },"json");
        
    });



	//deleteindtry
   $("table").on("click",".deleteindtry",function(){

      var url = BASEURL+"administrator/deleteindtry";
      var flag = confirm("Are you sure you wanna delete this Industry?");

      if(flag == true){

          var id = $(this).data("id");
          $.post(url,{'id':id},function(o){


            if(o.result === 'success'){
              toastr['success']('Industry has been deleted successfully.');
              $(".row"+id).remove();
            }else{
              toastr['error'](o.result);
            }
         },"json");
      }
   });

	//deleteStatus
   $("table").on("click",".deleteStatus",function(){

      var url = BASEURL+"administrator/deleteStatus";
      var flag = confirm("Are you sure you wanna delete this Status?");

      if(flag == true){

          var id = $(this).data("id");
          $.post(url,{'id':id},function(o){


            if(o.result === 'success'){
              toastr['success']('Status has been deleted successfully.');
              $(".row"+id).remove();
            }else{
              toastr['error'](o.result);
            }
         },"json");
      }
   });
   
   
   
   
   //deleteSubstatus
   $("table").on("click",".deleteSubstatus",function(){
      var url = BASEURL+"administrator/deleteSubstatus";
      var flag = confirm("Are you sure you wanna delete this Substatus?");
      if(flag == true){
          var id = $(this).data("id");
          $.post(url,{'id':id},function(o){
            if(o.result === 'success'){
              toastr['success']('Substatus has been deleted successfully.');
              $(".row"+id).remove();
            }else{
              toastr['error'](o.result);
            }
         },"json");
      }
   });
   
 
 
 
 
 
 
 
 
 
 
 
 
 //deleteSubsubstatus
   $("table").on("click",".deleteSubsubstatus",function(){
      var url = BASEURL+"administrator/deleteSubsubstatus";
      var flag = confirm("Are you sure you wanna delete this Substatus?");
      if(flag == true){
          var id = $(this).data("id");
          $.post(url,{'id':id},function(o){
            if(o.result === 'success'){
              toastr['success']('Sub-substatus has been deleted successfully.');
              $(".row"+id).remove();
            }else{
              toastr['error'](o.result);
            }
         },"json");
      }
   });  
   
   
   
   

	$('.userchange').on('change', function() {
		
		
	  var id1 = $(this).val();
	  var id = id1.join(',');
	  var leadid = $(this).data("id");

	  var url = BASEURL+"administrator/assignUserLead";

          $.post(url,{'id':id,'leadid':leadid},function(o){

            if(o.result === 'success'){
              toastr['success']('Assign has been change successfully.');
                setTimeout(function(){location.reload();},5000);
            }else{
              toastr['error'](o.result);
            }
         },"json");

	});

	$('.statuschange').on('change', function() {
	  var id = this.value;
	  var leadid = $(this).data("id");

	  var url = BASEURL+"administrator/leadStatusChange";

          $.post(url,{'id':id,'leadid':leadid},function(o){

            if(o.result === 'success'){
              toastr['success']('Status has been change successfully.');
                setTimeout(function(){location.reload();},1000);
            }else{
              toastr['error'](o.result);
            }
         },"json");

	});
	
	
	$('.substatuschange').on('change', function() {
	  var id = this.value;
	  var leadid = $(this).data("id");

	  var url = BASEURL+"administrator/leadSubstatusChange";

          $.post(url,{'id':id,'leadid':leadid},function(o){

            if(o.result === 'success'){
              toastr['success']('Substatus has been change successfully.');
                setTimeout(function(){location.reload();},1000);
            }else{
              toastr['error'](o.result);
            }
         },"json");

	});
	
	

     $(".editLeadsData").click(function(){
        var data = $(this).data("id");
        var name = $(this).data("name");

        $(".getvalFrmdta").val(name);
        $(".getvalFrmid").val(data);
    });




    $('.leadstsfrm').on('change','.leadtypeselect',function (e) {
     

        var url = BASEURL+"/administrator/typeWiseStatus";
        var id = $(this).val();
        $.post(url,{'typeid':id},function(o){
            var html = "<option value=''>Choose Status</option>";
            if(o.result === 'success'){
              
                var data = [];
                var leadstatus = JSON.parse(o.leadstatus);

                $(leadstatus).each(function(index,value){
                  html +="<option value='"+value.id+"' >";
                  //html +=value.name+='=>(';
                  html +=value.name
                  //html +=value.description+=')';
                  html +="</option>";
                });

            }else{
                toastr['error'](o.result);
            }
            $(".leadstatusbytype").html(html);
        },"json");

    });
	
	





	
	
	
	$('.leadstsfrm').on('change','.leadstatusbytype',function(e){
		//alert($(this).val());
		var url = BASEURL+"/administrator/statusWiseSubstatus";
		var id = $(this).val();
		
		$.post(url,{'typeid':id},function(o){
		var html = "<option value=''>Choose Status</option>";
            if(o.result === 'success'){
                var data = [];
                var leadsubstatus = JSON.parse(o.leadsubstatus);

                $(leadsubstatus).each(function(index,value){
                    html +="<option value='"+value.id+"'style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>";
                    html +=value.name+='=>(';
                    
                    html +=value.description+=')';
                    html +="</option>";
                });

            }else{
                toastr['error'](o.result);
            }
            $(".leadsubstatusbystatus").html(html);
        },"json");
		
	});
	
	
	
	
	$('.leadstsfrm').on('change','.leadsubstatusbystatus',function(e){
		//alert($(this).val());
		
		var url = BASEURL+"/administrator/substatusWiseSubsubstatus";
		var id = $(this).val();
		
		$.post(url,{'typeid':id},function(o){
		var html = "<option value=''>Choose Status</option>";
            if(o.result === 'success'){
                var data = [];
                var leadsubsubstatus = JSON.parse(o.leadsubsubstatus);

                $(leadsubsubstatus).each(function(index,value){
                  html +="<option value='"+value.id+"' style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>";
                  html +=value.name+='=>(';
                 
                  html +=value.description+=')';
                  html +="</option>";
                });

            }else{
                toastr['error'](o.result);
            }
            $(".leadsubsubstatusbysubstatus").html(html);
        },"json");
		
	});	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$('#leadType').change(function(){
    //alert($(this).val());
	
	
		var url = BASEURL+"/administrator/typeWiseStatus";
		var id = $(this).val();
		
		$.post(url,{'typeid':id},function(o){
		var html='';
            if(o.result === 'success'){
				
				var j = 2;
var ww=500;
for(j;j<=5;j++)
{
var ww = ww-80;
$('#tt'+j).css('width', ww);		
}
                var data = [];
                var leadstatus = JSON.parse(o.leadstatus);
				//var dd = JSON.parse(o.lead_count);
				//alert('test=>'+dd);
var i=1;
var ww=500;
var colors = ["#d82c35", "#22ac32", "#1b6197", "#588341", "#b77c30", "#2d26c5", "#878b12", "#232a20", "#467fff", "#de45d5"];
$(leadstatus).each(function(index,value){
var status_value = value.name;
html +='<li data-item="'+i+'" id="tt'+i+'"><a href="'+BASEURL+'administrator/dashboard/'+status_value.replace(/ /g, "_")+'/'+id+'">'+value.name+'</a></li>';
var test= ww-(60*i);
var random11 = colors[Math.floor(Math.random()*colors.length)];
html+="<script>$('#tt"+i+"').css('width', "+test+"); $('#tt"+i+"').css('background', '"+random11+"');</script>";
                    //html +="</option>";
					
					i=i+1;
					colors.splice(colors.indexOf(random11), 1 );
                });

            }else{
                toastr['error'](o.result);
            }
            $("#statusContainer").html(html);
        },"json");
		

	});
	
	
	

    
	
	
	$('.leadsentmail').click(function () {

        var mailid = $(this).data('mail');
        $('#SendMail #emailforsentmail').val(mailid);
        $('#SendMail').modal();
    });

 //deletnoty
    $("table").on("click",".deletnoty",function(){

      var url = BASEURL+"administrator/deletnoty";
      var flag = confirm("Are you sure you wanna delete this notification?");

      if(flag == true){

          var id = $(this).data("id");
          $.post(url,{'id':id},function(o){


            if(o.result === 'success'){
              toastr['success']('Notification has been deleted successfully.');
              $(".row"+id).remove();
                setTimeout(function(){ location.reload(); }, 5000);
            }else{
              toastr['error'](o.result);
            }
         },"json");
      }
   });


   $('.previousdate').click(function(e){
       e.preventDefault();
       date = $('.workdate').data('date');
       currentdate = moment(date);
       if(currentdate.isValid()){
         previousdate = currentdate.subtract(1, 'days');

	 $('.selecteddate').datepicker('update',previousdate.format("MM/DD/YYYY"));
         $('.workdate').data('date', previousdate.format("YYYY-MM-DD"));
         $('.workdate').html(previousdate.format("D MMMM YYYY"));
         $( ".selecteddate" ).trigger( "change" );
       }else{
         toastr['error']("invalid date");
       }
   });

   $('.nextdate').click(function(e){
       e.preventDefault();
       date = $('.workdate').data('date');
       currentdate = moment(date);
       if(currentdate.isValid()){
         nextdate = currentdate.add(1, 'days');

         $('.selecteddate').datepicker('update',nextdate.format("MM/DD/YYYY"));
         $('.workdate').data('date', nextdate.format("YYYY-MM-DD"));
         $('.workdate').html(nextdate.format("D MMMM YYYY"));
         $( ".selecteddate" ).trigger( "change" );
       }else{
         toastr['error']("invalid date");
       }
     });

     $('.selecteddate').change(function(e){
         e.preventDefault();
         date = $('.selecteddate').val();
         user = $('.selecteduser').val();
         selecteddate = moment(date);
         if(selecteddate.isValid()){

           $('.workdate').data('date', selecteddate.format("YYYY-MM-DD"));
           $('.workdate').html(selecteddate.format("D MMMM YYYY"));
           var url = BASEURL+"administrator/getWork";
           $.post(url,{date:selecteddate.format("YYYY-MM-DD"), user:user},function(o){

               if(o.result === 'success'){
                   $('.notificationcountlist').html(o.notificationlist);
               }else{
                   toastr['error'](o.result);
               }

           },"json");
         }else{
           toastr['error']("invalid date");
         }
       });

       $('.selecteduser').change(function(e){
           e.preventDefault();
           date = $('.workdate').data('date');
           user = $('.selecteduser').val();
           selecteddate = moment(date);
           if(selecteddate.isValid()){

             $('.selecteddate').datepicker('update',selecteddate.format("MM/DD/YYYY"));
             $('.workdate').data('date', selecteddate.format("YYYY-MM-DD"));
             $('.workdate').html(selecteddate.format("D MMMM YYYY"));
             var url = BASEURL+"administrator/getWork";
             $.post(url,{date:selecteddate.format("YYYY-MM-DD"), user:user},function(o){

                 if(o.result === 'success'){
                     $('.notificationcountlist').html(o.notificationlist);
                 }else{
                     toastr['error'](o.result);
                 }

             },"json");
           }else{
             toastr['error']("invalid date");
           }
         });
         
         
         $(".deleteArticle").click(function(){

             var url = BASEURL+"administrator/deleteArticle";
             var flag = confirm("Are you sure you wann delete this Article");
             if(flag == true){
                 var id = $(this).data("id");
                 $.post(url,{'id':id},function(o){

                     if(o.result === 'success'){
                         toastr['success']('Article has been deleted successfully.');
                         $(".row"+id).remove();
                     }else{
                         toastr['error'](o.result);
                     }

                 },"json");
             }

         });

         $('.sendArticleBtn').on('click', function() {
       	  var id = $('.selectedArticle').val();
       	  var leadid = $('.selectedArticle').data("id");

       	  var url = BASEURL+"administrator/sendArticletoLead";

                 $.post(url,{'id':id,'leadid':leadid},function(o){

                   if(o.result === 'success'){
                      toastr['success']('Article Send successfully.');
                       setTimeout(function(){location.reload();},1000);
                   }else{
                     toastr['error'](o.result);
                   }
                },"json");

       	});
       	
/*
    $(document).ready(function(){
   $('body').bind("cut copy",function(e) {
      e.preventDefault();
   });


});
	 $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });

*/
});
