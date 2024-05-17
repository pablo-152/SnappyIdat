<input type="hidden" id="id_nivel" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>">

<table class="table table-hover table-bordered table-striped" id="example" width="100%" >
    <thead>
        <tr>
            <th class="text-center">Orden</th>
            <th class="text-center" width="5%">Año</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="5%" title="Día de Semana">D. Semana</th>
            <th class="text-center">Descripción</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="6%">F/V</th>
            <th class="text-center" width="3%">Clases</th>
            <th class="text-center" width="3%">Laborable</th>
            <th class="text-center" width="24%">Observaciones</th>
            <th class="text-center" width="6%">Empresa</th>
            <th class="text-center" width="6%">Estado</th>
            <?php if ($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_nivel']==4) { ?>
                <td class="text-center" width="5%">&nbsp;</td>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_festivo as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['inicio']; ?></td>
                <td><?php echo $list['anio']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['nom_dia']; ?></td>
                <td class="text-left"><?php echo substr($list['descripcion'],0,50); ?></td>
                <td class="text-left"><?php echo $list['nom_tipo_fecha']; ?></td>
                <td><?php echo $list['f_v']; ?></td>
                <td><?php echo $list['clases']; ?></td>
                <td><?php echo $list['laborable']; ?></td>
                <td class="text-left"><?php echo substr($list['observaciones'],0,50); ?></td>
                <td><?php echo $list['cod_empresa']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                 
                <?php if ($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_nivel']==4) { ?>
                    <td>
                        <img title="Editar Datos Festivo" data-toggle="modal" data-target="#acceso_modal_mod"  app_crear_mod="<?= site_url('Snappy/Modal_Update_Festivo') ?>/<?php echo $list["id_calendar_festivo"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"   width="22" height="22" />
                        <a href="#" class="" title="Eliminar" onclick="Delete_Festivo('<?php echo $list['id_calendar_festivo'] ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                    </td>
                <?php } ?>
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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 12 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>