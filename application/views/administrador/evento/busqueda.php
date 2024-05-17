<table id="example" class="table table-hover table-striped table-bordered" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Fecha Bd</th>
            <th class="text-center" width="5%" title="Referencia">Ref</th>
            <th class="text-center" width="5%" title="Empresa">Emp</th>
            <th class="text-center" width="23%">Evento</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="6%">Hora</th>
            <th class="text-center" width="8%">Activo de</th>
            <th class="text-center" width="6%">Hasta</th>
            <th class="text-center" width="6%" title="Registrado">Reg.</th>
            <th class="text-center" width="6%" title="Contactado">Cont.</th>
            <th class="text-center" width="6%" title="Asiste">Asiste</th>
            <th class="text-center" width="6%" title="No Asiste">N/ Asiste</th>
            <th class="text-center" width="6%" title="Matriculado">Matricula</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_evento as $list) { ?>
            <tr class="even pointer text-center" <?php if($list['fec_fin']<date('Y-m-d') && $list['id_estadoe']==1){ ?> style="background-color:#F2BBBB;color:#FFF;" <?php } ?>>
                <td><?php echo $list['fec_agenda']; ?></td>
                <td><?php echo $list['cod_evento']; ?></td>
                <td><?php echo $list['cod_empresa']; ?></td>
                <td class="text-left"><?php echo $list['nom_evento']; ?></td>
                <td class="<?php if($list['fec_fin']<date('Y-m-d') && $list['id_estadoe']==1){ echo "color_pendiente"; }else{ echo "color_casilla"; } ?>"><?php echo $list['fecha_agenda']; ?></td>
                <td><?php echo $list['h_evento']; ?></td>
                <td><?php echo $list['fecha_ini']; ?></td>
                <td><?php echo $list['fecha_fin']; ?></td>
                <td><?php echo $list['registrados']; ?></td>
                <td><?php echo $list['contactados']; ?></td>
                <td><?php echo $list['asistes']; ?></td>
                <td><?php echo $list['no_asistes']; ?></td>
                <td><?php echo $list['matriculados']; ?></td>
                <td>
                    <span class="badge" style="background:<?php echo $list['color']; ?>;"><?php echo $list['nom_estadoe']; ?></span>
                </td>
                <td>
                    <a type="button" title="Editar Evento" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Editar_Evento') ?>/<?php echo $list['id_evento']; ?>"> <img src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
                    <a type="button" title="Detalle Evento" href="<?= site_url('Administrador/Detalle_Evento') ?>/<?php echo $list['id_evento']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
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
            [0, "asc"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 14 ]
            },
            {
                'targets' : [ 0 ],
                'visible' : false
            } 
        ]
    });
</script>