<table class="table table-hover table-bordered table-striped" id="example_modulo" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="80%">Módulo</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_modulo as $list) {  ?>                                           
            <tr class="even pointer text-center">  
                <td><?php echo $list['modulo']; ?></td>      
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                                                 
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Modulo') ?>/<?php echo $list['id_modulo']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" href="#" onclick="Delete_Modulo('<?php echo $list['id_modulo']; ?>')" role="button"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png"> 
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_modulo thead tr').clone(true).appendTo( '#example_modulo thead' );
        $('#example_modulo thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_modulo').DataTable( {
            order: [[1,"asc"],[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 2 ]
                }
            ]
        } );
    } );
</script>