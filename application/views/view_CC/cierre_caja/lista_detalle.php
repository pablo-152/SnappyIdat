<table class="table table-hover table-bordered table-striped" id="example" width="100%">
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
                <td><?php echo $list['nom_tipo']; ?></td>
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
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    });
</script>