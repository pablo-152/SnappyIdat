<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Código</th>
            <th class="text-center" width="35%">Tipo</th>
            <th class="text-center" width="35%">Descripción</th>
            <th class="text-center" width="12%">Talla/Ref</th> 
            <th class="text-center" width="8%">Stock</th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_stock as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['stock_total']; ?></td>                                                       
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 4 ]
                }
            ]
        } );
    });
</script>