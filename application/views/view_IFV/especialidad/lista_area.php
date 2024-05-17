<table class="table table-hover table-bordered table-striped" id="example_area" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Codigo</th>
            <th class="text-center" width="65%">Área</th>
            <th class="text-center" width="10%">Orden</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_area as $list) {  ?>                                           
            <tr class="even pointer text-center">                                           
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nombre']; ?></td>
                <td><?php echo $list['orden']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>    
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Area') ?>/<?php echo $list['id_area']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" href="#" onclick="Delete_Area('<?php echo $list['id_area']; ?>')" role="button"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#example_area thead tr').clone(true).appendTo('#example_area thead'); 
    $('#example_area thead tr:eq(1) th').each(function(i) { 
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

    var table = $('#example_area').DataTable({
        order: [[3,"asc"],[0,"asc"]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 4 ] 
            }
        ]
    });
</script>