<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Id</th>
            <th>Id</th>
            <th class="text-center" width="30%">Grado</th>
            <th class="text-center" width="50%">Nombre</th>
            <th class="text-center" width="15%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_seccion as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['id_seccion']; ?></td>
                <td><?php echo $list['id_seccion']; ?></td>
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>
                <td class="text-left"><?php echo $list['nom_seccion']; ?></td>
                <td><?php echo $list['nom_status']; ?></td>                                                       
                <td>
                    <img title="Editar Datos Sección" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('BabyLeaders/Modal_Update_Seccion') ?>/<?php echo $list['id_seccion']; ?>" 
                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>

                    <img title="Eliminar" onclick="Delete_Seccion('<?php echo $list['id_seccion']; ?>')"
                    src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer;"/>
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
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                },
                {
                    'targets' : [ 0,1 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>