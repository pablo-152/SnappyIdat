<table id="example" class="table  table-hover table-bordered table-striped">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Id</th>
            <th class="text-center" width="8%">Horas</th>
            <th class="text-center" width="8%">Solicitante</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="50%">Observaciones</th>
            <th class="text-center" width="6%">Documento</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="4%" class="no-content"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_historial_ticket as $list) {  ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['id_historial']; ?></td>
                <td><?php if ($list['id_status_ticket'] == 2 || $list['id_status_ticket'] == 23) {
                                    if ($list['minutos'] == "0") {
                                        $minuto = "00";
                                    } else {
                                        $minuto = $list['minutos'];
                                    }
                                    echo $list['horas'] . ":" . $minuto;
                                    } ?></td>
                <td ><?php echo $list['usuario_codigo']; ?></td>
                <td><?php echo $list['colaborador_codigo']; ?></td>
                <td><?php echo $list['fecha_registro']; ?></td>
                <td class="text-left"><?php echo nl2br($list['ticket_obs']); ?></td> 
                
                <td>
                <?php if($list['img1'] == "" ){

                }else{?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['img1']?>">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                <?php }?>
                <?php if($list['img2'] == "" ){

                }else{?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['img2']?>">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                <?php }?>
                <?php if($list['img3'] == "" ){
                }else{?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['img3']?>">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                <?php }?>
                <?php if($list['img4'] == "" ){

                }else{?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['img4']?>">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                <?php }?>
                </td>
                <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                <td>
                    <?php if ($get_id[0]['bloqueado'] != 1) { ?>
                        <?php if ($_SESSION['usuario'][0]['id_usuario'] == 1 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 5  || $_SESSION['usuario'][0]['id_usuario'] == 7 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 48 || $_SESSION['usuario'][0]['id_nivel'] == 9 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 81 || $_SESSION['usuario'][0]['id_usuario'] == 85 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 33){ ?>
                            <a title="Editar" data-toggle="modal" data-target="#acceso_modal_eli" app_crear_eli="<?= site_url('General/Modal_Update_Historial_Ticket') ?>/<?php echo $list['id_historial']; ?>">
                                <img src="<?= base_url() ?>template/img/editar.png">
                            </a>
                        <?php } ?>

                        <?php if ($_SESSION['usuario'][0]['id_usuario'] == 1 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 5  || $_SESSION['usuario'][0]['id_usuario'] == 7 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 81 || $_SESSION['usuario'][0]['id_usuario'] == 85 || 
                        $_SESSION['usuario'][0]['id_usuario'] == 33) {
                            if ($list['id_status_ticket'] != 1){ ?>
                                <a title="Eliminar" onclick="Delete_Historial_Ticket('<?php echo $list['id_historial']; ?>')"> 
                                    <img src="<?= base_url() ?>template/img/eliminar.png">
                                </a>
                        <?php  } } ?>
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
                    'aTargets' : [ 8 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>