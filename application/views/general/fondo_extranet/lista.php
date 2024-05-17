<table class="table  table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr>
            <th class="text-center" width="76%">Título</th>
            <th class="text-center" width="12%">Estado</th>
            <td class="text-center" width="12%"></td>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_fondo_extranet as $list) {  ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['titulo']; ?></td>
                <td><?php echo $list['nom_status']; ?></td>
                <td>
                    <img title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('General/Modal_Update_Fondo_Extranet') ?>/<?php echo $list['id_fondo']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                    <img src="<?= base_url() ?>template/img/ver.png" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $list['imagen'] ?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;" />
                    <?php if($list['estado']==2) { ?>
                        <a style="color:red" onclick="Cambiar_Estado_Fondo_Extranet('<?php echo $list['id_fondo']; ?>',3)" title="Desactivar Fondo Extranet">
                            <img src="<?= base_url() ?>template/img/x.png">
                        </a>
                    <?php }else{ ?>
                        <a style="color:green" onclick="Cambiar_Estado_Fondo_Extranet('<?php echo $list['id_fondo']; ?>',2)" title="Activar Fondo Extranet">
                            <img src="<?= base_url() ?>template/img/check.png">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php  } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 2 ]
            } ]
        });
    });
</script>