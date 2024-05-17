<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="8%" title="Apellido Paterno">A. Paterno</th>  
            <th class="text-center" width="8%" title="Apellido Materno">A. Materno</th> 
            <th class="text-center" width="10%">Nombre(s)</th>  
            <th class="text-center" width="8%">Código</th> 
            <th class="text-center" width="8%">Grado</th> 
            <th class="text-center" width="8%">Sección</th> 
            <th class="text-center" width="16%">Descripción</th>  
            <th class="text-center" width="6%">Monto</th>
            <th class="text-center" width="6%" title="Descuento">Desc.</th>
            <th class="text-center" width="6%" title="Penalidad">Pena.</th>
            <th class="text-center" width="6%">Total</th> 
            <th class="text-center" width="6%" title="Fecha Pago">Fecha P.</th>
            <th class="text-center" width="4%">Recibo</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_detalle_pagamento as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['alum_apater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_amater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_nom']; ?></td>   
                <td><?php echo $list['cod_alum']; ?></td>   
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>     
                <td class="text-left"><?php echo $list['nom_seccion']; ?></td>  
                <td class="text-left"><?php echo $list['nom_pago']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['monto']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['descuento']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['penalidad']; ?></td> 
                <td class="text-right"><?php echo "s./ ".$list['total']; ?></td>
                <td><?php echo $list['fec_pago']; ?></td> 
                <td><?php echo $list['recibo']; ?></td>                                          
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

        var table=$('#example').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 12 ]
                }
            ]
        } );
    } );
</script>