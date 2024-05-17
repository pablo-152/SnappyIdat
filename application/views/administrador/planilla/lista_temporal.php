<table id="example_<?= $tipo; ?>" class="table table-hover table-bordered">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="60%">Descripción</th>
            <th class="text-center" width="35%">Monto</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_temporal as $list){ ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['descripcion']; ?></td> 
                <td><?php echo $list['monto']; ?></td> 
                <td>
                    <a title="Eliminar" onclick="Delete_Temporal_Modal('<?= $list['id']; ?>','<?= $tipo; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_<?= $tipo; ?> thead tr').clone(true).appendTo('#example_<?= $tipo; ?> thead');
        $('#example_<?= $tipo; ?> thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example_<?= $tipo; ?>').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 2 ]
                }
            ]
        });
    });
</script>