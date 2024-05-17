<?php if($tipo==3){ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="8%">P. Venta</th>
                <th class="text-center" width="8%">Fecha</th>
                <th class="text-center" width="24%">Alumno</th> 
                <th class="text-center" width="8%">Documento</th>
                <th class="text-center" width="8%">Número</th> 
                <th class="text-center" width="8%">Cantidad</th>
                <th class="text-center" width="8%">Total</th>
                <th class="text-center" width="12%">Tipo Pago</th>
                <th class="text-center" width="8%">Usuario</th>
                <th class="text-center" width="8%">Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($list_entrega_venta as $list){ ?>                                           
                <tr class="even pointer text-center">
                    <td><?php echo ""; ?></td>
                    <td><?php echo $list['fecha']; ?></td> 
                    <td class="text-left"><?php echo $list['nom_alumno']; ?></td>
                    <td><?php echo $list['nom_tipo_documento']; ?></td>
                    <td><?php echo ""; ?></td> 
                    <td><?php echo $list['cantidad']; ?></td>
                    <td class="text-right"><?php echo "s/. ".$list['total']; ?></td>
                    <td><?php echo $list['nom_tipo_pago']; ?></td> 
                    <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                    <td><?php echo ""; ?></td>
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
                        'aTargets' : [ 9 ]
                    }
                ]
            } );
        });
    </script>
<?php }else{ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="8%">P. Venta</th>
                <th class="text-center" width="8%">Fecha</th>
                <th class="text-center" width="24%">Alumno</th> 
                <th class="text-center" width="8%">Documento</th>
                <th class="text-center" width="8%">Número</th> 
                <th class="text-center" width="6%">Cantidad</th>
                <th class="text-center" width="6%">Total</th>
                <th class="text-center" width="12%">Tipo Pago</th>
                <th class="text-center" width="8%">Usuario</th>
                <th class="text-center" width="8%">Estado</th>
                <th class="text-center" width="4%"></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($list_entrega_venta as $list){ ?>                                           
                <tr class="even pointer text-center">
                    <td><?php echo ""; ?></td>
                    <td><?php echo $list['fecha']; ?></td> 
                    <td class="text-left"><?php echo $list['nom_alumno']; ?></td> 
                    <td><?php echo $list['nom_tipo_documento']; ?></td>
                    <td><?php echo ""; ?></td> 
                    <td><?php echo $list['cantidad']; ?></td>
                    <td class="text-right"><?php echo "s/. ".$list['total']; ?></td>
                    <td><?php echo $list['nom_tipo_pago']; ?></td> 
                    <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                    <td><?php echo ""; ?></td>
                    <td>
                        <?php if($tipo==1){ ?>
                            <a title="Venta Lista" onclick="Update_Venta_Lista('<?php echo $list['id_venta']; ?>');">
                                <img src="<?= base_url() ?>template/img/listo.png">
                            </a>
                        <?php }else{ ?>
                            <a title="Venta Entregada" data-toggle="modal" data-target="#acceso_modal_mod" 
                            app_crear_mod="<?= site_url('Laleli/Modal_Update_Venta_Entregada') ?>/<?php echo $list['id_venta']; ?>">
                                <img src="<?= base_url() ?>template/img/entregado.png">
                            </a>
                        <?php } ?>
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

            var table = $('#example').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 10 ]
                    }
                ]
            } );
        });
    </script>
<?php } ?>