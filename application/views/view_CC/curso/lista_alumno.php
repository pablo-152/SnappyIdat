<table id="example_alu" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Codigo</th>
            <th class="text-center" width="20%">Nombres</th>
            <th class="text-center" width="20%">A. Paterno</th>
            <th class="text-center" width="20%">A. Materno</th>
            <th class="text-center" width="20%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_alumno_curso as $list){ ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_alum']; ?></td>    
                <td class="text-left"><?php echo $list['alum_nom']; ?></td> 
                <td class="text-left"><?php echo $list['alum_apater']; ?></td>
                <td class="text-left"><?php echo $list['alum_amater']; ?></td>
                <td class="text-left"><?php echo $list['nom_estadoa']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#example_alu thead tr').clone(true).appendTo('#example_alu thead');
    $('#example_alu thead tr:eq(1) th').each(function(i) {
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

    var table = $('#example_alu').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 4 ]
                }
            ]
    });
</script>