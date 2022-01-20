<?php include_once('inc/header.php');?>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit">Upload Lead</h1>
        </div>
        <div class="leadpage">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form  action="<?=BASEURL;?>administrator/createLeadFromExcel" method="POST" enctype="multipart/form-data">
                        <div class="uploadbox">
                            <i class="fa fa-upload"></i>
                            <h5>Choose your File to upload</h5>
                            <button class="btn" type="button">Select</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div> 
    </div>            
    </div>
</div>
        
<div class="modal-backdrop">
    <img src="http://markuplounge.com/bdforsalecrm/assets/user/img/200.gif">
</div> 
<?php include_once('inc/footer.php');?>

<script type="text/javascript">
    
    $(function(){
        
    });

</script>

<style type="text/css">
    
.modal-backdrop {
    background: rgba(0, 0, 0, 0.53);
}
.modal-backdrop img{
    position: absolute;
    top: 40%;
    left: 0px ;
    right: 0px;
    margin: auto;
}
</style>
				