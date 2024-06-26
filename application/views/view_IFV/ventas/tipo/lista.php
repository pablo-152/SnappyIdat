<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="34%">Código</th> 
            <th class="text-center" width="50%">Descripción</th>
            <!--<th class="text-center" width="10%">Foto</th>-->
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_tipo_venta as $list){ ?>                                             
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['cod_tipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td> 
                <!--<td><?php //echo $list['v_foto']; ?></td>-->
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                                        
                <td>
                    <?php if($list['id_tipo']!="1"){?> 
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Tipo_Venta') ?>/<?php echo $list['id_tipo']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>    
                    <?php }?>
                    
                    <?php /*if($list['foto']!=""){ ?>
                        <a onclick="Descargar_Foto_Tipo_Venta('<?php echo $list['id_tipo']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php }*/ ?>

                    <?php if($list['id_tipo']!="1"){?> 
                        <a title="Eliminar" onclick="Delete_Tipo_Venta('<?php echo $list['id_tipo']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php }?>
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