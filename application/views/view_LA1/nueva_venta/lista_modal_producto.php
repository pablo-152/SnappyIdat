<a type="button" onclick="Volver_Producto_Nueva_Venta();">
    <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
</a> 

<table class="table table-hover table-bordered table-striped" id="example_modal" width="100%" style="margin-top: 5px;">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Código</th>
            <th class="text-center">Descripción</th> 
            <th class="text-center">Talla/Ref</th>
            <th class="text-center">Precio Venta</th>
            <th class="text-center">Stock</th>
            <th class="text-center"></th> 
            <th class="text-center">Cantidad</th>
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
                    <?php if($list['stock']>0){ ?> 
                        <button type="button" class="btn btn-primary btn-sm" onclick="Insert_Modal_Producto_Nueva_Venta('<?php echo $list['codigo']; ?>','<?php echo $list['id_tipo_producto']; ?>');">Añadir</button>
                    <?php }else{ ?>
                        <button type="button" class="btn btn-primary btn-sm" onclick="Insert_Modal_Producto_Nueva_Venta('<?php echo $list['codigo']; ?>','<?php echo $list['id_tipo_producto']; ?>');">Encomendar</button>
                    <?php } ?>
                </td>
                <td><?php echo $list['cantidad']; ?></td>
                <td>
                    <?php if($list['cantidad']>0){ ?>
                        <a title="Eliminar">
                            <img onclick="Delete_Modal_Producto_Nueva_Venta('<?php echo $list['codigo']; ?>','<?php echo $list['id_tipo_producto']; ?>')" src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php } ?>
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
                    'aTargets' : [ 5,7 ]
                }
            ]
        } );
    });
</script>