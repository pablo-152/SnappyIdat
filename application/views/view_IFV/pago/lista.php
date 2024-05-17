<?php if($_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==10 || $_SESSION['usuario'][0]['id_usuario']==35 || $_SESSION['usuario'][0]['id_usuario']==71){ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="4%">Año</th>
                <th class="text-center" width="14%">Tipo</th>
                <th class="text-center" width="27%">Producto</th>
                <th class="text-center" width="6%" title="Pendientes">Pend.</th>
                <th class="text-center" width="7%" title="Total por Cancelar">Tot. Can.</th>
                <th class="text-center" width="6%">Pagos</th>
                <th class="text-center" width="7%" title="Total Cancelado">Tot. Can.</th>
                <th class="text-center" width="7%" title="Total Descuentos">Tot. Des.</th>
                <th class="text-center" width="7%" title="Total Penalización">Tot. Pen.</th>
                <th class="text-center" width="7%">Sub-Tot.</th> 
                <th class="text-center" width="5%">Estado</th>
                <th class="text-center" width="3%"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_producto as $list) {  ?>                                           
                <tr class="even pointer text-center">
                    <td><?php echo $list['anio']; ?></td>   
                    <td class="text-left"><?php echo $list['nom_tipo_producto']; ?></td>   
                    <td class="text-left"><?php echo $list['nom_producto']; ?></td>   
                    <td style="background-color:#fbe5d6;"><?php echo $list['pendientes']; ?></td>   
                    <td style="background-color:#fbe5d6;" class="text-right"><?php echo "s./ ".number_format($list['total_cancelar'],2); ?></td>    
                    <td><?php echo $list['pagos']; ?></td>   
                    <td class="text-right"><?php echo "s./ ".number_format($list['total_cancelado'],2); ?></td>                                                    
                    <td class="text-right"><?php echo "s./ ".number_format($list['total_descuento'],2); ?></td>   
                    <td class="text-right"><?php echo "s./ ".number_format($list['total_penalizacion'],2); ?></td>    
                    <td class="text-right"><?php echo "s./ ".number_format($list['sub_total'],2); ?></td> 
                    <td><?php echo $list['estado']; ?></td>      
                    <td>
                        <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Pagos') ?>/<?php echo $list['Id']; ?>" target="_blank">
                            <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
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
                order: [[0,"asc"],[1,"asc"],[2,"asc"]],
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
        } );
    </script>
<?php }else{ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="6%">Año</th>
                <th class="text-center" width="16%">Tipo</th>
                <th class="text-center" width="40%">Producto</th>
                <th class="text-center" width="12%">Pendientes</th>
                <th class="text-center" width="12%">Total por Cancelar</th>
                <th class="text-center" width="10%">Estado</th>
                <th class="text-center" width="4%"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_producto as $list) {  ?>                                           
                <tr class="even pointer text-center">
                    <td><?php echo $list['anio']; ?></td>   
                    <td class="text-left"><?php echo $list['nom_tipo']; ?></td>   
                    <td class="text-left"><?php echo $list['nom_producto']; ?></td>   
                    <td style="background-color:#fbe5d6;"><?php echo $list['pendientes']; ?></td>   
                    <td style="background-color:#fbe5d6;" class="text-right"><?php echo "s./ ".number_format($list['total_cancelar'],2); ?></td>    
                    <td><?php echo $list['estado']; ?></td>      
                    <td>
                        <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Pagos') ?>/<?php echo $list['Id']; ?>">
                            <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
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
                order: [[0,"asc"],[1,"asc"],[2,"asc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 6 ]
                    }
                ]
            } );
        } );
    </script>
<?php } ?>