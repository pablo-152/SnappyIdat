<?php if($tipo==1){ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="7%" title="Apellido Paterno">Ap. Paterno</th>
                <th class="text-center" width="7%" title="Apellido Materno">Ap. Materno</th>
                <th class="text-center" width="10%">Nombre(s)</th>
                <th class="text-center" width="4%" title="Código">Cod.</th>
                <th class="text-center" width="4%" title="Grupo">Gru.</th>
                <th class="text-center" width="4%" title="Módulo">Mod.</th>
                <th class="text-center" width="4%" title="Sección">Sec.</th>
                <th class="text-center" width="13%">Producto</th> 
                <th class="text-center" width="8%">Descripción</th>
                <th class="text-center" width="6%" title="Fecha Vencimiento">FVP</th>
                <th class="text-center" width="6%">Monto</th>
                <th class="text-center" width="5%" title="Descuento">Desc.</th>
                <th class="text-center" width="5%" title="Penalidad">Pena.</th>
                <th class="text-center" width="6%">Total</th>
                <th class="text-center" width="6%" title="Fecha Pago">F. Pago</th>
                <th class="text-center" width="4%">Recibo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_pago as $list){ ?>                                           
                <tr class="even pointer text-center">
                    <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>   
                    <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                    <td class="text-left"><?php echo $list['Nombre']; ?></td>   
                    <td><?php echo $list['Codigo']; ?></td>    
                    <td><?php echo $list['Grupo']; ?></td>   
                    <td><?php echo $list['Modulo']; ?></td>  
                    <td><?php echo $list['Seccion']; ?></td>                                                    
                    <td class="text-left"><?php echo $list['Producto']; ?></td>   
                    <td class="text-left"><?php echo $list['Descripcion']; ?></td>    
                    <td><?php echo $list['Fec_Vencimiento']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['Monto'],2); ?></td>       
                    <td class="text-right"><?php echo "s./ ".number_format($list['Descuento'],2); ?></td>  
                    <td class="text-right"><?php echo "s./ ".number_format($list['Penalidad'],2); ?></td>  
                    <td class="text-right"><?php echo "s./ ".number_format($list['Total'],2); ?></td>  
                    <td><?php echo $list['Fec_Pago']; ?></td>
                    <td><?php echo $list['Recibo']; ?></td>  
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
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : true,
                        'aTargets' : [ 13 ]
                    }
                ]
            } );
        } );
    </script>
<?php }elseif($tipo==2){ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="10%">Ap. Paterno</th>
                <th class="text-center" width="10%">Ap. Materno</th>
                <th class="text-center" width="10%">Nombre(s)</th>
                <th class="text-center" width="7%">Código</th>
                <th class="text-center" width="7%">Grupo</th>
                <th class="text-center" width="7%">Módulo</th>
                <th class="text-center" width="7%">Sección</th>
                <th class="text-center" width="16%">Producto</th>
                <th class="text-center" width="10%">Descripción</th>
                <th class="text-center" width="6%" title="Fecha Vencimiento">FVP</th>
                <th class="text-center" width="10%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_pago as $list){ ?>                                           
                <tr class="even pointer text-center">
                    <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>   
                    <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                    <td class="text-left"><?php echo $list['Nombre']; ?></td>   
                    <td><?php echo $list['Codigo']; ?></td>    
                    <td><?php echo $list['Grupo']; ?></td>   
                    <td><?php echo $list['Modulo']; ?></td>   
                    <td><?php echo $list['Seccion']; ?></td>                                                    
                    <td class="text-left"><?php echo $list['Producto']; ?></td>   
                    <td class="text-left"><?php echo $list['Descripcion']; ?></td> 
                    <td><?php echo $list['Fec_Vencimiento']; ?></td>   
                    <td class="text-right"><?php echo "s./ ".number_format($list['Total'],2); ?></td>  
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
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : true,
                        'aTargets' : [ 8 ]
                    }
                ]
            } );
        } );
    </script>
<?php }else if($tipo==3){ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="10%">Ap. Paterno</th>
                <th class="text-center" width="10%">Ap. Materno</th>
                <th class="text-center" width="10%">Nombre(s)</th>
                <th class="text-center" width="7%">Código</th>
                <th class="text-center" width="7%">Grupo</th>
                <th class="text-center" width="7%">Módulo</th>
                <th class="text-center" width="7%">Sección</th>
                <th class="text-center" width="16%">Producto</th>
                <th class="text-center" width="10%">Descripción</th>
                <th class="text-center" width="6%" title="Fecha Vencimiento">FVP</th>
                <th class="text-center" width="10%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_pago as $list) {  ?>                                           
                <tr class="even pointer text-center">
                    <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>   
                    <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                    <td class="text-left"><?php echo $list['Nombre']; ?></td>   
                    <td><?php echo $list['Codigo']; ?></td>    
                    <td><?php echo $list['Grupo']; ?></td>   
                    <td><?php echo $list['Modulo']; ?></td>   
                    <td><?php echo $list['Seccion']; ?></td>                                                    
                    <td class="text-left"><?php echo $list['Producto']; ?></td>   
                    <td class="text-left"><?php echo $list['Descripcion']; ?></td>   
                    <td><?php echo $list['Fec_Vencimiento']; ?></td> 
                    <td class="text-right"><?php echo "s./ ".number_format($list['Total'],2); ?></td>  
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
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : true,
                        'aTargets' : [ 8 ]
                    }
                ]
            } );
        } );
    </script>
<?php }else{ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="10%">Ap. Paterno</th>
                <th class="text-center" width="10%">Ap. Materno</th>
                <th class="text-center" width="10%">Nombre(s)</th>
                <th class="text-center" width="7%">Código</th>
                <th class="text-center" width="7%">Grupo</th>
                <th class="text-center" width="7%">Módulo</th>
                <th class="text-center" width="7%">Sección</th>
                <th class="text-center" width="16%">Producto</th>
                <th class="text-center" width="10%">Descripción</th>
                <th class="text-center" width="6%" title="Fecha Vencimiento">FVP</th>
                <th class="text-center" width="10%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_pago as $list) {  ?>                                           
                <tr class="even pointer text-center">
                    <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>   
                    <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                    <td class="text-left"><?php echo $list['Nombre']; ?></td>   
                    <td><?php echo $list['Codigo']; ?></td>    
                    <td><?php echo $list['Grupo']; ?></td>   
                    <td><?php echo $list['Modulo']; ?></td>   
                    <td><?php echo $list['Seccion']; ?></td>                                                    
                    <td class="text-left"><?php echo $list['Producto']; ?></td>   
                    <td class="text-left"><?php echo $list['Descripcion']; ?></td>   
                    <td><?php echo $list['Fec_Vencimiento']; ?></td> 
                    <td class="text-right"><?php echo "s./ ".number_format($list['Total'],2); ?></td>  
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
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : true,
                        'aTargets' : [ 8 ]
                    }
                ]
            } );
        } );
    </script>
<?php } ?>