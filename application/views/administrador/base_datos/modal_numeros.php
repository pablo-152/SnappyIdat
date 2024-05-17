<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Números (Lista)</b></h5>
</div>

<div class="modal-body" style="max-height:520px; overflow:auto;">
    <div class="col-md-12 row">
        <table class="table table-hover table-bordered table-striped" id="example_numero" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Número</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach($list_numeros as $list){ ?>
                    <tr>
                        <td><?php echo $list['numero']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> 

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
    </button>
</div>

<script>
    $(document).ready(function() {
        $('#example_numero thead tr').clone(true).appendTo('#example_numero thead');
        $('#example_numero thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example_numero').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 10,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 0 ]
                } 
            ]
        });
    });
</script>