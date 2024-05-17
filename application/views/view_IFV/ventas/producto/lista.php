<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="5%" title="Código">Cod.</th>
            <th class="text-center" width="5%">Año</th>  
            <th class="text-center" width="12%">Tipo</th>
            <th class="text-center" width="16%">Nombre Sistema</th>
            <th class="text-center" width="6%">Fecha Ini.</th>
            <th class="text-center" width="6%">Fecha Fin</th>
            <th class="text-center" width="6%">Monto</th>
            <th class="text-center" width="6%">Descuento</th>
            <th class="text-center" width="6%">Total</th>  
            <th class="text-center" width="5%" title="Validado">Valid.</th>
            <th class="text-center" width="5%" title="Código">Cod.</th>
            <th class="text-center" width="6%">Asignados</th>
            <th class="text-center" width="6%">Ventas</th>  
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="4%"></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_producto_venta as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_producto']; ?></td>
                <td><?php echo $list['nom_anio']; ?></td>  
                <td class="text-left"><?php echo $list['cod_tipo']; ?></td>
                <td class="text-left"><?php echo $list['nom_sistema']; ?></td>
                <td><?php echo $list['fec_ini']; ?></td>
                <td><?php echo $list['fec_fin']; ?></td> 
                <td class="text-right"><?php echo "s./ ".$list['monto']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['descuento']; ?></td>
                <td class="text-right"><?php echo "s./ ".number_format(($list['monto']-$list['descuento']),2); ?></td>
                <td><?php echo $list['validado']; ?></td>
                <td><?php echo $list['codigo']; ?></td>  
                <td><?php echo $list['ventas']; ?></td>  
                <td><?php echo $list['ventas']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>               
                <td>
                    <a title="Detalle" href="<?= site_url('AppIFV/Detalle_Producto_Venta') ?>/<?php echo $list['id_producto']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png">
                    </a> 

                    <?php if($list['id_producto']!=17){ ?>
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                            <a title="Eliminar" onclick="Delete_Producto_Venta('<?php echo $list['id_producto']; ?>')">
                                <img src="<?= base_url() ?>template/img/eliminar.png">
                            </a>
                        <?php } ?>
                    <?php } ?>
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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 14 ]
                }
            ]
        } );
    });
</script>