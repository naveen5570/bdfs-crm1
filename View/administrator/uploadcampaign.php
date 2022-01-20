<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Upload Campaign Lead</h1>
        </div>
        <div class="leadpage">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form  action="" method="POST" id="myfrmsubmit" enctype="multipart/form-data">
                        <div class="uploadbox">
                            <i class="fa fa-upload"></i>
                            <h5>Choose your File to upload</h5>
                            <button class="btn" type="button"><input type="file" name="leadexcelfile" class="leadexcelfile" accept=".xls,.xlsx" >Select</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div> 
    </div>            
    </div>
</div>

<div id="classloadpg">    
<div class="myclasslod">
    <img src="<?=BASEURL;?>/assets/user/img/200.gif">
</div> 
</div>
<?php include_once('inc/footer.php');?>
<style type="text/css">
#classloadpg{
    display: none;
}
.myclasslod{
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    background-color: rgba(0, 0, 0, 0.44);
}
.myclasslod img{
    position: absolute;
    top: 40%;
    left: 0px ;
    right: 0px;
    margin: auto;
}
</style>
<script type="text/javascript">
    
    $(function(){
        
        $('.leadexcelfile').change(function(){
//alert('test');
            var filename = $('.leadexcelfile').val();
            if(filename != ''){
                var ext = filename.split('.').pop().toLowerCase();
                if($.inArray(ext, ['xls','xlsx']) == -1) {
                    toastr['error']("Invalid Extension!");
                }else{ 
                    $("#classloadpg").css("display", "block");
                    setTimeout(function(){ 
                        url = "<?=BASEURL;?>administrator/createCampaignFromExcel";
                        var formData = new FormData($('#myfrmsubmit')[0]);
                        
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: formData,
                            async: false,
                            success: function (o) {
                                o = JSON.parse(o);
                                if(o.result == 'success'){
                                    window.location.href = "<?=BASEURL;?>administrator/leads";
                                }else{
                                    console.log("data uploded");
                                    // toastr['error'](o.result);
                                    window.location.href = window.location.href;
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }, 50);
                 
                    
                }
            }
        });
    });

</script>




				