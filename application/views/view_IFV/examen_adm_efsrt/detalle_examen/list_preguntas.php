<table id="example" class="table table-striped table-bordered" >
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="10%" class="text-center">Orden</th>
            <th width="80%" class="text-center">Pregunta</th>
            <th width="10%" class="text-center"></th>
        </tr>
    </thead>

    <tbody class="text-center">
        <?php foreach($list_pregunta as $list) {  ?>                                           
            <tr class="even pointer text-center">                                    
                <td><?php echo $list['orden']; ?></td>
                <td class="text-left"><?php echo $list['pregunta']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Pregunta_Efsrt') ?>/<?php echo $list['id_pregunta']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <?php if($list['img']!=""){?> 
                    <a data-toggle="modal" data-target="#repaso" data-imagen="<?php echo $list['img']?>" title="Ver Imagen"> 
                        <img title="Descargar" src="<?= base_url() ?>template/img/ver.png">
                    </a>    
                    <?php }?>
                    <a href="#" class="" title="Eliminar" onclick="Delete_Pregunta_Efsrt('<?php echo $list['id_pregunta']; ?>','<?php echo $list['id_carrera']; ?>','<?php echo $list['id_examen']; ?>')" role="button"> 
                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
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
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
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
            order: [ 0, "asc" ],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0 ]
                } 
            ]
        } );
    } );

</script>