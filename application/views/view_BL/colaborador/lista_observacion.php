<input type="hidden" id="nivel_actual" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>">

<table id="example_obs" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center">Fecha</th> 
            <th class="text-center" width="10%">Fecha</th>
            <th class="text-center" width="10%">Tipo</th>  
            <th class="text-center" width="10%">Usuario</th> 
            <th class="text-center">Comentario</th>
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
                    <a title="Eliminar" onclick="Delete_Observacion_Colaborador('<?php echo $list['id_observacion']; ?>')" target="_blank">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
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

    var nivel_actual = $("#nivel_actual").val();

    if(nivel_actual==1 || nivel_actual==6){
        var table = $('#example_obs').DataTable({
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
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
                    'aTargets' : [ 4 ]
                },
                {
                    'targets' : [ 0,5 ],
                    'visible' : false
                } 
            ]
        });
    }
</script>
