<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="3%">Semana</th>
            <th class="text-center" width="3%">Del&nbsp;día</th>
            <th class="text-center" width="3%">Hasta</th>
            <th class="text-center" width="30%">Especialidad</th>
            <th width="8%">Grupo</th>
            <th class="text-center" width="3%">Modulo</th>
            <th class="text-center" width="5%">Turno</th>
            <th width="6%"><div></div></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_horario as $list) {  ?>
            <tr class="even pointer">
                <td class="text-center"><?php if($list['ch_semana']=="1"){echo $list['semana'];} ?></td>
                <td><?php if($list['ch_semana']=="0"){echo $list['del_dia'];} ?></td>
                <td><?php if($list['ch_semana']=="0"){echo $list['hasta'];} ?></td>
                <td><?php echo $list['nom_especialidad']; ?></td>
                <td class="text-center"><?php echo $list['desc_grupo']; ?></td>
                <td class="text-center"><?php echo $list['modulo']; ?></td>
                <td><?php echo $list['nom_turno']; ?></td>
                <td class="text-center">
                    <a href="<?= site_url('AppIFV/Editar_Horario') ?>/<?php echo $list['id_horario']; ?>"><img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"></a>
                    <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Horario('<?php echo $list['id_horario']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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
            pageLength: 50
        });
    });
</script>