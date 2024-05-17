<table id="example_obs" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center">Fecha</th>
            <th class="text-center" width="10%">Fecha</th>
            <th class="text-center" width="10%">Tipo</th>  
            <th class="text-center" width="10%">Usuario</th> 
            <th class="text-center">Comentario</th>
            <th class="text-center">Documento</th>
            <td class="text-center" width="5%"></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_observacion as $list) {  ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['nom_tipo']; ?></td> 
                <td class="text-left"><?php echo $list['usuario']; ?></td> 
                <td class="text-left"><?php echo $list['observacion']; ?></td>
                <td>
                <?php if($list['observacion_archivo'] == "" ){

                }else{?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_observacion']?>">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                <?php }?>
                </td>
                <td>
                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || 
                    $_SESSION['usuario'][0]['id_usuario']==85 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a href="javascript:void(0)" title="Eliminar" onclick="Delete_Observacion_Colaborador('<?php echo $list['id_observacion']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_ArchivoOC/" + image_id);
    });
    
    $('#example_obs thead tr').clone(true).appendTo('#example_obs thead'); 
    $('#example_obs thead tr:eq(1) th').each(function(i) { 
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

    var nivel_actual = <?= $_SESSION['usuario'][0]['id_nivel']; ?>;

    if(nivel_actual==1 || nivel_actual==6){
        var table = $('#example_obs').DataTable({
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    }else{
        var table = $('#example_obs').DataTable({
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                },
                {
                    'targets' : [ 0,6 ],
                    'visible' : false
                } 
            ]
        });
    }
</script>
