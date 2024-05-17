<table class="table table-hover table-bordered table-striped" id="example_compra" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center">Orden</th>
            <th class="text-center" width="40%">Producto</th>
            <th class="text-center" width="10%">Precio</th>
            <th class="text-center" width="10%">Cantidad</th>
            <th class="text-center" width="10%">Total</th>
            <th class="text-center" width="10%">Recibo Electrónico</th>
            <th class="text-center" width="10%">Fecha de Pago</th>
            <th class="text-center" width="10%">Efectuado Por</th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_compra as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['cod_producto']; ?></td>
                <td class="text-right"><?php echo "s/. ".$list['precio']; ?></td>
                <td><?php echo $list['cantidad']; ?></td>
                <td class="text-right"><?php echo "s/. ".$list['total']; ?></td> 
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['fecha_pago']; ?></td> 
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>  
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $(document).ready(function() {
        $('#example_compra thead tr').clone(true).appendTo( '#example_compra thead' );
        $('#example_compra thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_compra').DataTable( {
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 7 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>