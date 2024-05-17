<table id="example" class="table table-hover table-striped table-bordered" >
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="86%">Nombre</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_tipo_comercial as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_informe']; ?></td>
                <td><?php echo $list['nom_status']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('General/Modal_Update_Tipo_Comercial') ?>/<?php echo $list['id_informe']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Tipo_Comercial('<?php echo $list['id_informe']; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
            }
    
            $( 'input', this ).on( 'keyup change', function () { 
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 2 ]
                }
            ]
        } );
    });
</script>