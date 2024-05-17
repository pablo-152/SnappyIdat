<table id="example" class="table table-hover">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden 1</th>
            <th class="text-center">Orden 2</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="10%">Usuario</th>
            <th class="text-center" width="12%">Tipo</th>
            <th class="text-center" width="12%">Acción</th>
            <th class="text-center">Observaciones</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_historial as $list) {  ?> 
            <tr class="even pointer text-center">
                <td><?php echo $list['orden_1']; ?></td>
                <td><?php echo $list['orden_2']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['nom_accion']; ?></td>
                <td class="text-left"><?php echo $list['observacion']; ?></td>
                <td class="text-left"><?php echo $list['nom_status']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Update_Historial_Publico') ?>/<?php echo $list['id_historial']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    
                    <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_nivel']==7 || $_SESSION['usuario'][0]['id_nivel']==9){ ?> 
                        <a title="Eliminar" onclick="Delete_Historial_Publico('<?php echo $list['id_historial']; ?>')"> 
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
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

            if(title==""){
                $(this).html('');
            }else{
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
            order: [[0,"desc"],[1,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                },
                {
                    'targets' : [ 0,1 ],
                    'visible' : false
                } 
            ]
        });
    } );
</script>