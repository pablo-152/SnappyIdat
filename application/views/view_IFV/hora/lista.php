<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="50%">Especialidad</th> 
            <th class="text-center" width="15%">Turno</th>
            <th class="text-center" width="10%">Desde</th>
            <th class="text-center" width="10%">Hasta</th>
            <th class="text-center" width="10%">Tolerancia</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_hora as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_especialidad']; ?></td>   
                <td class="text-left"><?php echo $list['nom_turno']; ?></td>   
                <td><?php echo $list['desde']; ?></td>   
                <td><?php echo $list['hasta']; ?></td>     
                <td><?php echo $list['tolerancia']; ?></td>          
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_C_Hora') ?>/<?php echo $list['id_hora']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_C_Hora('<?php echo $list['id_hora']; ?>')"> 
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

        var table=$('#example').DataTable( {
            order: [[0,"asc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>