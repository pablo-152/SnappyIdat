<table class="table table-hover table-bordered table-striped" id="example_induccion" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="12%">Ap. Paterno</th>
            <th class="text-center" width="12%">Ap. Materno</th>    
            <th class="text-center" width="15%">Nombre(s)</th> 
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="8%">Fecha Charla</th>
            <th class="text-center" width="5%">Hora</th>
            <th class="text-center" width="10%">Ponente</th> 
            <th class="text-center" width="10%">Usuario</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_induccion as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>         
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>                                                     
                <td><?php echo $list['cod_alumno']; ?></td>   
                <td><?php echo $list['fecha_charla']; ?></td>     
                <td><?php echo $list['hora_charla']; ?></td>       
                <td class="text-left"><?php echo $list['ponente']; ?></td>    
                <td class="text-left"><?php echo $list['usuario']; ?></td>    
                <td><?php echo $list['fecha']; ?></td>       
                <td><?php echo $list['nom_estado']; ?></td>    
                <td>
                    <a title="Descargar" href="<?= site_url('AppIFV/Descargar_Induccion_Efsrt') ?>/<?php echo $list['id_induccion'] ?>"> 
                        <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>

                    <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || 
                    $_SESSION['usuario'][0]['id_usuario']==7){ ?>
                        <a title="Eliminar" onclick="Delete_Induccion('<?php echo $list['id_detalle']; ?>')">
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
        $('#example_induccion thead tr').clone(true).appendTo( '#example_induccion thead' );
        $('#example_induccion thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_induccion').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 10 ]
                }
            ]
        } );
    } );
</script>