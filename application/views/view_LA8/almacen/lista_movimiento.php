<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center">Orden</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="8%">Tipo</th> 
            <th class="text-center" width="12%">De/Para</th>
            <th class="text-center" width="5%">Código</th>
            <th class="text-center" width="9%">Ap. Paterno</th> 
            <th class="text-center" width="9%">Ap. Materno</th>  
            <th class="text-center" width="13%">Nombre</th> 
            <th class="text-center" width="6%" title="Tipo Recibo">T. Recibo</th> 
            <th class="text-center" width="8%">Recibo</th>
            <th class="text-center" width="7%">Cantidad</th>
            <th class="text-center" width="7%">Saldo</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_movimiento_almacen as $list){ ?>                                           
            <tr class="even pointer text-center"> 
                <td><?php echo $list['fec_reg']; ?></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['tipo_movimiento']; ?></td>
                <td class="text-left"><?php echo $list['de_para']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Ap_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Ap_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['nom_tipo_documento']; ?></td>
                <td><?php echo $list['cod_venta']; ?></td>
                <td style="background-color:#DEEBF7;"><?php echo $list['cantidad']; ?></td>  
                <td><?php echo $list['saldo']; ?></td>                                 
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
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50, 
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 10 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>