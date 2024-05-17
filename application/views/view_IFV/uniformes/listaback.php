<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="8%" class="text-center" title="Apellido Paterno">A. Paterno</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_matriculado as $list){?>
            <tr class="even pointer text-center" <?php if($list['Alumno']=="Bloqueado"){ ?> style="background-color:#FFF3DF;" <?php } ?>>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table=$('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    } );
</script>
