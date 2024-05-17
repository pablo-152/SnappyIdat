<table class="table table-hover table-bordered table-striped" id="example_evaluacion_basica" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Ap. Paterno</th> 
            <th class="text-center" width="8%">Ap. Materno</th>   
            <th class="text-center" width="10%">Nombre(s)</th>  
            <th class="text-center" width="5%" title="Código">Cod</th>
            <th class="text-center" width="8%" colspan="2">CB Teoricos</th> 
            <th class="text-center" width="7%">Fecha Ex.</th>   
            <th class="text-center" width="9%">Evaluador</th>  
            <th class="text-center" width="10%" colspan="3">CB Practicos</th>
            <th class="text-center" width="18%" colspan="5">Presentación Personal</th> 
            <th class="text-center" width="5%">Final</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_evaluacion_basica as $list){ ?>                                             
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>         
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>                                                     
                <td><?php echo $list['cod_alumno']; ?></td>   
                <td><?php echo $list['puntaje_teorico']; ?></td>         
                <td><?php echo number_format($list['teorico'],2); ?></td>         
                <td><?php echo $list['fecha']; ?></td>         
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>         
                <td><?php echo $list['puntaje_practico_1']; ?></td>         
                <td><?php echo $list['puntaje_practico_2']; ?></td>         
                <td><?php echo number_format($list['practico'],2); ?></td>         
                <td><?php echo $list['puntaje_presentacion_personal_1']; ?></td>         
                <td><?php echo $list['puntaje_presentacion_personal_2']; ?></td>         
                <td><?php echo $list['puntaje_presentacion_personal_3']; ?></td>         
                <td><?php echo $list['puntaje_presentacion_personal_4']; ?></td>         
                <td><?php echo number_format($list['presentacion_personal'],2); ?></td>         
                <td><?php echo number_format($list['final'],2); ?></td>         
                <td><?php echo $list['nom_estado']; ?></td>         
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal" 
                    app_crear_per="<?= site_url('AppIFV/Modal_Evaluacion_Basica_Efsrt') ?>/<?php echo $list['id_evaluacion']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>    

                    <?php if($list['documento']!=""){ ?>
                        <a title="Descargar" href="<?= site_url('AppIFV/Descargar_Evaluacion_Basica_Efsrt') ?>/<?php echo $list['id_evaluacion'] ?>"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a> 
                    <?php } ?> 

                    <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || 
                    $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85){ ?>
                        <a title="Eliminar" onclick="Delete_Evaluacion_Basica('<?php echo $list['id_evaluacion']; ?>')">
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
        $('#example_evaluacion_basica thead tr').clone(true).appendTo( '#example_evaluacion_basica thead' );
        $('#example_evaluacion_basica thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_evaluacion_basica').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 18 ]
                }
            ]
        } );
    } );
</script>