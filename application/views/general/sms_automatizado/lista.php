<table id="example" class="table table-hover table-striped table-bordered" >
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%" title="Empresa">Emp.</th>
            <th class="text-center" width="6%">Sede</th>
            <th class="text-center" width="10%">Tipo</th> 
            <th class="text-center" width="6%">Unitario</th>
            <th class="text-center" width="20%">Motivo</th>
            <th class="text-center" width="20%">Descripción</th>
            <th class="text-center" width="20%">Regularidad</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_sms_automatizado as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_empresa']; ?></td>
                <td class="text-left"><?php echo $list['cod_sede']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td><?php echo $list['unitario']; ?></td>
                <td class="text-left"><?php echo $list['motivo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td class="text-left"><?php echo $list['regularidad']; ?></td>
                <td><?php echo $list['nom_status']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('General/Modal_Update_Sms_Automatizado') ?>/<?php echo $list['id_sms']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Sms_Automatizado('<?php echo $list['id_sms']; ?>')">
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        });
    });
</script>