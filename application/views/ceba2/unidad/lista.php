<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="33%">Nombre</th>
            <th class="text-center" width="13%">Inicio Clases</th>
            <th class="text-center" width="13%">Fin Clases</th>
            <th class="text-center" width="13%">Inicio Matrícula</th>
            <th class="text-center" width="13%">Fin Matrícula</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_unidad as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_unidad']; ?></td>   
                <td><?php echo $list['inicio_clase']; ?></td>   
                <td><?php echo $list['fin_clase']; ?></td>   
                <td><?php echo $list['inicio_matricula']; ?></td>   
                <td><?php echo $list['fin_matricula']; ?></td>   
                <td><?php echo $list['nom_status']; ?></td>                                                    
                <td>
                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ceba2/Modal_Update_Unidad') ?>/<?php echo $list['id_unidad']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <a href="#" class="" title="Eliminar" onclick="Delete_Unidad('<?php echo $list['id_unidad']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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

        var table=$('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    } );
</script>