<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="10%">Tipo</th> 
            <th class="text-center" width="10%">Sub-Tipo</th>
            <th class="text-center" width="16%">Tipo Producto</th>
            <th class="text-center" width="8%">Talla/Ref</th>
            <th class="text-center" width="8%" title="Disponible Encomendar">Disp. Enc.</th>
            <th class="text-center" width="7%" title="Aviso (con stock Total)">Aviso</th>
            <th class="text-center" width="7%">Activo de</th>
            <th class="text-center" width="7%">A</th>
            <th class="text-center" width="7%" title="Precio Venta">P. Venta</th>
            <th class="text-center" width="7%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead> 

    <tbody >
        <?php foreach($list_producto as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['nom_subtipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['v_disponible_encomendar']; ?></td>                
                <td><?php echo $list['aviso']; ?></td>     
                <td><?php echo $list['activo_de']; ?></td>     
                <td><?php echo $list['a']; ?></td>                
                <td class="text-right"><?php echo "s/.".$list['precio_venta']; ?></td>                
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>                         
                <td>
                    <img title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('Laleli/Modal_Update_Producto') ?>/<?php echo $list['id_producto']; ?>" 
                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>

                    <img title="Eliminar" onclick="Delete_Producto('<?php echo $list['id_producto']; ?>')"
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
            order: [[10,"asc"],[0,"asc"]], 
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 11 ]
                }
            ]
        } );
    });
</script>