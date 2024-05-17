<table class="table table-hover table-bordered table-striped" id="example_pago" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="20%">Banco</th>
            <th class="text-center" width="70%">Cuenta Bancaria</th>
            <th class="text-center" width="10%">Estado</th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_pago as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['banco']; ?></td>
                <td class="text-left"><?php echo $list['cuenta_bancaria']; ?></td> 
                <td><?php echo $list['estado']; ?></td>    
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $(document).ready(function() {
        $('#example_pago thead tr').clone(true).appendTo( '#example_pago thead' );
        $('#example_pago thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_pago').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 2 ]
                }
            ]
        } );
    });
</script>