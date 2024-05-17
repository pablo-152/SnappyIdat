<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%">Código</th>
            <th class="text-center" width="8%" title="Tipo Envío">Tipo E.</th> 
            <th class="text-center" width="8%" title="Fecha Envío">Fecha E.</th> 
            <th class="text-center" width="20%">Título</th> 
            <th class="text-center" width="42%">Texto</th>  
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="8%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_mailing as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>    
                <td><?php echo $list['nom_tipo_envio']; ?></td>   
                <td><?php echo $list['fecha_envio']; ?></td>   
                <td class="text-left"><?php echo $list['titulo']; ?></td>   
                <td class="text-left"><?php echo $list['texto']; ?></td>    
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>   
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('BabyLeaders/Modal_Update_Mailing') ?>/<?php echo $list['id_mailing']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <a title="Detalle" href="<?= site_url('BabyLeaders/Detalle_Mailing') ?>/<?php echo $list['id_mailing']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png">
                    </a>

                    <?php if($list['documento']!=""){ ?>
                        <a onclick="Descargar_Mailing('<?php echo $list['id_mailing']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php } ?>

                    <a href="#" class="" title="Eliminar" onclick="Delete_Mailing('<?php echo $list['id_mailing']; ?>')" role="button">
                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
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

        var table=$('#example').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    } );
</script>