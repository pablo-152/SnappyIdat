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
        <?php foreach ($list_archivo_postulante as $list) { ?>
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
                    <a href="<?= site_url('AppIFV/Descargar_Documento_Postulante/' . $list['id_postulante']) ?>" title="Descargar Documento">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;" />
                    </a>

                    <?php if ($list['nom_estado'] == 'Pendiente') : ?>
                        
                        <a title="Validar Archivo Postulante" onclick="Validar_Archivo_Postulante('<?= $list['id_postulante'] ?>','<?= $list['id_detalle'] ?>','<?= $list['archivo'] ?>');">
                            <img src="<?= base_url() ?>template/img/check.png">
                        </a>
                        <a type="button" title="Rechazar Archivo Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Rechazar_Archivo_Postulante/' . $list['id_postulante'] . '/'. $list['id_detalle'] .'/'. $list['id_documento']. '/' . $tipo) ?>">
                            <img src="<?= base_url() ?>template/img/equis.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                        </a>
                    <?php elseif ($list['nom_estado'] == 'Rechazado') : ?>
                        <a title="Validar archivo Postulante" onclick="Validar_Archivo_Postulante('<?= $list['id_postulante'] ?>','<?= $list['id_detalle'] ?>','<?= $list['archivo'] ?>');">
                            <img src="<?= base_url() ?>template/img/check.png">
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
                <!--<td class="text-left"><?php echo $list['ColumnaNombre']; ?></td>
                <td class="text-left"><?php echo $list['ColumnaValor']; ?></td>
                <td><?php echo $list['Fec_reg']; ?></td>
                <td>
                    <span class="badge" style="background-color:<?php echo $list['color_estado']; ?>;font-size:12px;"><?php echo $list['nom_estado']; ?></span>
                <td>
                    <a href="<?= site_url('AppIFV/Descargar_Documento_Postulante/' . $list['id_admision'] . '/' . $list['ColumnaNombre']) ?>" title="Descargar Documento">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;" />
                    </a>
                    <a title="Validar archivo" onclick="Validar_Archivo_Postulante('<?= $list['id_admision'] ?>', '<?= $list['ColumnaNombre'] ?>','<?= $list['ColumnaValor'] ?>');">
                        <img src="<?= base_url() ?>template/img/check.png">
                    </a>
                    <a type="button" title="Rechazar Archivo Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Rechazar_Archivo_Postulante/' . $list['id_admision'] . '/' . $list['ColumnaNombre']. '/' . $tipo) ?>">
                        <img src="<?= base_url() ?>template/img/equis.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                    </a>
                </td>-->
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
                'aTargets': []
            }]
        });
    });
</script>