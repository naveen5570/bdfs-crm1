$(function(){
  //var BASEURL = 'http://bdforsale.com/';
    //var BASEURL = 'http://bdforsale.com/';
    // var BASEURL = 'http://crm.brokerdealerforsale.com/';
    var BASEURL = 'http://localhost/bdfs-crm1/';
 //deletnoty
    $("table").on("click",".deletnoty",function(){

      var url = BASEURL+"user/deletnoty";
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

    $('.datepicker').datepicker({
      autoclose: true,
      todayBtn : "linked",
      todayHighlight : true,
    });

    $('.alldatatbl').dataTable();

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
        var url = BASEURL+"user/followup";
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
            url : BASEURL+"user/loadAllLeads",
            type : 'POST'
        },
        "rowCallback": function( row, data, index ) {

            $(row).append("<td><button class='btn btn-default followupbtn' data-id='"+data[29]+"'>Followup</button></td>")
            $('td', row).css('background-color', statuscolor[data[28]]);

        }
		
		
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
        var url = BASEURL+"user/assignSelectedLeads";
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
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $('.statuschange').on('change', function() {
	  var id = this.value;
	  var leadid = $(this).data("id");

	  var url = BASEURL+"user/leadStatusChange";

          $.post(url,{'id':id,'leadid':leadid},function(o){

            if(o.result === 'success'){
              toastr['success']('Status has been change successfully.');
                setTimeout(function(){location.reload();},1000);
            }else{
              toastr['error'](o.result);
            }
         },"json");

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
        selecteddate = moment(date);
        if(selecteddate.isValid()){

          $('.workdate').data('date', selecteddate.format("YYYY-MM-DD"));
          $('.workdate').html(selecteddate.format("D MMMM YYYY"));
          var url = BASEURL+"user/getWork";
          $.post(url,{date:selecteddate.format("YYYY-MM-DD")},function(o){

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



      $('.leadstsfrm').on('change','.leadtypeselect',function (e) {
//alert('tt');
          var url = BASEURL+"/administrator/typeWiseStatus";
          var id = $(this).val();
          $.post(url,{'typeid':id},function(o){
              var html = "<option value=''>Choose Status</option>";
              if(o.result === 'success'){

                  var data = [];
                  var leadstatus = JSON.parse(o.leadstatus);

                  $(leadstatus).each(function(index,value){
                      html +="<option value='"+value.id+"'>";
                      html +=value.name;
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
                    html +="<option value='"+value.id+"'>";
                    html +=value.name;
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
                    html +="<option value='"+value.id+"'>";
                    html +=value.name;
                    html +="</option>";
                });

            }else{
                toastr['error'](o.result);
            }
            $(".leadsubsubstatusbysubstatus").html(html);
        },"json");
		
	});














	
      $('.sendArticleBtn').on('click', function() {
       var id = $('.selectedArticle').val();
       var leadid = $('.selectedArticle').data("id");

       var url = BASEURL+"user/sendArticletoLead";

              $.post(url,{'id':id,'leadid':leadid},function(o){

                if(o.result === 'success'){
                   toastr['success']('Article Send successfully.');
                    setTimeout(function(){location.reload();},1000);
                }else{
                  toastr['error'](o.result);
                }
             },"json");

     });












// User Lead Assign


$('.userchange').on('change', function() {
		
		
	  var id1 = $(this).val();
	  var id = id1.join(',');
	  var leadid = $(this).data("id");

	  var url = BASEURL+"user/assignUserLead";

          $.post(url,{'id':id,'leadid':leadid},function(o){

            if(o.result === 'success'){
              toastr['success']('Assign has been change successfully.');
                setTimeout(function(){location.reload();},5000);
            }else{
              toastr['error'](o.result);
            }
         },"json");

	});















$(document).on("click","#search_email",function(){
 var email = $("#email").val();
 //alert(email);
 var url = BASEURL+'user/getLeadViaEmail'; 
 $.post(url,{'email':email},function(o){
            
            if(o.result === 'success'){
              
$('#lookUp_result').show();                
                
$("#get_result").html(o.lead);
$("#request_access").html('<a class="btn btn-success cu" href="'+BASEURL+'user/requestAccess/'+o.id+'">Request Access</a>');
                

            }else{
                toastr['error'](o.result);
            }
            
        },"json");
 });


});


