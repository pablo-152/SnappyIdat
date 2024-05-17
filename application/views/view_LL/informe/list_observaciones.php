<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];?>
<table id="tabla_obs2" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" style="display:none">Fecha</th>
            <th class="text-center" width="3%">Fecha</th>
            <th class="text-center" width="10%">Tipo</th>  
            <th class="text-center" width="5%">Usuario</th> 
            <th class="text-center" width="80%">Comentario</th>
            <td class="text-center" width="5%"></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_obs as $list) {  ?>
            <tr class="even pointer">
                <td class="text-left" style="display:none"><?php echo $list['fecha_registro']; ?></td>
                <td class="text-left" nowrap><?php echo $list['fecha_registro2']; ?></td>
                <td><?php echo $list['nom_tipo']; ?></td> 
                <td><?php echo $list['usuario_codigo']; ?></td>  
                <td class="text-left"><?php echo $list['observacion']; ?></td>
                <td width="1%" >
                    <?php if($sesion['id_nivel']==1 || $sesion['id_nivel']==6){ ?>
                    <a style="cursor:pointer" onclick="Delete_Observacion_LL('<?php echo $list['id_observacion']; ?>','<?php echo $list['id_alumno'] ?>')" target="_blank" title="Eliminar">
                    <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody> 
</table>
<script>
    $(document).ready(function() {
        $('#tabla_obs2 thead tr').clone(true).appendTo('#tabla_obs2 thead');
        $('#tabla_obs2 thead tr:eq(1) th').each(function(i) { 
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

        var table = $('#tabla_obs2').DataTable({
            order: [0,"desc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ] 
                }
            ]
        });
    } );
</script>
