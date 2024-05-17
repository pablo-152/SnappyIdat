<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Código</th>  
            <th class="text-center" width="10%" title="Empresa">Tipo</th>
            <th class="text-center" width="10%">Descripción</th>  
            <th class="text-center" width="10%">Talla/Ref.</th> 
            <th class="text-center" width="8%">Añadidos</th>
            <th class="text-center" width="8%">Transferidos</th>
            <th class="text-center" width="8%">Retirados</th> 
            <th class="text-center" width="8%">Devoluciones</th> 
            <th class="text-center" width="8%">Ventas</th>
            <th class="text-center" width="8%">Stock</th>
            <th class="text-center" width="8%">Stock Total</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>

    <tbody> 
        <?php foreach($list_detalle_almacen as $list){ 
            //if($list['stock_total']>0){ ?>                                           
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['ingresado']; ?></td>
                <td><?php echo $list['transferido']; ?></td>
                <td><?php echo $list['retirado']; ?></td>
                <td><?php echo $list['devolucion']; ?></td> 
                <td><?php echo $list['venta']; ?></td> 
                <td style="background-color:#DEEBF7;"><?php echo $list['stock']; ?></td>    
                <td <?php if($list['stock_total']<0){ ?> style="background-color:#F2BBBB;" <?php } ?>><?php echo $list['stock_total']; ?></td> 
                <td>
                    <a title="Más Información" href="<?= site_url('Laleli3/Movimiento_Almacen') ?>/<?php echo $list['id_almacen']; ?>/<?php echo str_replace('-','_',$list['codigo']); ?>">
                        <img src="<?= base_url() ?>template/img/ver.png"/>
                    </a>
                </td>                                      
            </tr>
        <?php } //} ?>
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
                    'bSortable' : false,
                    'aTargets' : [ 11 ]
                }
            ]
        } );
    });
</script>