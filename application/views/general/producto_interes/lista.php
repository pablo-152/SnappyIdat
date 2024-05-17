<table id="example" class="table table-hover table-striped table-bordered" >
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="4%" title="Empresa">Emp.</th>
            <th class="text-center" width="4%">Sede</th>
            <th class="text-center">Interese</th>
            <th class="text-center" width="5%">Orden</th>
            <th class="text-center" width="6%">Totales</th>
            <th class="text-center" width="6%">Formulario</th>
            <th class="text-center" width="8%" title="Fecha Inicio">Fec. Ini.</th>
            <th class="text-center" width="8%" title="Fecha Fin">Fec. Fin</th>
            <th class="text-center">Orden</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_producto_interes as $list){ ?>                                           
            <tr class="even pointer text-center" <?php if($list['fecha_fin']<=date('Y-m-d')){ ?> style="background-color:#F2BBBB;color:#FFF;" <?php } ?>>
                <td><?php echo $list['cod_empresa']; ?></td>
                <td class="text-left"><?php echo $list['cod_sede']; ?></td>
                <td class="text-left"><?php echo $list['nom_producto_interes']; ?></td>
                <td><?php echo $list['orden_producto_interes']; ?></td>
                <td><?php echo $list['totales']; ?></td>
                <td><?php echo $list['formularios']; ?></td>
                <td><?php echo $list['fec_inicio']; ?></td>
                <td><?php echo $list['fec_fin']; ?></td>
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['nom_status']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('General/Modal_Update_Producto_Interes') ?>/<?php echo $list["id_producto_interes"]; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Producto_Interes('<?php echo $list['id_producto_interes']; ?>')">
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[8,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 10 ]
                },
                {
                    'targets' : [ 8 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>