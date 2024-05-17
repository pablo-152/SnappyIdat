<table class="fold-table table table-hover table-bordered table-striped" width="100%" id="ejemplo">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="9%">Ap. Paterno</th> 
            <th class="text-center" width="9%">Ap. Materno</th>   
            <th class="text-center" width="12%">Nombre(s)</th> 
            <th class="text-center" width="5%">Código</th>
            <th class="text-center" width="16%">Correo</th>   
            <th class="text-center" width="4%" title="Cantidad">Cant.</th>  
            <th class="text-center" width="6%">Envío</th>
            <th class="text-center" width="5%">Hora</th> 
            <th class="text-center" width="6%">Termino</th>
            <th class="text-center" width="5%">Hora</th> 
            <th class="text-center" width="6%">Nota</th>
            <th class="text-center" width="6%">Nota</th>
            <th class="text-center" width="5%">Hora</th> 
            <th class="text-center" width="6%">Estado</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_examen_basico_desglosable as $list){ ?> 
            <tr class="view text-center">
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>         
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>                                                     
                <td><?php echo $list['cod_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['email_alumno']; ?></td>     
                <td><?php echo $list['cantidad']; ?></td>     
                <td><?php echo $list['fecha_envio']; ?></td>       
                <td><?php echo $list['hora_envio']; ?></td>       
                <td><?php echo $list['fecha_termino']; ?></td>       
                <td><?php echo $list['hora_termino']; ?></td>     
                <td><?php echo $list['nota']; ?></td>       
                <td><?php echo $list['fecha_nota']; ?></td>       
                <td><?php echo $list['hora_nota']; ?></td>         
                <td><?php echo $list['nom_estado']; ?></td>     
            </tr>
            
            <tr class="fold"> 
                <td colspan="14">
                    <div class="fold-content">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="9%">Ap. Paterno</th> 
                                    <th class="text-center" width="9%">Ap. Materno</th>   
                                    <th class="text-center" width="12%">Nombre(s)</th> 
                                    <th class="text-center" width="5%">Código</th>
                                    <th class="text-center" width="16%">Correo</th>  
                                    <th class="text-center" width="6%">Envío</th>
                                    <th class="text-center" width="5%">Hora</th> 
                                    <th class="text-center" width="6%">Termino</th>
                                    <th class="text-center" width="5%">Hora</th> 
                                    <th class="text-center" width="6%">Nota</th>
                                    <th class="text-center" width="6%">Nota</th>
                                    <th class="text-center" width="5%">Hora</th> 
                                    <th class="text-center" width="6%">Estado</th>
                                    <th class="text-center" width="4%"></th> 
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($list_examen_basico as $examen){ if($list['id_alumno']==$examen['id_alumno']){ ?>
                                    <tr class="text-center">
                                        <td class="text-left"><?php echo $examen['apater_alumno']; ?></td>         
                                        <td class="text-left"><?php echo $examen['amater_alumno']; ?></td>   
                                        <td class="text-left"><?php echo $examen['nom_alumno']; ?></td>                                                     
                                        <td><?php echo $examen['cod_alumno']; ?></td>   
                                        <td class="text-left"><?php echo $examen['email_alumno']; ?></td>
                                        <td><?php echo $examen['fecha_envio']; ?></td> 
                                        <td><?php echo $examen['hora_envio']; ?></td>  
                                        <td><?php echo $examen['fecha_termino']; ?></td>
                                        <td><?php echo $examen['hora_termino']; ?></td>
                                        <td><?php echo $examen['nota']; ?></td>       
                                        <td><?php echo $examen['fecha_nota']; ?></td>       
                                        <td><?php echo $examen['hora_nota']; ?></td>         
                                        <td><?php echo $examen['nom_estado']; ?></td>  
                                        <td>
                                            <?php if($examen['estado_e']==0){ ?>
                                                <a title="Reenviar" onclick="Reenviar_Examen_Basico('<?php echo $examen['id_examen']; ?>')">
                                                    <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png">
                                                </a>
                                            <?php } ?>

                                            <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || 
                                            $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85){ ?>
                                                <a title="Eliminar" onclick="Delete_Examen_Basico('<?php echo $examen['id_examen']; ?>')">
                                                    <img src="<?= base_url() ?>template/img/eliminar.png">
                                                </a>    
                                            <?php } ?> 
                                        </td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>          
                    </div>
                </td>
            </tr>
        <?php }
        /*foreach($list_examen_basico_desglosable as $list){ ?> 
            <tr class="view text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>         
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                <td class="text-left"><?php echo $list['Nombre']; ?></td>                                                     
                <td><?php echo $list['Codigo']; ?></td>   
                <td class="text-left"><?php echo $list['Email']; ?></td>     
                <td><?php echo "";//$list['cantidad']; ?></td>     
                <td><?php echo "";//$list['fecha_envio']; ?></td>       
                <td><?php echo "";//$list['hora_envio']; ?></td>       
                <td><?php echo "";//$list['fecha_termino']; ?></td>       
                <td><?php echo "";//$list['hora_termino']; ?></td>     
                <td><?php echo "";//$list['nota']; ?></td>       
                <td><?php echo "";//$list['fecha_nota']; ?></td>       
                <td><?php echo "";//$list['hora_nota']; ?></td>         
                <td><?php echo "";//$list['nom_estado']; ?></td>     
            </tr>
        <?php }*/ ?>
    </tbody>
</table>

<script>
    /*$(document).ready(function() {
        $('#example_examen_basico thead tr').clone(true).appendTo( '#example_examen_basico thead' );
        $('#example_examen_basico thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_examen_basico').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 14 ]
                }
            ]
        } );
    } );*/

    $(function(){
        $(".fold-table tr.view").on("click", function(){
            $(this).toggleClass("open").next(".fold").toggleClass("open");
        });
    });
</script>