<form method="post" id="formulario_examen_efsrt" enctype="multipart/form-data" class="formulario">
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr>
                <th>Orden</th>
                <th width="3%" class="text-center"></th>
                <th width="25%" class="text-center">Descripción</th>
                <th width="8%" class="text-center" title="Fecha Examen">Fec. Examen</th>
                <th width="8%" class="text-center" title="Fecha Publicación">Fec. Publi.</th>
                <th width="7%" class="text-center">Contenido</th>
                <th width="6%" class="text-center">Enviados</th>
                <th width="7%" class="text-center">Sin Iniciar</th>
                <th width="7%" class="text-center">Sin Concluir</th>
                <th width="6%" class="text-center">Concluidos</th>
                <th width="6%" class="text-center">Tiempo</th>
                <th width="6%" class="text-center">Evaluación</th>
                <th width="6%" class="text-center">Estado</th>
                <th width="5%" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_examen2 as $list) {  ?>                                           
                <tr class="even pointer text-center">    
                    <td><?php echo $list['fec_limite']; ?></td>
                    <td><input type="checkbox" id="id_examen[]" name="id_examen[]" value="<?php echo $list['id_examen']; ?>"></td>                                
                    <td class="text-left"><?php echo $list['nom_examen']; ?></td>
                    <td><?php echo $list['fecha_limite']; ?></td>
                    <td><?php echo $list['fecha_resultados']; ?></td>
                    <td><span class='badge <?php if($list['estado_contenido']==0){echo "badge-info";}?>' style='<?php if($list['estado_contenido']==1){echo "background-color: #92D050;border-color: #92D050;";} ?>'><?php echo $list['desc_estado_contenido'] ?> </span>
                    </td>
                    <td><?php echo $list['Enviados']; ?></td>
                    <td><?php echo $list['Sin Iniciar']; ?></td>
                    <td><?php echo $list['Sin Concluir'] ?></td>
                    <td><?php echo $list['Concluido']; ?></td>
                    <td>
                        <!--<?php
                            foreach($list_examen3 as $list1){
                                if($list1['id_examen']==$list['id_examen']){
                                    echo substr($list1['Tiempo'],0,8); 
                                }
                            }
                        ?>-->
                    </td>
                    <td>
                        <?php echo $list['promedio']
                            /*foreach($list_examen3 as $list1){
                                if($list1['id_examen']==$list['id_examen']){
                                    echo substr($list1['Evaluacion'],0,2); 
                                }
                            } */
                        ?>
                    </td>
                    <td><?php echo $list['nom_status']; if($list['Concluido']>0){echo " - Terminado";} ?></td>
                    <td>
                        <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Examen_Efsrt_IFV') ?>/<?php echo $list['id_examen']; ?>">
                            <img src="<?= base_url() ?>template/img/editar.png">
                        </a>
                        
                        <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Examen_Efsrt') ?>/<?php echo $list['id_examen']; ?>">
                            <img title="Más Información" src="<?= base_url() ?>template/img/ver.png">
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>
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
            order: [0,"desc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 1,13 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>