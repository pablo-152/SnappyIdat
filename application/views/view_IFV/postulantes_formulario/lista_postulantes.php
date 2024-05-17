<table id="example" class="table table-hover table-bordered table-striped" style="width:100% !important; text-align:center;">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="4%" class="text-center" title="Estado">Estado</th>
            <th width="4%" class="text-center" title="Código">Cod.</th>
            <th width="4%" class="text-center" title="Grupo">Grupo</th>
            <th width="4%" class="text-center" title="Especialidad">Esp.</th>
            <th width="4%" class="text-center" title="Turno">Turno</th>
            <th width="6%" class="text-center">Nr. Doc.</th>
            <th width="8%" class="text-center" title="Ape. Paterno">Ape. Paterno</th>
            <th width="8%" class="text-center" title="Ape. Materno">Ape. Materno</th>
            <th width="10%" class="text-center" title="Nombre(s)">Nombre(s)</th>
            <th width="10%" class="text-center" title="Modalidad">Modalidad</th>
            <th width="5%" class="text-center">Fecha</th>
            <th width="5%" class="text-center">Fec. Ex.</th>
            <th width="5%" class="text-center">Nota</th>
            <th width="4%" class="text-center" title="Creado por">Creado</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_admision as $list) { ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['Estado_Doc_Postulante']; ?></td>
                <td><?php echo $list['codigo_admision']; ?></td>
                <td><?php echo $list['grupo']; ?></td>
                <td><?php echo $list['especialidad']; ?></td>
                <td><?php echo $list['turno']; ?></td>
                <td><?php echo $list['dni']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td class="text-left"><?php echo $list['modalidad']; ?></td>
                <td class="text-center"> - </td>
                <td class="text-center"> - </td>
                <td><?php echo $list['fec_reg']; ?></td>
                <td><?php echo $list['creadopor']; ?></td>
                <td>
                    <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Postulantes_C') ?>/<?php echo $list['Id_Admision']; ?>"> 
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
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
                [1,"asc"]
            ],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            /*"aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [9]
                },
                {
                    'targets': [0],
                    'visible': false
                }
            ]*/
        });
    });
</script>