<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="15%">Fecha Compra</th>
            <th class="text-center" width="15%">Monto</th>
            <th class="text-center" width="15%">Cantidad</th>
            <th class="text-center" width="15%">Fecha</th>
            <th class="text-center" width="25%">Usuario</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
 
    <tbody>
        <?php foreach ($list_compra_mensaje as $list) { ?> 
            <tr class="even pointer text-center">
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['fecha_compra']; ?></td>
                <td class="text-right"><?php echo "s/ ".$list['monto']; ?></td>
                <td><?php echo $list['cantidad']; ?></td>
                <td><?php echo $list['fecha_registro']; ?></td>
                <td class="text-left"><?php echo $list['usuario_registro']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Compra_Mensaje') ?>/<?php echo $list['id_compra']; ?>">
                        <img title="Editar" src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <?php if($id_usuario==1 || $id_usuario==5 || $id_nivel==6){ ?>
                        <a title="Eliminar" href="#" onclick="Delete_Compra_Mensaje('<?php echo $list['id_compra']; ?>')" role="button"> 
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
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }); 

        var table = $('#example').DataTable({
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                } ,
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>