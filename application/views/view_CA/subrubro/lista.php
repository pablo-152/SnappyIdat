<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Rubro</th>
            <th class="text-center" width="20%">Nombre</th>
            <th class="text-center" width="15%">Sem Contabilizar</th> 
            <th class="text-center" width="15%">Enviado Original</th> 
            <th class="text-center" width="15%" title="Sin Documento Físico">Sem Doc. Físico</th> 
            <th class="text-center" width="10%">Estado</th> 
            <th class="text-center" width="5%"></th>
        </tr> 
    </thead>
    <tbody>
        <?php foreach($list_subrubro as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_rubro']; ?></td>   
                <td class="text-left"><?php echo $list['nom_subrubro']; ?></td>   
                <td><?php echo $list['sin_contabilizar']; ?></td>               
                <td><?php echo $list['enviado_original']; ?></td>               
                <td><?php echo $list['sin_documento_fisico']; ?></td>               
                <td><?php echo $list['nom_status']; ?></td>                                                     
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ca/Modal_Update_Subrubro') ?>/<?php echo $list['id_subrubro']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Subrubro('<?php echo $list['id_subrubro']; ?>')"> 
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
            order: [[0,"asc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    } );
</script>