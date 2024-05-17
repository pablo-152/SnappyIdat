<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
if($parametro==1){ ?>
    <style>
        .grande{
            width: 18px; 
            height: 18px; 
        }

        #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(2),#example tbody tr td:nth-child(3),#example tbody tr td:nth-child(5),
        #example tbody tr td:nth-child(7),#example tbody tr td:nth-child(9),#example tbody tr td:nth-child(10),#example tbody tr td:nth-child(11),
        #example tbody tr td:nth-child(12),#example tbody tr td:nth-child(13),#example tbody tr td:nth-child(14),#example tbody tr td:nth-child(15),
        #example tbody tr td:nth-child(16){ 
            text-align: center;
        }
    </style>

    <input type="hidden" id="cadena" name="cadena" value="">
    <input type="hidden" id="cantidad" name="cantidad" value="0">

    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <!--<th class="text-center" width="3%"><input type="checkbox" class="grande" id="total" name="total" value="1"></th>-->
                <th class="text-center" width="4%" title="Código">Cod</th>
                <th class="text-center" width="5%">Grupo</th>
                <th class="text-center" width="5%">Carrera</th>
                <th class="text-center" width="6%">DNI</th>  
                <th class="text-center">A.&nbsp;Paterno</th>
                <th class="text-center">A.&nbsp;Materno</th>
                <th class="text-center">Nombres</th>
                <!--<th class="text-center" width="6%" title="Examen">Examen</th>-->
                <th class="text-center" width="7%">Correo</th>
                <th class="text-center" width="6%">Estado</th>
                <th class="text-center" width="6%" title="Fecha Envío">F. Envío</th>
                <th class="text-center" width="5%">Inicio</th>
                <th class="text-center" width="5%" title="Evaluación">Eval.</th>
                <th class="text-center" width="5%">Termino</th>
                <th class="text-center" width="2%">Tiempo</th>
                <td width="5%"><div></div></td>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; foreach($list_postulantes as $list){$i++; ?>
                <tr class="even pointer">
                    <td><?php echo $list['codigo']; ?></td>
                    <td><?php echo $list['grupo']; ?></td>
                    <td title="<?php echo $list['nom_carrera']?>"><?php echo $list['abreviatura']; ?></td>
                    <td><?php echo $list['nr_documento']; ?></td>
                    <td><?php echo $list['apellido_pat']; ?></td>
                    <td style="text-align:left"><?php echo $list['apellido_mat']; ?></td>
                    <td nowrap><?php echo $list['nombres']; ?></td>
                    <!--<td><?php
                    $busqueda=in_array($list['id_examen'],array_column($list_examen,'id_examen'));
                    if($busqueda!=false){
                        $posicion = array_search($list['id_examen'], array_column($list_examen, 'id_examen'));
                        echo $list_examen[$posicion]['nom_examen'];
                    }
                    ?></td>-->
                    <td><?php echo substr($list['email'],0,20); ?></td>
                    <!--<td><?php echo $list['celular']; ?></td>-->
                    <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                    <td><?php echo $list['fecha_envio']; ?></td>
                    <td><?php if($list['estado_postulante']==31){ echo $list['tiempo_ini']; } ?></td>
                    <td><?php if($list['estado_postulante']==31){ echo $list['puntaje']; } ?></td>
                    <td><?php if($list['estado_postulante']==31){ echo $list['fecha_termino']; } ?></td>
                    <td><?php if($list['estado_postulante']==31){ echo $list['minutos_t']; } ?></td>                                       
                    <td >
                        <img title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Postulante_Efsrt') ?>/<?php echo $list["id_postulante"]; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"/>
                        <img title="Reenviar" onclick="Reenviar_Envitacion('<?php echo $list['id_postulante']; ?>')" src="<?= base_url() ?>template/img/reenviar.png" style="cursor:pointer; cursor: hand;"/>
                        <img title="Eliminar" onclick="Eliminar_Postulante_Efsrt('<?php echo $list['id_postulante']; ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>
                    </td>
                </tr>
            <?php } ?>
            <script>
                $('#total_enviado').html('Total Enviados: '+'<?php echo $i; ?>');
                $('#total_concluidos').html('');
                $('#total_pendientes').html('');
            </script>
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
                        'aTargets' : [ 0,13 ]
                    },
                    {
                        'targets' : [ 1 ],
                        'visible' : false
                    } 
                ]
            } );

            // Seleccionar todo en la tabla
            let $dt = $('#example');
            let $total = $('#total');
            let $cadena = $('#cadena');
            let $cantidad = $('#cantidad');

            // Cuando hacen click en el checkbox del thead
            $dt.on('change', 'thead input', function (evt) {
                let checked = this.checked;
                let total = 0;
                let data = [];
                let cadena='';
                
                table.data().each(function (info) {
                var txt = info[0];
                    if (checked) {
                        total += 1;
                        txt = txt.substr(0, txt.length - 1) + ' checked>';
                        cadena += info[1]+",";
                    } else {
                        txt = txt.replace(' checked', '');
                    }
                    info[0] = txt;
                    data.push(info);
                });
                
                table.clear().rows.add(data).draw();
                $cantidad.val(total);
                $cadena.val(cadena);
            });

            // Cuando hacen click en los checkbox del tbody
            $dt.on('change', 'tbody input', function() {
                let q= $('#cadena').val();
                let cantidad= $('#cantidad').val();
                let info = table.row($(this).closest('tr')).data();
                let total = parseFloat($total.val());
                let cadena = $cadena.val();
                let price = parseFloat(info[1]);
                let cadena2 = info[1]+",";
                
                if(this.checked==false){
                    q = q.replace(cadena2, "");
                    cantidad = parseFloat(cantidad)-1;
                }else{
                    q += this.checked ? cadena2 : cadena2+",";
                    cantidad = parseFloat(cantidad)+1;
                }
                $cadena.val(q);
                $cantidad.val(cantidad);
            });
        });
    </script>
<?php }else{ ?>
    <table class="table table-hover table-bordered table-striped" id="example" >
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th width="2%"><div align="center" style="Cursor:help" title="Código">Cod</div></th>
                <!--<th width="2%"><div align="center">Grupo</div></th>-->
                <th width="5%"><div align="center">Carrera</div></th>
                <th width="2%"><div align="center" style="Cursor:help">DNI</div></th>
                <th><div align="center">A.&nbsp;Paterno</div></th>
                <th><div align="center">A.&nbsp;Materno</div></th>
                <th nowrap><div align="center">Nombres</div></th>
                <!--<th width="2%"><div align="center" style="Cursor:help" title="Examen">Examen</div></th>-->
                <th><div align="center" style="Cursor:help" title="Correo de postulante">Correo</div></th>
                <!--<th width="2%"><div align="center" >Celular</div></th>-->
                <th width="2%"><div align="center">Estado</div></th>
                <th width="2%"><div align="center" style="Cursor:help" title="Fecha de envío de invitación">F.&nbsp;Envío</div></th>
                <th width="2%"><div align="center" style="Cursor:help" title="Fecha y hora cuando inició el examen">Inicio</div></th>
                <th width="2%"><div align="center" style="Cursor:help" title="Puntaje de Evaluación">Eval.</div></th>
                <th width="2%"><div align="center" style="Cursor:help" title="Puntaje de Evaluación Equivalente">Eval&nbsp;Eq.</div></th>
                <th width="2%"><div align="center" style="Cursor:help" title="Fecha y hora cuando terminó el examen">Termino</div></th>
                <th width="2%"><div align="center" style="Cursor:help" title="Tiempo que tomó resolver el examen">Tiempo</div></th>
                <td><div ></div></td>
            </tr>
        </thead>

        <tbody>
            <?php $x=0;$y=0;$z=0;$p=0; foreach($list_postulantes as $list){$x++;
                if($list['estado_postulante']==31){$y++;}
                if($list['estado_postulante']==30){$z++;}
                if($list['estado_postulante']!=31 && $list['estado_postulante']!=30){
                    $p++;
                }
                ?>
                <tr class="even pointer">
                    <td align="center"><?php echo $list['codigo']; ?></td>
                    <!--<td align="center" ><?php echo $list['grupo']; ?></td>-->
                    <td align="center" title="<?php echo $list['nom_carrera'] ?>"><?php echo $list['abreviatura']; ?></td>
                    <td align="center"><?php echo $list['nr_documento']; ?></td>
                    <td><?php echo $list['apellido_pat']; ?></td>
                    <td><?php echo $list['apellido_mat'] ?></td>
                    <td><?php echo $list['nombres'] ?></td>
                    <!--<td><?php
                    $busqueda=in_array($list['id_examen'],array_column($list_examen,'id_examen'));
                    if($busqueda!=false){
                        $posicion = array_search($list['id_examen'], array_column($list_examen, 'id_examen'));
                        echo $list_examen[$posicion]['nom_examen'];
                    }
                    ?></td>-->
                    <td ><?php echo substr($list['email'],0,32); ?></td>
                    <!--<td ><?php echo $list['celular']; ?></td>-->
                    <td align="center"><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                    <td align="center"  ><?php echo $list['fecha_envio']; ?></td>
                    <td align="center" nowrap ><?php 
                    $busqueda=in_array($list['cadena'],array_column($list_resultados,'cadena'));
                    if($busqueda!=false){
                        $posicion = array_search($list['cadena'], array_column($list_resultados, 'cadena'));
                    }
                    if($list['estado_postulante']==31 || $list['estado_postulante']==33){
                        if($busqueda!=false){
                            if($list_resultados[$posicion]['tiempo_inicio']!=""){ 
                                $mifecha = new DateTime($list_resultados[$posicion]['tiempo_ini']); 
                                //$mifecha->modify('+3 hours'); 
                                echo $mifecha->format('d/m/Y H:i');
                            }
                        }
                    } ?></td>
                    <td align="center">
                        <?php if($list['estado_postulante']==31 || $list['estado_postulante']==33){
                            if($busqueda!=false){
                                echo $list_resultados[$posicion]['puntaje'];
                            } 
                        } ?>
                    </td>
                    <td align="center"><?php if($list['estado_postulante']==31 || $list['estado_postulante']==33){ 
                        if($busqueda!=false){
                            echo $list_resultados[$posicion]['puntaje_arpay'];
                        }
                        } ?>
                    </td>
                    <td align="center" nowrap ><?php if($list['estado_postulante']==31 || $list['estado_postulante']==33){
                            if($busqueda!=false){
                                if($list_resultados[$posicion]['tiempo_inicio']!=""){
                                    $mifecha = new DateTime($list_resultados[$posicion]['fec_termino']);
                                    //$mifecha->modify('+3 hours'); 
                                    echo $mifecha->format('d/m/Y H:i');
                                }
                            }
                        } ?>
                    </td>
                    <td align="center" nowrap ><?php if($list['estado_postulante']==31 || $list['estado_postulante']==33){
                            if($busqueda!=false){
                                if($list_resultados[$posicion]['minutos_t']!=""){
                                    echo substr($list_resultados[$posicion]['minutos_t'],1,4)." hr m";
                                }
                            }
                        }  ?>
                    </td>
                    <td align="center" nowrap>
                        <img title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Postulante_Efsrt') ?>/<?php echo $list["id_postulante"]; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"/>
                        <!--<a href="javascript:void(0)" title="Reenviar" onclick="Reenviar_Envitacion('<?php echo $list['id_postulante']; ?>')" >
                            <svg style="width: 20px;height: 20px;" id="Layer_1" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g fill="#0070c0"><path fill="#0070c0" d="M491,176.2L261.3,334.6c-1.6,1.1-3.5,1.7-5.3,1.7s-3.7-0.6-5.3-1.7L21,176.2c-9.1,7.2-15,18.3-15,30.9v239.7   c0,21.7,17.6,39.3,39.3,39.3h421.3c21.7,0,39.3-17.6,39.3-39.3V207C506,194.5,500.1,183.4,491,176.2z M187.1,330.2L71,446.3   c-0.9,0.9-2.1,1.4-3.3,1.4c-1.2,0-2.4-0.5-3.3-1.4c-1.8-1.8-1.8-4.8,0-6.6l116.1-116.1c1.8-1.8,4.8-1.8,6.6,0   C189,325.4,189,328.4,187.1,330.2z M447.6,446.3c-0.9,0.9-2.1,1.4-3.3,1.4s-2.4-0.5-3.3-1.4L324.9,330.2c-1.8-1.8-1.8-4.8,0-6.6   s4.8-1.8,6.6,0l116.1,116.1C449.4,441.5,449.4,444.5,447.6,446.3z"></path><g><rect height="14" width="216" x="148" y="209.2" fill="#0070c0" id="XMLID_6_"></rect><polygon points="148,241 162.3,250.9 349.7,250.9 364,241 364,236.9 148,236.9" fill="#0070c0" id="XMLID_5_"></polygon><rect height="14" width="216" x="148" y="181.5" style="color: #0070c0;" id="XMLID_4_" fill="#0070c0"></rect><path d="M464,163.8L271,30.6c-9.1-6.2-21-6.2-30.1,0L48,163.8c-2.9,2-2.9,6.2,0,8.2l64,44.2v-77.8h288v77.8l64-44.2    C466.9,170,466.9,165.8,464,163.8z" id="XMLID_3_"></path><polygon points="182.1,264.5 202.4,278.5 309.6,278.5 329.9,264.5   " fill="#0070c0" id="XMLID_2_"></polygon><path d="M289.8,292.2h-67.5l18.7,12.9c0.6,0.4,1.1,0.7,1.7,1.1h26.7c0.6-0.3,1.1-0.7,1.7-1.1L289.8,292.2z" fill="#0070c0" id="XMLID_1_"></path></g></g></svg>
                        </a>-->
                        <?php if($sesion['id_usuario']==1){ ?>
                            <a href="javascript:void(0)" class="" title="Eliminar" onclick="Delete_Postulante('<?php echo $list['id_postulante']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            <?php if($parametro==2){?> 
            <script>
                $('#total_enviado').html('Total Concluidos: '+'<?php echo $x; ?>');
                $('#total_concluidos').html('');
                $('#total_pendientes').html('');
            </script>    
            <?php }if($parametro==3){?> 
            <script>
                $('#total_enviado').html('Total Enviados: '+'<?php echo $z; ?>');
                $('#total_concluidos').html('Total Concluidos: '+'<?php echo $y; ?>');
                $('#total_pendientes').html('Total Pendientes: '+'<?php echo $p; ?>');
            </script>    
            <?php }?>
            
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
<?php } ?>