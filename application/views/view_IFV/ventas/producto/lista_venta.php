<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="9%">Código Venta</th>
            <th class="text-center" width="8%">Código</th> 
            <th class="text-center" width="25%">Apellido Paterno</th>  
            <th class="text-center" width="25%">Apellido Materno</th>
            <th class="text-center" width="25%">Nombre(s)</th>
            <th class="text-center" width="8%">Cantidad</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_venta as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['Codigo']; ?></td> 
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['cantidad']; ?></td> 
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
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    });
</script>