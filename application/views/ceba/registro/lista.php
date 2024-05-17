<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Tipo</th>
            <th class="text-center" width="6%">Ref</th>
            <th class="text-center" width="8%" title="Fecha Envio">F. Env.</th>
            <th class="text-center" width="8%" title="Número Alumnos">N. Alu.</th>
            <th class="text-center" width="14%" title="Número Alumnos">Tablas Alumnos Arpay</th>
            <th class="text-center" width="14%" title="Número Alumnos">Registro (apuntes)</th>
            <th class="text-center" width="14%" title="Número Alumnos">Documento Enviado</th>
            <th class="text-center" width="14%" title="Número Alumnos">Documento Recibido</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_registro as $list) {  ?>
            <tr class="even pointer">
                <td class="text-center"><?php echo $list['nom_tipo']; ?></td>
                <td><?php echo $list['referencia'] ?></td>
                <td class="text-center"><?php echo $list['fec_envio']; ?></td>
                <td class="text-center"><?php echo $list['n_alumnos']; ?></td>
                <td class="text-center"><?php echo $list['t_archivo']; ?></td>
                <td class="text-center"><?php echo $list['r_archivo']; ?></td>
                <td class="text-center"><?php echo $list['de_archivo']; ?></td>
                <td class="text-center"><?php echo $list['dr_archivo']; ?></td>
                <td class="text-center"><?php echo $list['primer_estado']; ?></td>
                <td class="text-center">
                    <a href="<?= site_url('Ceba/Editar_Registro') ?>/<?php echo $list['id_registro']; ?>"><img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"></a>
                    <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Registro('<?php echo $list['id_registro']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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
            pageLength: 25
        });
    });
</script>