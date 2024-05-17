<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Hora</th>
            <th class="text-center" width="10%">Unid.&nbsp;Didáctica</th>
            <th class="text-center" width="30%">Asignatura</th>
            <th class="text-center" width="25%">Profesor</th>
            <th width="12%">Salón</th>
            <th width="6%"><div></div></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_horario_detalle as $list) {  ?>
            <tr class="even pointer">
                <td class="text-center"><?php echo $list['desde']." - ".$list['hasta'] ?></td>
                <td><?php echo $list['nom_unidad_didactica'] ?></td>
                <td></td>
                <td></td>
                <td><?php echo $list['referencia']." - ".$list['descripcion']; ?></td>
                <td class="text-center">
                    <a href="#" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Horario_Detalle') ?>/<?php echo $list['id_horario_detalle']; ?>"><img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"></a>
                    <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Horario_Detalle('<?php echo $list['id_horario_detalle']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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