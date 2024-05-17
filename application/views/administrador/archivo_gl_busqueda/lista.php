<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%" title="Empresa">Emp.</th>
            <th class="text-center" width="6%">Sede</th>
            <th class="text-center" width="10%" title="Código Documento">Código D.</th>
            <th class="text-center" width="22%">Nombre Documento</th>
            <th class="text-center" width="20%">Nombre(s)</th>
            <th class="text-center" width="12%">Ap. Paterno</th>
            <th class="text-center" width="12%">Ap. Materno</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_archivo as $list) { ?>
            <tr class="even pointer text-center">
                <td><?= $list['cod_empresa']; ?></td>
                <td class="text-left"><?= $list['cod_sede']; ?></td>
                <td><?= $list['cod_documento']; ?></td>
                <td class="text-left"><?= $list['nom_documento']; ?></td>
                <td class="text-left"><?= $list['nombre']; ?></td>
                <td class="text-left"><?= $list['apellido_paterno']; ?></td>
                <td class="text-left"><?= $list['apellido_materno']; ?></td>
                <td>
                    <span class="badge" style="background-color:<?php echo $list['color_estado']; ?>;font-size:12px;"><?php echo $list['nom_estado']; ?></span>
                <td>
                    <a title="Ver archivo" href="<?= $list['archivo']; ?>" target="_blank">
                        <img src="<?= base_url() ?>template/img/ver.png" />
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

            if (title == "") {
                $(this).html('');
            } else {
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
            order: [
                [0, "asc"],
                [1, "asc"]
            ],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 40,
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [1]
            }]
        });
    });
</script>