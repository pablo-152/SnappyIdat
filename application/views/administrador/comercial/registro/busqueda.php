<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<?php if($id_nivel==15){ ?>
    <table id="example_secretaria" class="table table-hover table-bordered table-striped">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="4%" style="cursor:help" title="Referencia">Ref.</th>
                <th class="text-center" width="3%">Dp</th>
                <th class="text-center" width="5%" style="cursor:help">Contacto</th>
                <th class="text-center" width="5%">Usuario</th>  
                <th class="text-center" width="6%">Tipo</th>
                <th class="text-center" width="14%" style="cursor:help" title="Nombres y Apellidos">Nomb.&nbsp;y&nbsp;Apelli.</th>
                <th class="text-center" width="4%">DNI</th>
                <th class="text-center" width="6%" title="Contacto 1">Con. 1</th>
                <th class="text-center" width="3%" style="cursor:help" title="Empresa">Emp.</th>
                <th class="text-center" width="3%">Sede</th>
                <th class="text-center" width="7%">Intereses</th>
                <th class="text-center" width="7%">Acción</th>
                <th class="text-center" width="5%">Fecha</th>     
                <th class="text-center" width="5%">Usuario</th>        
                <th class="text-center" width="8%">Status</th>
                <th class="text-center" width="15%">Comentario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_registro_secretaria as $list) {?>
                <tr class="even pointer" <?php if($list['duplicado']==1){ echo 'style="background-color:'."#FBE5D6".'"'; } ?>>
                <td class="text-center"><?php echo $list['cod_registro']; ?></td>
                <td class="text-center"><?php echo $list['dp']; ?></td>
                <td class="text-center"><?php echo $list['fec_inicial']; ?></td>
                <td><?php echo $list['usuario_codigo']; ?></td>
                <td class="text-center"><?php echo $list['nom_informe']; ?></td>
                <td><?php echo $list['nombres_apellidos']; ?></td>
                <td class="text-center"><?php echo $list['dni']; ?></td>
                <td class="text-center"><?php echo $list['contacto1']; ?></td>
                <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td>
                <td><?php echo $list['productosf']; ?></td>
                <td ><?php if(strlen($list['nom_accion_h'])>0){echo $list['nom_accion_h'];}else{echo "Comentario";} ?></td>
                <td class="text-center"><?php echo $list['fecha_status_h']; ?></td>
                <td><?php echo $list['usuario_historico']; ?></td>
                <td><?php echo $list['nom_status_h']; ?></td>
                <td><?php echo $list['comentario_h']; ?></td>
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
                        'aTargets' : [ 15 ]
                    }
                ]
            } );
        });
    </script>
<?php }else{ ?> 
    <form method="post" id="formulario_excel" enctype="multipart/form-data" class="formulario">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <select class="form-control" id="anio_busqueda" name="anio_busqueda" onchange="Buscar(3);">
                    <option value="0">Año</option>
                    <?php foreach ($list_anio as $list){ ?>
                        <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==$anio){ echo "selected"; } ?>>
                            <?php echo $list['nom_anio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="heading-btn-group">
            <a onclick="Buscar(0);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Buscar(1);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">

            <a class="form-group btn">
                <input name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]' size="100">
            </a>

            <a class="form-group btn" href="<?= site_url('Administrador/Excel_Vacio_Comercial') ?>" title="Estructura de Excel">
                <img height="36px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel"/>
            </a>

            <a class="form-group btn">
                <button class="btn btn-primary" type="button" onclick="Importar_Comercial();">Importar</button>
            </a>
        </div>
    </form>
    
    <form method="post" id="formulario_registro" enctype="multipart/form-data"  class="formulario">
        <table id="example" class="table table-hover table-bordered table-striped" > 
            <thead>
                <tr style="background-color: #E5E5E5;">
                    <th class="text-center" width="2%"></th>  
                    <th class="text-center" width="4%" style="cursor:help" title="Referencia">Ref.</th>
                    <th class="text-center" width="3%">Dp</th>
                    <th class="text-center" width="5%" style="cursor:help">Contacto</th>
                    <th class="text-center" width="5%">Usuario</th>  
                    <th class="text-center" width="6%">Tipo</th> 
                    <th class="text-center" width="12%" style="cursor:help" title="Nombres y Apellidos">Nomb.&nbsp;y&nbsp;Apelli.</th>
                    <th class="text-center" width="4%">DNI</th>
                    <th class="text-center" width="6%" title="Contacto 1">Con. 1</th>
                    <th class="text-center" width="3%" style="cursor:help" title="Empresa">Emp.</th>
                    <th class="text-center" width="3%">Sede</th>
                    <th class="text-center" width="7%">Intereses</th>
                    <th class="text-center" width="7%">Acción</th>
                    <th class="text-center" width="5%">Fecha</th>    
                    <th class="text-center" width="5%">Usuario</th>     
                    <th class="text-center" width="8%">Status</th>
                    <th class="text-center" width="13%">Comentario</th>
                    <th class="text-center" width="2%"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list_registro as $list) {?>
                    <tr class="even pointer" <?php if($list['duplicado']==1){ echo 'style="background-color:'."#FBE5D6".'"'; } ?>>
                        <td class="text-center"><input required type="checkbox" id="id_registro[]" name="id_registro[]" value="<?php echo $list['id_registro']; ?>"></td>
                        <td class="text-center"><?php echo $list['cod_registro']; ?></td>
                        <td class="text-center"><?php echo $list['dp']; ?></td>
                        <td class="text-center"><?php echo $list['fec_inicial']; ?></td>
                        <td><?php echo $list['usuario_codigo']; ?></td>
                        <td class="text-center"><?php echo $list['nom_informe']; ?></td>
                        <td><?php echo $list['nombres_apellidos']; ?></td>
                        <td class="text-center"><?php echo $list['dni']; ?></td>
                        <td class="text-center"><?php echo $list['contacto1']; ?></td>
                        <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
                        <td><?php echo $list['cod_sede']; ?></td>                
                        <td <?php if($list['productosf']=="Sin Definir" && $list['nom_status_h']=="Sin Definir"){ echo "style='color: #C00000;'"; } ?>><?php echo $list['productosf']; ?></td>
                        <td><?php if(strlen($list['nom_accion_h'])>0){echo $list['nom_accion_h'];}else{echo "Comentario";} ?></td>
                        <td class="text-center"><?php echo $list['fecha_status_h']; ?></td>
                        <td><?php echo $list['usuario_historico']; ?></td>
                        <td <?php if($list['productosf']=="Sin Definir" && $list['nom_status_h']=="Sin Definir"){ echo "style='color: #C00000;'"; } ?>><?php echo $list['nom_status_h']; ?></td>
                        <td><?php echo substr($list['comentario_h'],0,35); ?></td>
                        <td class="text-center">
                        <a title="Más Información" href="<?= site_url('Administrador/Historial_Registro_Mail') ?>/<?php echo $list['id_registro']; ?>">
                            <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;"/>
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
                order: [1,"desc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 100,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 0,17 ]
                    }
                ]
            } );
        });
    </script>
<?php } ?>