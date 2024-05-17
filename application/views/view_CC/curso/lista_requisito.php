<table id="example_req" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="15%">Tipo</th>
            <th class="text-center" width="65%">Descripción</th>
            <th class="text-center" width="15%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_requisito_curso as $list){ ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['nom_tipo_requisito']; ?></td>  
                <td class="text-left"><?php echo $list['desc_requisito']; ?></td> 
                <td><span class="badge" style="background:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td> 
                <td>
                    <img title="Editar Requisito" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('CursosCortos/Modal_Update_Requisito') ?>/<?php echo $list['id_requisito']; ?>" 
                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#example_req thead tr').clone(true).appendTo('#example_req thead');
        $('#example_req thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example_req').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 3 ]
                }
            ]
    });
</script>