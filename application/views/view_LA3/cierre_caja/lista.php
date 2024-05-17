<table class="table table-hover table-bordered table-striped" id="example" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Fecha</th> 
            <th class="text-center" width="8%">Vendedor</th> 
            <th class="text-center" width="6%">Caja</th>
            <th class="text-center" width="9%">Saldo Automático</th> 
            <th class="text-center" width="9%">Monto Ent.</th>  
            <th class="text-center" width="8%">Productos</th> 
            <th class="text-center" width="9%">Dif.</th>
            <th class="text-center" width="10%">Recibe</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="10%">Usuario</th>
            <th class="text-center" width="14%">Cofre</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead> 

    <tbody>
        <?php foreach($list_cierre_caja as $list){ ?>                                            
            <tr class="even pointer text-center" <?php if($list['cerrada']==0 && $list['estado']==2){ echo "style='background-color:#E2F0D9;'"; } ?>>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['cod_vendedor']; ?></td>
                <td><?php echo $list['caja']; ?></td>
                <td class="text-right" <?php if($list['saldo_automatico']<0){ echo "style='color:red;'"; } ?>><?php echo "s/. ".$list['saldo_automatico']; ?></td> 
                <td class="text-right" <?php if($list['monto_entregado']<0){ echo "style='color:red;'"; } ?>><?php echo "s/. ".$list['monto_entregado']; ?></td>
                <td><?php echo $list['productos']; ?></td>
                <td class="text-right" <?php if($list['diferencia']!=0){ echo "style='background-color:#C00000;color:#FFF'"; } ?>><?php echo "s/. ".$list['diferencia']; ?></td> 
                <td class="text-left"><?php echo $list['cod_entrega']; ?></td>
                <td><?php echo $list['fecha_registro']; ?></td>
                <td class="text-left"><?php echo $list['cod_registro']; ?></td>
                <td><?php echo $list['cofre']; ?></td>        
                <td><span class="badge" style="background:<?php echo $list['color_estado']; ?>;font-size:13px;"><?php echo $list['nom_estado']; ?></span></td>  
                <td>
                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85 || 
                    $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_nivel']==12){ ?>
                        <a title="Más Información" href="<?= site_url('Laleli3/Detalle_Cierre_Caja') ?>/<?php echo $list['id_cierre_caja']; ?>">
                            <img src="<?= base_url() ?>template/img/ver.png"/>
                        </a>
                    <?php } ?>

                    <a title="Documento" href="<?= site_url('Laleli3/Pdf_Cierre_Caja') ?>/<?php echo $list['id_cierre_caja']; ?>" target="_blank">
                        <img src="<?= base_url() ?>template/img/icono_impresora.png">
                    </a>

                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a title="Eliminar" onclick="Delete_Cierre_Caja('<?php echo $list['id_cierre_caja']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
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
                    'aTargets' : [ 12 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>