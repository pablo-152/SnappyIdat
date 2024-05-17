<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="8%">Documento</th>  
            <th class="text-center" width="6%">Compra</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="8%">Codigo</th>  
            <th class="text-center" width="18%">Tipo</th>  
            <th class="text-center" width="18%">Descripción</th>  
            <th class="text-center" width="5%">Talla</th>
            <th class="text-center" width="5%">Stock</th> 
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="6%" title="Fecha Entrega">Fec. Ent.</th>  
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_encomienda as $list){ ?>                                             
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['fecha_venta']; ?></td>
                <td class="text-left"><?php echo $list['usuario_venta']; ?></td>
                <td><?php echo $list['cod_producto']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td> 
                <td><?php echo $list['stock']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_estado']; ?></span></td>      
                <td><?php echo $list['fecha_entrega']; ?></td>
                <td class="text-left"><?php echo $list['usuario_entrega']; ?></td> 
                <td>
                    <?php if($list['estado_e']==0 && $list['anulado']==0){ ?>
                        <a title="Encomendar" data-toggle="modal" data-target="#acceso_modal_pequeno" app_crear_peq="<?= site_url('Laleli9/Modal_Entrega_Encomienda') ?>/<?php echo $list['id_encomienda']; ?>">
                            <img src="<?= base_url() ?>template/img/encomendar.png">
                        </a>
                    <?php } ?>

                    <?php if($list['id_tipo_documento']==1){ ?>
                        <a title="Documento" href="<?= site_url('Laleli9/Recibo_Venta') ?>/<?php echo $list['id_venta']; ?>" target="_blank">
                            <img src="<?= base_url() ?>template/img/icono_impresora.png">
                        </a>
                    <?php }else{ ?> 
                        <a title="Documento" href="<?= site_url('Laleli9/Pdf_Venta') ?>/<?php echo $list['id_venta']; ?>" target="_blank">
                            <img src="<?= base_url() ?>template/img/icono_impresora.png">
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
            order: [0,"desc"],
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