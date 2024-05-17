<table id="example_foto" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Id</th>
            <th class="text-center" width="20%">Descripción</th> 
            <th class="text-center" width="20%">Nombre Documento</th>
            <th class="text-center" width="20%">Subido Por</th> 
            <th class="text-center" width="15%">Fecha</th>
            <th class="text-center" width="5%"></th> 
        </tr>
    </thead>
    
    <tbody>
        <?php $i=count($list_foto); foreach($list_foto as $list){ ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['id_foto']; ?></td>  
                <td class="text-left"><?php echo "Foto ".$i; ?></td> 
                <td class="text-left"><?php echo $list['foto']; ?></td>  
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>  
                <td><?php echo $list['fecha']; ?></td> 
                <td>
                    <a onclick="Descargar_Foto_Matriculados('<?php echo $list['id_foto']; ?>');">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>

                    <?php if($_SESSION['usuario'][0]['id_nivel']==1){ ?>
                        <a onclick="Delete_Foto_Matriculados('<?php echo $list['id_foto']; ?>')">
                            <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php $i--; } ?>
    </tbody>
</table>

<script>
    $('#example_foto thead tr').clone(true).appendTo('#example_foto thead');
    $('#example_foto thead tr:eq(1) th').each(function(i) {
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

    var table = $('#example_foto').DataTable({
        order: [0,"asc"],
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
</script>