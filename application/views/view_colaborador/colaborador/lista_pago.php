<table class="table table-hover table-bordered table-striped" id="example_pago" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="5%" title="Pedido">Ped.</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="10%">Sub-rubro</th>
            <th class="text-center" width="23%">Descripción</th>
            <th class="text-center" width="8%">Monto</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="8%" title="Aprobado Por Usuario">Apro.</th>
            <th class="text-center" width="9%" title="Fecha Aprobación">Fecha A.</th>
            <th class="text-center" width="9%" title="Fecha Entrega Monto">Fecha E.</th>
            <th class="text-center" width="10%" title="Tipo Documento">Tipo D.</th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_pago as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['pedido']; ?></td>
                <td class="text-left"><?php echo $list['tipo']; ?></td>  
                <td class="text-left"><?php echo $list['subrubro']; ?></td>  
                <td class="text-left"><?php echo $list['descripcion']; ?></td>  
                <td class="text-right"><?php echo "s/. ".$list['monto']; ?></td>  
                <td><?php echo $list['estado']; ?></td>  
                <td class="text-left"><?php echo $list['aprobado_por']; ?></td>  
                <td><?php echo $list['fecha_aprobacion']; ?></td>  
                <td><?php echo $list['fecha_entrega']; ?></td>  
                <td class="text-left"><?php echo $list['tipo_documento']; ?></td>  
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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 9 ]
                }
            ]
        } );
    });
</script>