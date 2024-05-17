<table id="example_sec" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="22%">Apellido Paterno</th> 
            <th class="text-center" width="22%">Apellido Materno</th>
            <th class="text-center" width="22%">Nombre</th>
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="14%">Sección</th>
            <th class="text-center" width="12%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_seccion as $list){ ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['alum_apater']; ?></td> 
                <td class="text-left"><?php echo $list['alum_amater']; ?></td> 
                <td class="text-left"><?php echo $list['alum_nom']; ?></td> 
                <td><?php echo $list['cod_alum']; ?></td>  
                <td><?php echo $list['nom_seccion']; ?></td>  
                <td class="text-left"><?php echo $list['estado_matricula']; ?></td>  
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_sec thead tr').clone(true).appendTo('#example_sec thead');
        $('#example_sec thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example_sec').DataTable({
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                }
            ]
        });
    });
</script>