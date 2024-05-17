<table class="table table-hover table-bordered table-striped" id="example_obs" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="7%">Fecha</th> 
            <th class="text-center" width="20%">Tipo</th>
            <th class="text-center" width="10%">Usuario</th> 
            <th class="text-center" width="60%">Comentario</th> 
            <th class="text-center" width="3%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_observacion as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>          
                <td><?php echo $list['fecha']; ?></td>  
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>   
                <td class="text-left"><?php echo $list['usuario']; ?></td>                                                   
                <td class="text-left"><?php echo $list['observacion']; ?></td>         
                <td>
                    <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a title="Eliminar" onclick="Delete_Observacion('<?php echo $list['id_observacion']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php } ?>
                </td>                        
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_obs thead tr').clone(true).appendTo( '#example_obs thead' );
        $('#example_obs thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_obs').DataTable( {
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>