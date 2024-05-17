<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Perfil</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="14%">Tipo</th>
            <th class="text-center" width="8%">Acción</th>
            <th class="text-center" width="24%">Mensaje</th>
            <th class="text-center" width="6%">Leido</th>
            <th class="text-center" width="28%">Link</th>
            <td class="text-center" width="4%"></td>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_aviso as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_perfil']; ?></td>
                <td><?php echo $list['nom_fecha']; ?></td>
                <td class="text-left"><?php echo $list['tipo']; ?></td>
                <td><?php echo $list['nom_accion']; ?></td>
                <td class="text-left"><?php echo $list['mensaje']; ?></td>
                <td>
                    <input type="radio" <?php if($list['leido']==1){ echo "checked"; } ?> onclick="Update_Leido_Aviso('<?php echo $list['id_aviso']; ?>','<?php echo $list['leido']; ?>');">
                </td>
                <td class="text-left"><?php echo $list['link']; ?></td>
                <td class="text-center">
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('General/Modal_Update_Aviso') ?>/<?php echo $list['id_aviso']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
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
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                } 
            ]
        });
    });
</script>