<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%">Año</th>  
            <th class="text-center" width="20%">Producto</th> 
            <th class="text-center" width="10%">Pendientes</th> 
            <th class="text-center" width="10%">Total por Cancelar</th> 
            <th class="text-center" width="10%">Pagos</th> 
            <th class="text-center" width="10%">Total Cancelado</th> 
            <th class="text-center" width="10%">Total Descuentos</th>  
            <th class="text-center" width="10%">Total Penalización</th>
            <th class="text-center" width="10%">SUB-TOTAL</th>
            <th class="text-center" width="4%"></th>  
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_pagamento as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['anio']; ?></td>   
                <td class="text-left"><?php echo $list['nom_producto']; ?></td>   
                <td><?php echo $list['pendientes']; ?></td>   
                <td class="text-right"><?php echo "s./ ".$list['total_pendientes']; ?></td>   
                <td><?php echo $list['pagos']; ?></td>     
                <td class="text-right"><?php echo "s./ ".$list['total_pagos_monto']; ?></td>  
                <td class="text-right"><?php echo "s./ ".$list['total_pagos_descuento']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['total_pagos_penalidad']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['total_pagos']; ?></td>
                <td>
                    <a title="Más Información" href="<?= site_url('BabyLeaders/Detalle_Pagamento') ?>/<?php echo $list['id_producto']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png"/>
                    </a>
                </td>                                          
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
            order: [[0,"desc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 9 ]
                }
            ]
        } );
    } );
</script>