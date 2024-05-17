<!--<table class="table table-hover table-bordered table-striped" id="example_ingreso" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="15%">Tipo</th>
            <th class="text-center" width="15%">Recibo Electrónico</th>
            <th class="text-center" width="15%">Total</th>
            <th class="text-center" width="15%">Talonario</th>  
            <th class="text-center" width="15%">Numero Recibo</th>
            <th class="text-center" width="10%">Fecha Pago</th>
            <th class="text-center" width="15%">Empleado Pago</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_detalle_cierre_caja as $list){ ?>                                             
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td><?php echo $list['cod_venta']; ?></td>
                <td class="text-right"><?php echo "s/. ".$list['total']; ?></td> 
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['fecha_pago']; ?></td> 
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>                           
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() { 
        $('#example_ingreso thead tr').clone(true).appendTo( '#example_ingreso thead' );
        $('#example_ingreso thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_ingreso').DataTable( { 
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    });
</script>-->

<table class="table table-hover table-bordered table-striped" id="example_ingreso" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="10%">Apellido Paterno</th>
            <th class="text-center" width="10%">Apellido Materno</th>
            <th class="text-center" width="12%">Nombre(s)</th>   
            <th class="text-center" width="16%">Producto</th>
            <th class="text-center" width="6%">Precio</th>
            <th class="text-center" width="6%">Cantidad</th>
            <th class="text-center" width="8%">Total</th>
            <th class="text-center" width="8%">Recibo Electrónico</th>
            <th class="text-center" width="8%">Fecha Pago</th>
            <th class="text-center" width="8%">Efectuado Por</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_ingreso as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['cod_producto']; ?></td>
                <td class="text-right"><?php echo "s/. ".$list['precio']; ?></td>
                <td><?php echo $list['cantidad']; ?></td>
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
        $('#example_ingreso thead tr').clone(true).appendTo( '#example_ingreso thead' );
        $('#example_ingreso thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_ingreso').DataTable( { 
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 10 ]
                }
            ]
        } );
    });
</script>