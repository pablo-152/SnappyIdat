<table class="table table-hover table-bordered table-striped" id="example" width="100%" > 
    <thead>
        <tr>
            <th class="text-center">Orden</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="35%">Descripción</th>
            <th class="text-center" width="10%">Días Feriado</th>
            <th class="text-center" width="35%">Motivo</th>
            <th class="text-center" width="8%">Estado</th>
            <td class="text-center" width="4%"></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_festivo as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['dias']; ?></td>
                <td class="text-left"><?php echo $list['motivo']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>               
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('LittleLeaders/Modal_Update_Calendario') ?>/<?php echo $list['id_calendario']; ?>" >
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    
                    <a title="Eliminar" onclick="Delete_Calendario('<?php echo $list['id_calendario'] ?>')"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png">
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
            order: [[5,"asc"],[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>