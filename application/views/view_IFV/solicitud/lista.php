<table id="example" class="table table-hover table-bordered table-striped">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="6%" class="text-center">Código</th>
            <th width="6%" class="text-center" title="Número Documento">Nr. Doc.</th>
            <th width="11%" class="text-center" title="Apellido Paterno">A. Paterno</th>
            <th width="11%" class="text-center" title="Apellido Materno">A. Materno</th>
            <th width="15%" class="text-center">Nombre</th>
            <th width="10%" class="text-center">Producto</th>
            <th width="5%" class="text-center">Monto</th>
            <th width="5%" class="text-center" title="Descuento">Desc.</th>
            <th width="5%" class="text-center" title="Penalidad">Pena.</th>
            <th width="5%" class="text-center" title="SubTotal">SubT.</th>
            <th width="6%" class="text-center">Recibo</th>
            <th width="6%" class="text-center" title="Fecha Pago">F. Pago</th>
            <th width="6%" class="text-center">Estado</th>
            <th width="3%" class="text-center"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_solicitud as $list){ ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['Codigo']; ?></td>
                <td><?php echo $list['N_Doc']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombres']; ?></td>
                <td class="text-left"><?php echo $list['Producto']; ?></td>
                <td><?php echo number_format($list['Monto'],2); ?></td>
                <td><?php echo number_format($list['Descuento'],2); ?></td>
                <td><?php echo number_format($list['Penalidad'],2); ?></td>
                <td><?php echo number_format($list['SubTotal'],2); ?></td>
                <td><?php echo $list['Recibo']; ?></td>
                <td><?php echo $list['Fecha_Pago']; ?></td>
                <td><?php echo $list['Estado']; ?></td>
                <td>
                    <a href="<?= site_url('AppIFV/Detalle_Solicitud') ?>/<?php echo $list['Id']; ?>">
                        <img title="Editar Datos" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;">
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
            order: [[2,"asc"],[3,"asc"],[4,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 13 ]
                }
            ]
        } );
    });
</script>