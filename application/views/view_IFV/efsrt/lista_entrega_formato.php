<table class="table table-hover table-bordered table-striped" id="example_entrega_formato" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="12%">Ap. Paterno</th> 
            <th class="text-center" width="12%">Ap. Materno</th>   
            <th class="text-center" width="16%">Nombre(s)</th> 
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="20%">Correo</th>
            <th class="text-center" width="12%">Fecha Envío</th>
            <th class="text-center" width="8%">Hora</th> 
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_entrega_formato as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>         
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>                                                     
                <td><?php echo $list['cod_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['email_alumno']; ?></td>     
                <td><?php echo $list['fecha_envio']; ?></td>       
                <td><?php echo $list['hora_envio']; ?></td>       
                <td><?php echo $list['nom_estado']; ?></td>    
                <td>
                    <a title="Reenviar" onclick="Reenviar_Entrega_Formato('<?php echo $list['id_entrega']; ?>','<?= $id_especialidad; ?>')">
                        <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png">
                    </a>

                    <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || 
                    $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85){ ?>
                        <a title="Eliminar" onclick="Delete_Entrega_Formato('<?php echo $list['id_entrega']; ?>')">
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
        $('#example_entrega_formato thead tr').clone(true).appendTo( '#example_entrega_formato thead' );
        $('#example_entrega_formato thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_entrega_formato').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    } );
</script>