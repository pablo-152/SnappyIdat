<input type="hidden" id="usuario_actual" value="<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>">
<input type="hidden" id="nivel_actual" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>"> 

<table class="table table-hover table-bordered table-striped" id="example" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Fecha Inicio</th>
            <th class="text-center" width="5%">Cod</th> 
            <th class="text-center" width="4%">Grupo</th> 
            <th class="text-center" title="Especialidad">Esp.</th> 
            <th class="text-center" width="4%" title="Módulo">Mod.</th>
            <th class="text-center" width="4%" title="Ciclo">Cic.</th>
            <th class="text-center" width="5%">Turno</th> 
            <th class="text-center" width="3%" title="Sección">Sec.</th> 
            <th class="text-center" width="6%" title="Salón">Sal.</th>
            <th class="text-center" width="4%" title="Semana">Sem.</th>
            <th class="text-center" width="6%">Inicio</th>
            <th class="text-center" width="6%">Termino</th>
            <th class="text-center" width="4%" title="Matriculados">Mat.</th>
            <th class="text-center" width="4%" title="Disponible">Dis.</th>
            <th class="text-center" width="4%" title="Promovidos">Pro.</th> 
            <th class="text-center" width="4%" title="Retirados">Ret.</th> 
            <th class="text-center" width="4%" title="Documentos">Docs</th> 
            <th class="text-center" width="4%" title="Matricula">Mat</th> 
            <th class="text-center" width="4%" title="% Matricula">%Mat</th> 
            <th class="text-center" width="4%" title="% Cuota">%Cta</th> 
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_grupo as $list){ ?> 
            <?php
                $background = '';
                //if($tipo==1){
                    if($list['nom_estado_grupo']=='Finalizado' and abs($list['diferencia_dias'])<=42) 
                    {$background = '#FBE5D6';}
                    //if($list['diferencia_dias']<=42) {$background = '#92d050';}
                    if($list['nom_estado_grupo']=='Sin Iniciar') {$background = '#E9EEF3';}
                    //if($list['nom_estado_grupo']=='Sigue Activo') {$background = '#fff';}
                //}
            ?> 
            <tr class="even pointer text-center" style="background-color:<?=$background?>">
                <td><?php echo $list['inicio_clase']; ?></td>
                <td><?php echo $list['cod_grupo']; ?></td> 
                <td><?php echo $list['grupo']; ?></td>
                <td class="text-center"><?php echo $list['abreviatura'] ?></td>
                <td><?php echo $list['modulo']; ?></td>
                <td><?php echo $list['ciclo']; ?></td>
                <td class="text-left"><?php echo $list['nom_turno']; ?></td>
                <td class="text-center"><?php echo $list['id_seccion']; ?></td>
                <td class="text-left"><?php echo $list['nom_salon']; ?></td>
                <td class="text-center"><?php echo "Sem ".$list['semana']; ?></td>
                <td><?php echo $list['ini_clases']; ?></td>
                <td><?php echo $list['fin_clases']; ?></td>
                <td><?php echo $list['matriculados']; ?></td>
                <td><?php if($list['id_salon']==0){ echo ""; }else{ echo ($list['capacidad']-$list['matriculados']); } ?></td>
                <td><?php echo $list['promovidos']; ?></td>
                <td><?php echo $list['retirados']; ?></td>
                <td><?php echo $list['docs']; ?></td>
                <td><?php echo $list['s_matriculados']; ?></td>
                <td><?php if($list['matriculados']==0){ echo "0.00"; }else{ echo number_format((($list['pago_matricula']*100)/$list['matriculados']),2); } ?></td>
                <td><?php if($list['matriculados']==0){ echo "0.00"; }else{ echo number_format((($list['pago_cuota']*100)/$list['matriculados']),2); } ?></td>
                <td class="text-center">
                    <?php 
                        $estado = $list['nom_estado_grupo'];
                        $color = $list['colorgrupo'];
                        echo '<span class="badge" style="background-color: ' . $color . ';">' . $estado . '</span>';
                    ?>
                </td>
                <td>
                    <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Grupo_C') ?>/<?php echo $list['id_grupo']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png">
                    </a>

                    <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || 
                    $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85){ ?>
                        <a title="Eliminar" onclick="Delete_Grupo_C('<?php echo $list['id_grupo']; ?>')">
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
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
 
            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var usuario_actual = $('#usuario_actual').val();
        var nivel_actual = $('#nivel_actual').val();

        if(nivel_actual==1 || nivel_actual==6 || nivel_actual==12){
            var table = $('#example').DataTable({
                order: [[0,"asc"],[3,"asc"],[5,"asc"],[6,"asc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 21 ]
                    },
                    {
                        'targets' : [ 0 ],
                        'visible' : false
                    } 
                ]
            });
        }else{
            var table = $('#example').DataTable({
                order: [[0,"asc"],[3,"asc"],[5,"asc"],[6,"asc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : true,
                        'aTargets' : [ 20 ]
                    },
                    {
                        'targets' : [ 0,21 ],
                        'visible' : false
                    } 
                ]
            });
        }
    });
</script>