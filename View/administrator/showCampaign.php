<?php include_once('inc/header.php');?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="creoption">
            <h1 class="headtit"><?php
			foreach($list as $head)
			{}
			echo $head->campaign;
			?></h1>
            <a href="<?=BASEURL;?>administrator/emailer/" type="button" class="btn"><i class="fa fa-plus"></i> Add New Emailer</a>
        </div>
        <div class="leadpage">
        
        <table id="example" class="display" style="width:100%">
        <thead>
                <tr>
                    <th>S.No</th>
                    
                    <th>Subject</th>
                    <th>CEO Name</th>
                    <th>CEO Email</th>
                    <th  class="tt">status</th>
                </tr>
            </thead>
       <tbody>
            
               <?php
                $i = 1;
                foreach($list as $data){
                    
                ?>
                <tr class="gc_row row<?=$data->id;?>">
                    <td><?=$i;?></td>
                    
                    <td style="text-align:center"><?=$data->subject;?></td>
                    <td style="text-align:center"><?=$data->ceo_name;?></td>
                    <td style="text-align:center"><?=$data->email_id;?></td>
                    <td style="text-align:center"><?=$data->status;?></td>
                </tr>
                <?php $i++;}?>
            </tbody>
        <tfoot>
            <tr>
                    <th>S.No</th>
                    
                    <th>Subject</th>
                    <th>CEO Name</th>
                    <th>CEO Email</th>
                    <th>status</th>
                </tr>
        </tfoot>
    </table>
        
    </div> 
    <br/>
    
    </div>            
    </div>
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
               
<?php include_once('inc/footer.php');?>