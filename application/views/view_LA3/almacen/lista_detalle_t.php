<style>
    .color_total{
        background-color: #CCC !important;
        border: 1px solid #CCC;
    }
</style>

<table class="table table-hover table-bordered table-striped" width="100%">
    <thead> 
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Código</th> 
            <th class="text-center" width="20%">Tipo</th>
            <th class="text-center" width="20%">Descripción</th> 
            <th class="text-center" width="20%">Talla/Ref.</th>
            <th class="text-center" width="10%">Stock</th>
            <th class="text-center" width="10%">Transferido</th> 
        </tr>
    </thead>

    <tbody>
        <?php $total = 0; foreach($list_detalle as $list){ ?>                                           
            <tr class="even pointer text-center"> 
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['stock']; ?></td> 
                <td><?php echo $list['transferido']; ?></td>                                  
            </tr>
        <?php $total=$total+$list['transferido']; } ?>
        <tr class="even pointer text-center">  
                <td colspan="5"></td>
                <td class="color_total"><?php echo $total; ?></td>                                  
            </tr>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_detalle thead tr').clone(true).appendTo( '#example_detalle thead' );
        $('#example_detalle thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_detalle').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 10000,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    });
</script>