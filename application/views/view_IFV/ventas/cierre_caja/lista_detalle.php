<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Código</th> 
            <th class="text-center" width="12%">Apellido Paterno</th> 
            <th class="text-center" width="12%">Apellido Materno</th> 
            <th class="text-center" width="16%">Nombre(s)</th> 
            <th class="text-center" width="12%">Descripción</th> 
            <th class="text-center" width="8%">Total</th> 
            <th class="text-center" width="14%">Recibo Electrónico</th> 
            <th class="text-center" width="8%">Fecha Pago</th> 
            <th class="text-center" width="10%">Efectuado Por</th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_detalle_cierre_caja as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['cod_producto']; ?></td>
                <td class="text-right"><?php echo "s/. ".$list['total']; ?></td>
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['fecha_pago']; ?></td> 
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>                           
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    });
</script>