<table class="table table-hover table-bordered table-striped" id="example" >
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="4%" title="Código">Cod</th>
            <th width="4%">Carrera</th>
            <th width="8%">DNI</th>
            <th width="10%">A.&nbsp;Paterno</th>
            <th width="10%">A.&nbsp;Materno</th>
            <th width="10%">Nombres</th>
            <th width="12%" title="Correo de postulante">Correo</th>
            <th width="6%">Estado</th>
            <th width="6%" title="Fecha de envío de invitación">F.&nbsp;Envío</th>
            <th width="6%" title="Fecha y hora cuando inició el examen">Inicio</th>
            <th width="5%" title="Puntaje de Evaluación">Eval.</th>
            <th width="5%" title="Puntaje de Evaluación Equivalente">Eval&nbsp;Eq.</th>
            <th width="5%" title="Fecha y hora cuando terminó el examen">Termino</th>
            <th width="5%" title="Tiempo que tomó resolver el examen">Tiempo</th>
            <td width="4%"></td>
        </tr>
    </thead>

    <tbody>
        <?php $x=0;$y=0;$z=0;$p=0; foreach($list_postulantes as $list){$x++;
            if($list['estado_postulante']==31){$y++;}
            if($list['estado_postulante']==30){$z++;}
            if($list['estado_postulante']!=31 && $list['estado_postulante']!=30 && $list['estado_postulante']!=4){
                $p++;
            }
            ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>
                <td title="<?php echo $list['nom_carrera'] ?>"><?php echo $list['abreviatura']; ?></td>
                <td><?php echo $list['nr_documento']; ?></td>
                <td><?php echo $list['apellido_pat']; ?></td>
                <td><?php echo $list['apellido_mat'] ?></td>
                <td><?php echo $list['nombres'] ?></td>
                <td><?php echo substr($list['email'],0,32); ?></td>
                <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                <td><?php echo $list['fecha_envio']; ?></td>
                <td>
                    <?php 
                        $busqueda=in_array($list['cadena'],array_column($list_resultados,'cadena'));
                        if($busqueda!=false){
                            $posicion = array_search($list['cadena'], array_column($list_resultados, 'cadena'));
                        }
                        if($list['estado_postulante']==31 || $list['estado_postulante']==33 || $list['estado_postulante']==4){
                            if($busqueda!=false){
                                if($list_resultados[$posicion]['tiempo_inicio']!=""){ 
                                    $mifecha = new DateTime($list_resultados[$posicion]['tiempo_ini']); 
                                    echo $mifecha->format('d/m/Y H:i');
                                }
                            }
                        } 
                    ?>   
                </td>
                <td>
                    <?php if($list['estado_postulante']==31 || $list['estado_postulante']==33 || $list['estado_postulante']==4){
                        if($busqueda!=false){
                            echo $list_resultados[$posicion]['puntaje'];
                        } 
                    } ?>
                </td>
                <td><?php if($list['estado_postulante']==31 || $list['estado_postulante']==33 || $list['estado_postulante']==4){ 
                    if($busqueda!=false){
                        echo $list_resultados[$posicion]['puntaje_arpay'];
                    }
                    } ?>
                </td>
                <td ><?php if($list['estado_postulante']==31 || $list['estado_postulante']==33 || $list['estado_postulante']==4){
                        if($busqueda!=false){
                            if($list_resultados[$posicion]['tiempo_inicio']!=""){
                                $mifecha = new DateTime($list_resultados[$posicion]['fec_termino']);
                                //$mifecha->modify('+3 hours'); 
                                echo $mifecha->format('d/m/Y H:i');
                            }
                        }
                    } ?>
                </td>
                <td ><?php if($list['estado_postulante']==31 || $list['estado_postulante']==33 || $list['estado_postulante']==4){
                        if($busqueda!=false){
                            if($list_resultados[$posicion]['minutos_t']!=""){
                                echo substr($list_resultados[$posicion]['minutos_t'],1,4)." hr m";
                            }
                        }
                    }  ?>
                </td>
                <td>
                    <a title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Update_Postulante_Efsrt') ?>/<?php echo $list['id_postulante']; ?>">
                        <img   src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    
                    <?php if($_SESSION['usuario'][0]['id_usuario']==1){ ?>
                        <a href="javascript:void(0)" title="Eliminar" onclick="Delete_Postulante('<?php echo $list['id_postulante']; ?>')"> 
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        <?php if($parametro==2){ ?> 
            <script>
                $('#total_enviado').html('Total Concluidos: '+'<?php echo $x; ?>');
                $('#total_concluidos').html('');
                $('#total_pendientes').html('');
            </script>    
        <?php }if($parametro==3){ ?> 
            <script>
                $('#total_enviado').html('Total Enviados: '+'<?php echo $z; ?>');
                $('#total_concluidos').html('Total Concluidos: '+'<?php echo $y; ?>');
                $('#total_pendientes').html('Total Pendientes: '+'<?php echo $p; ?>');
            </script>    
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

        var table = $('#example').DataTable( {
            order: [2,"asc"],
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
    });
</script>