</div>
   
    <script src="<?=BASEURL;?>assets/lib/js/jquery.min.js"></script>
    <script src="<?=BASEURL;?>assets/lib/js/bootstrap.min.js"></script>
    <script src="<?=BASEURL;?>assets/lib/js/jquery.dataTables.js"></script>
    <script src="<?=BASEURL;?>assets/lib/js/toastr.min.js"></script>
    <script src="<?=BASEURL;?>assets/lib/js/metisMenu.min.js"></script>
    <script src="<?=BASEURL;?>assets/user/js/app.js"></script>
    
<script>
          $(function(){
             toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-bottom-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
           
            <?php 
             if(isset($_SESSION['msg']) && isset($_SESSION['title'])){ ?>
              toastr["<?=$_SESSION['title'];?>"]("<?=$_SESSION['msg'];?>","<?=$_SESSION['title'];?>");
            <?php    
                unset($_SESSION['msg']);
                unset($_SESSION['title']);
             }
             
          ?>

          });
</script>
    
    </body>
</html>



