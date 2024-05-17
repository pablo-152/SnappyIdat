<table class="table table-hover table-bordered table-striped" id="example_centro" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="7%">Ap. Paterno</th> 
            <th class="text-center" width="7%">Ap. Materno</th>   
            <th class="text-center" width="8%">Nombre(s)</th>  
            <th class="text-center" width="5%">Código</th>
            <th class="text-center" width="5%">Fecha</th>
            <th class="text-center" width="5%">Usuario</th>
            <th class="text-center" width="11%">Centro Prácticas</th>
            <th class="text-center" width="8%">Ref</th>  
            <th class="text-center" width="6%">Inicio</th>
            <th class="text-center" width="5%">Fin</th> 
            <th class="text-center" width="6%" title="Horas Previstas">H. Pre.</th>
            <th class="text-center" width="5%">Aprobación</th> 
            <th class="text-center" width="7%" title="Envio Doc's">Env. Doc's</th>
            <th class="text-center" width="6%" title="Horas Reales">H. Rea.</th>
            <th class="text-center" width="5%">Estado</th> 
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_centro as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>         
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>                                                     
                <td><?php echo $list['cod_alumno']; ?></td>   
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>   
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>       
                <td><?php echo ""; ?></td>  
                <td><?php echo ""; ?></td>      
                <td>
                    <?php if($list['estado_e']==0){ ?>
                        <a title="Reenviar" onclick="Reenviar_Examen_Basico('<?php echo $list['id_examen']; ?>')">
                            <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png">
                        </a>
                    <?php } ?>

                    <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || 
                    $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85){ ?>
                        <a title="Eliminar" onclick="Delete_Examen_Basico('<?php echo $list['id_examen']; ?>')">
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
        $('#example_centro thead tr').clone(true).appendTo( '#example_centro thead' );
        $('#example_centro thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_centro').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 15 ]
                }
            ]
        } );
    } );
</script>