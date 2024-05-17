<table class="table table-hover table-bordered table-striped" id="example_modal" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Código</th> 
            <th class="text-center">Descripción</th> 
            <th class="text-center">Talla/Ref</th> 
            <th class="text-center">Precio Venta</th>
            <th class="text-center">Stock</th>
            <th class="text-center"></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_producto as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['precio_venta']; ?></td> 
                <td><?php echo $list['stock']; ?></td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" onclick="Insert_Modal_Retirar_Producto_Almacen('<?php echo $list['codigo']; ?>');">Añadir</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_modal thead tr').clone(true).appendTo( '#example_modal thead' );
        $('#example_modal thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_modal').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 10,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    });
</script>