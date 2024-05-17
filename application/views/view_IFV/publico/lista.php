<?php if($_SESSION['usuario'][0]['id_nivel']==15){ ?>
    <table id="example_secretaria" class="table table-hover table-bordered table-striped">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="4%" style="cursor:help" title="Referencia">Ref.</th>
                <th class="text-center" width="3%">Dp</th>
                <th class="text-center" width="6%">Usuario</th>  
                <th class="text-center" width="8%">Tipo</th> 
                <th class="text-center" width="17%" style="cursor:help" title="Nombres y Apellidos">Nomb.&nbsp;y&nbsp;Apelli.</th>
                <th class="text-center" width="4%">DNI</th>
                <th class="text-center" width="6%" title="Contacto 1">Con. 1</th>
                <th class="text-center" width="8%">Intereses</th>
                <th class="text-center" width="7%">Acción</th>
                <th class="text-center" width="6%">Fecha</th>    
                <th class="text-center" width="5%">Usuario</th>     
                <th class="text-center" width="8%">Status</th>
                <th class="text-center" width="18%">Comentario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_publico as $list) {?>
                <tr class="even pointer" <?php if($list['duplicado']==1){ echo 'style="background-color:'."#FBE5D6".'"'; } ?>>
                    <td class="text-center"><?php echo $list['cod_publico']; ?></td>
                    <td class="text-center"><?php echo $list['duplicado']; ?></td>
                    <td><?php echo $list['usuario_codigo']; ?></td>
                    <td><?php echo $list['nom_tipo']; ?></td>
                    <td><?php echo $list['nombres_apellidos']; ?></td>
                    <td class="text-center"><?php echo $list['dni']; ?></td>
                    <td class="text-center"><?php echo $list['contacto1']; ?></td>             
                    <td><?php echo $list['nom_producto_interes']; ?></td>   
                    <td><?php echo $list['nom_accion']; ?></td>    
                    <td class="text-center"><?php echo $list['fecha_h']; ?></td>    
                    <td><?php echo $list['usuario_h']; ?></td>    
                    <td><?php echo $list['nom_status']; ?></td>        
                    <td><?php echo $list['comentario']; ?></td>        
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#example_secretaria thead tr').clone(true).appendTo( '#example_secretaria thead' );
            $('#example_secretaria thead tr:eq(1) th').each( function (i) {
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

            var table = $('#example_secretaria').DataTable( {
                order: [0,"desc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 100,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : true,
                        'aTargets' : [ 12 ]
                    }
                ]
            } );
        });
    </script>
<?php }else{ ?> 
    <style>
        #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(2),
        #example tbody tr td:nth-child(3),#example tbody tr td:nth-child(7),
        #example tbody tr td:nth-child(8),#example tbody tr td:nth-child(11),
        #example tbody tr td:nth-child(15){ 
            text-align: center; 
        } 
    </style> 

    <form method="POST" id="formulario_excel" enctype="multipart/form-data" class="formulario">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <select class="form-control" id="anio_busqueda" name="anio_busqueda" onchange="Lista_Publico(3);">
                    <?php foreach ($list_anio as $list){ ?>
                        <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==$anio){ echo "selected"; } ?>>
                            <?php echo $list['nom_anio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="heading-btn-group">
            <a onclick="Lista_Publico(0);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Publico(1);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">

            <a class="form-group btn">
                <input name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]' size="100">
            </a>

            <a class="form-group btn" href="<?= site_url('AppIFV/Excel_Vacio_Publico') ?>" title="Estructura de Excel">
                <img height="36px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel"/>
            </a>

            <a class="form-group btn">
                <button class="btn btn-primary" type="button" onclick="Importar_Comercial();">Importar</button>
            </a>
        </div>
    </form>
    
    <form method="POST" id="formulario_duplicado" enctype="multipart/form-data" class="formulario">
        <input type="hidden" id="cadena" name="cadena" value="">
        <input type="hidden" id="cantidad" name="cantidad" value="0">

        <table id="example" class="table table-hover table-bordered table-striped"> 
            <thead>
                <tr style="background-color: #E5E5E5;">
                    <th class="text-center" width="2%"><input type="checkbox" id="total" name="total" value="1"></th>  
                    <th class="text-center">Id</th>
                    <th class="text-center" width="4%" style="cursor:help" title="Referencia">Ref.</th>
                    <th class="text-center" width="3%">Dp</th>
                    <th class="text-center" width="6%">Usuario</th>  
                    <th class="text-center" width="8%">Tipo</th> 
                    <th class="text-center" width="15%" style="cursor:help" title="Nombres y Apellidos">Nomb.&nbsp;y&nbsp;Apelli.</th>
                    <th class="text-center" width="4%">DNI</th>
                    <th class="text-center" width="6%" title="Contacto 1">Con. 1</th>
                    <th class="text-center" width="8%">Intereses</th>
                    <th class="text-center" width="7%">Acción</th>
                    <th class="text-center" width="6%">Fecha</th>    
                    <th class="text-center" width="5%">Usuario</th>     
                    <th class="text-center" width="8%">Status</th>
                    <th class="text-center" width="15%">Comentario</th>
                    <th class="text-center" width="3%"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list_publico as $list) {?>
                    <tr class="even pointer" <?php if($list['duplicado']==1){ echo 'style="background-color:'."#FBE5D6".'"'; } ?>>
                        <td><input type="checkbox"></td>
                        <td><?php echo $list['id_publico']; ?></td>
                        <td><?php echo $list['cod_publico']; ?></td>
                        <td><?php echo $list['duplicado']; ?></td>
                        <td><?php echo $list['usuario_codigo']; ?></td>
                        <td><?php echo $list['nom_tipo']; ?></td>
                        <td><?php echo $list['nombres_apellidos']; ?></td>
                        <td><?php echo $list['dni']; ?></td>
                        <td><?php echo $list['contacto1']; ?></td>             
                        <td><?php echo $list['nom_producto_interes']; ?></td>   
                        <td><?php echo $list['nom_accion']; ?></td>    
                        <td><?php echo $list['fecha_h']; ?></td>    
                        <td><?php echo $list['usuario_h']; ?></td>    
                        <td><?php echo $list['nom_status']; ?></td>        
                        <td><?php echo $list['comentario']; ?></td>        
                        <td>
                            <a title="Más Información" href="<?= site_url('AppIFV/Historial_Publico') ?>/<?php echo $list['id_publico']; ?>">
                                <img src="<?= base_url() ?>template/img/ver.png">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>

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
                order: [2,"desc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 100,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 0,15 ]
                    },
                    {
                        'targets' : [ 1 ],
                        'visible' : false
                    } 
                ]
            } );

            // Seleccionar todo en la tabla
            let $dt = $('#example');
            let $total = $('#total');
            let $cadena = $('#cadena');
            let $cantidad = $('#cantidad');

            // Cuando hacen click en el checkbox del thead
            $dt.on('change', 'thead input', function (evt) {
                let checked = this.checked;
                let total = 0;
                let data = [];
                let cadena='';
                
                table.data().each(function (info) {
                var txt = info[0];
                    if (checked) {
                        total += 1;
                        txt = txt.substr(0, txt.length - 1) + ' checked>';
                        cadena += info[1]+",";
                    } else {
                        txt = txt.replace(' checked', '');
                    }
                    info[0] = txt;
                    data.push(info);
                });
                
                table.clear().rows.add(data).draw();
                $cantidad.val(total);
                $cadena.val(cadena);
            });

            // Cuando hacen click en los checkbox del tbody
            $dt.on('change', 'tbody input', function() {
                let q= $('#cadena').val();
                let cantidad= $('#cantidad').val();
                let info = table.row($(this).closest('tr')).data();
                let total = parseFloat($total.val());
                let cadena = $cadena.val();
                let price = parseFloat(info[1]);
                let cadena2 = info[1]+",";
                
                if(this.checked==false){
                    q = q.replace(cadena2, ""); 
                    cantidad = parseFloat(cantidad)-1;
                }else{
                    q += this.checked ? cadena2 : cadena2+",";
                    cantidad = parseFloat(cantidad)+1;
                }
                $cadena.val(q);
                $cantidad.val(cantidad);
            });
        });
    </script>
<?php } ?>