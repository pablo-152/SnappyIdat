<table class="table table-hover table-bordered table-striped" id="example_turno" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="55%">Nombre</th>     
            <th class="text-center" width="10%">Desde</th>    
            <th class="text-center" width="10%">Hasta</th>    
            <th class="text-center" width="10%">Tolerancia</th>    
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_turno as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_turno']; ?></td>   
                <td><?php echo $list['desde']; ?></td>   
                <td><?php echo $list['hasta']; ?></td>   
                <td><?php echo $list['tolerancia']; ?></td>   
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>        
                <td>
                    <!--<a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Turno') ?>/<?php echo $list['id_turno']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>-->
                    <a title="Eliminar" href="#" onclick="Delete_Turno('<?php echo $list['id_turno']; ?>')" role="button"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_turno thead tr').clone(true).appendTo( '#example_turno thead' );
        $('#example_turno thead tr:eq(1) th').each( function (i) {
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
        });

        var table=$('#example_turno').DataTable( {
            order: [[4,"asc"],[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>