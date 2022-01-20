     </div>
	
<script src="<?=BASEURL;?>assets/lib/js/jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/moment.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/bootstrap.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/bootstrap-datepicker.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/jquery.dataTables.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/toastr.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/js/select2.min.js"></script>

<script src="<?=BASEURL;?>assets/lib/js/metisMenu.min.js"></script>
<script src="<?=BASEURL;?>assets/lib/tinymce/tinymce.min.js"></script>

<script src="<?=BASEURL;?>assets/administrator/js/custom.js"></script>
<script src="<?=BASEURL;?>assets/administrator/js/classie.js"></script>
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
        

	<script>
$(document).ready(function() {
    $('#example').DataTable( {
        initComplete: function () {
            this.api().columns('.tt').every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.unique().sort().each( function () {
                    select.append( '<option value="not opened">not opened</option><option value="opened">opened</option><option value="clicked">clicked</option>' )
                } );
            } );
        }
    } );
} );
</script> 	
</body>
</html>