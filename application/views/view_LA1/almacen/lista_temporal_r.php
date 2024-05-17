<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="30%">Código</th>
            <th class="text-center" width="30%">Descripción</th> 
            <th class="text-center" width="30%">Ingresado</th>
            <th class="text-center" width="10%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_temporal as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['ingresado']; ?></td>
                <td>
                    <img title="Eliminar" onclick="Delete_Temporal_Retirar_Producto('<?php echo $list['id_temporal']; ?>')"
                    src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer;"/>
                </td>                                     
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

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 3 ]
                }
            ]
        } );
    });
</script>