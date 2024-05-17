<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th>
            <th class="text-center" width="30%">De</th>
            <th class="text-center" width="30%">Para</th> 
            <th class="text-center" width="10%">Producto</th> 
            <th class="text-center" width="10%">Cantidad</th> 
            <th class="text-center" width="10%">Fecha</th>
            <th class="text-center" width="10%">Usuario</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_informe_transferencia as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td><?php echo $list['fec_movimiento']; ?></td>
                <td class="text-left"><?php echo $list['de']; ?></td>
                <td class="text-left"><?php echo $list['para']; ?></td>
                <td class="text-left"><?php echo $list['cod_producto']; ?></td>
                <td><?php echo $list['cantidad']; ?></td>
                <td><?php echo $list['fecha']; ?></td> 
                <td class="text-left"><?php echo $list['usuario']; ?></td>
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
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>