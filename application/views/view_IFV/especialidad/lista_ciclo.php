<table class="table table-hover table-bordered table-striped" id="example_ciclo" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="40%">Módulo</th>
            <th class="text-center" width="40%">Ciclo</th> 
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_ciclo as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['modulo']; ?></td>  
                <td><?php echo $list['ciclo']; ?></td>     
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                                                 
                <td>
                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Ciclo') ?>/<?php echo $list['id_ciclo']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <a href="#" class="" title="Eliminar" onclick="Delete_Ciclo('<?php echo $list['id_ciclo']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_ciclo thead tr').clone(true).appendTo( '#example_ciclo thead' );
        $('#example_ciclo thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_ciclo').DataTable( {
            order: [[2,"asc"],[0,"asc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 3 ]
                }
            ]
        } );
    } );
</script>