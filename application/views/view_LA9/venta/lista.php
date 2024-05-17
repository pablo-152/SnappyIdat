<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead> 
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th> 
            <th class="text-center" width="8%">Número</th>
            <th class="text-center" width="5%" title="Punto Venta">P. Ve.</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="5%">Usuario</th> 
            <th class="text-center" width="4%" title="Código">Cod</th>  
            <th class="text-center" width="6%" title="Apellido Paterno">Ap. Pat.</th> 
            <th class="text-center" width="6%" title="Apellido Materno">Ap. Mat.</th> 
            <th class="text-center" width="9%">Nombre</th>  
            <th class="text-center" width="5%" title="Documento">Doc.</th> 
            <th class="text-center" width="5%" title="Cantidad">Cant.</th>
            <th class="text-center" width="6%">Total</th>
            <th class="text-center" width="7%">Tipo Pago</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="6%">Usuario</th>
            <th class="text-center" width="6%">Tipo</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_venta as $list){ ?>                                           
            <tr class="even pointer text-center"> 
                <td><?php echo $list['id_venta']; ?></td>
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td>
                <td><?php echo $list['fecha']; ?></td> 
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Ap_Paterno']; ?></td> 
                <td class="text-left"><?php echo $list['Ap_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['nom_tipo_documento']; ?></td>
                <td><?php echo $list['cantidad']; ?></td> 
                <td class="text-right" <?php if($list['estado_venta']==3){ echo "style='color:red;'"; } ?>><?php echo "s/. ".$list['total']; ?></td> 
                <td><?php echo $list['nom_tipo_pago']; ?></td> 
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_estado_venta']; ?></span></td>
                <td><?php echo $list['fecha_anulado']; ?></td> 
                <td class="text-left"><?php echo $list['usuario_anulado']; ?></td> 
                <td><?php echo $list['nom_tipo_envio']; ?></td>
                <td>
                    <?php if($list['id_tipo_documento']==1){ ?>
                        <a title="Documento" href="<?= site_url('Laleli9/Recibo_Venta') ?>/<?php echo $list['id_venta']; ?>" target="_blank">
                            <img src="<?= base_url() ?>template/img/icono_impresora.png">
                        </a>
                    <?php }else{ ?>
                        <a title="Documento" href="<?= site_url('Laleli9/Pdf_Venta') ?>/<?php echo $list['id_venta']; ?>" target="_blank">
                            <img src="<?= base_url() ?>template/img/icono_impresora.png">
                        </a>
                    <?php } ?>

                    <?php if($list['estado_venta']==1 && $list['anulado']==0){ ?>
                        <a title="Devolución" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('Laleli9/Modal_Anular_Venta') ?>/<?php echo $list['id_venta']; ?>">
                            <img src="<?= base_url() ?>template/img/devolucion.png">
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
            order: [[1,"desc"],[13,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 17 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>