<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Inventario (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="cursor:pointer;margin-right:5px;" onclick="Validar_Inventario()">
                            <img src="<?= base_url() ?>template/img/validar.png" alt="Invitar Postulante" />
                        </a>
                        
                        <a title="Validación (Imágen)" style="cursor:pointer;margin-right:5px;" onclick="Ver_Scanner()">
                            <img src="<?= base_url() ?>template/img/validarimg.png" alt="Invitar Postulante" />
                        </a>

                        <a title="Nueva Asignación" onclick="Asignar_Codigo()" style="cursor:pointer;margin-right:5px;" >
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>

                        <a onclick="Excel_Inventario()">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                        
                        <!--<button class="btn btn-success" type="button" id="btnNuevo" data-toggle="modal" data-target="#modalArticulos" data-keyboard="false" data-backdrop="static"><i class="fa fa-plus"></i> Nuevo Bulto</button>
                        <a href="<?= site_url('Snappy/Scanner') ?>"><button class="btn btn-success" type="button"  ><i class="fa fa-plus"></i>Boton en desarrollo</button></a>
-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <form id="formulario_scanner" method="post" target="print_popup" action="<?= site_url('Snappy/Scanner')?>" onsubmit="window.open('about:blank','print_popup','width=530,height=600');">
        </form>
        <form  method="post" id="formulario_indexi" enctype="multipart/form-data"  class="formulario">
            <div class="row">
                <div class="col-md-12 row">


                    <div class="form-group col-md-2">
                        <label>Producto:</label>
                        <div class="col">
                            <select required class="form-control" name="id_producto" id="id_producto">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_producto as $list){ ?>
                                <option value="<?php echo $list['id_inventario_producto']; ?>"><?php echo $list['referencia'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                        
                    </div>

                    <div class="form-group col-md-2">
                        <label>Empresa:</label>
                        <div class="col">
                            <select required class="form-control" name="id_empresa" id="id_empresa" onchange="Busca_Sede()">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_empresam as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                        <?php } ?>
                        </select>
                        </div>
                        
                    </div>


                    <div class="form-group col-md-2" id="div_sede">
                        <label>Sede:</label>
                        <div class="col">
                            <select required class="form-control" name="id_sede" id="id_sede">
                                <option value="0">Seleccione</option>
                            
                            </select>
                        </div>
                        
                    </div>

                    <div class="form-group col-md-2" id="div_local">
                        <label>Local:</label>
                        <div class="col">
                            <select required class="form-control" name="id_local" id="id_local">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                        
                    </div>

                </div> 
                
                

                <div class="col-lg-12">
        
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <a onclick="Buscar_Estado(1);"  id="asignados" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Asignados</span><i class="icon-arrow-down52"></i></a>
                            <a onclick="Buscar_Estado(2);"  id="sinasignar" style="color: #ffffff; background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Sin Asignar</span><i class="icon-arrow-down52"></i> </a>
                            <a onclick="Buscar_Estado(3);"  id="todos" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                        </div>
                    <div id="tabla">
                            <input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro ?>">
                            <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                                <thead>
                                    <tr >
                                        <th width="1%" ><div  ><input type="checkbox" style="width: 20px" id="total" name="total"  value="1"></div></div></th>
                                        
                                        <th width="3%"><div align="center" title="Código de barra" style="cursor:help">Código.</div></th>
                                        <!--<th><div align="center" title="Número" style="cursor:help">Ref.</div></th>-->
                                        <th><div align="center">Tipo</div></th>
                                        <th><div align="center">Sub-Tipo</div></th>
                                        <th><div align="center">Empresa</div></th>
                                        <th><div align="center">Sede</div></th>
                                        <th><div align="center">Local</div></th>
                                        <th><div align="center" title="Validación" style="cursor:help">Vali.</div></th>
                                        <th><div align="center" title="Usuario que realizó Validación" style="cursor:help">Usuario&nbsp;Vali.</div></th>
                                        <th><div align="center" title="Fecha de Validación" style="cursor:help">Fecha&nbsp;Vali.</div></th>
                                        <th><div align="center">Último&nbsp;check</div></th>
                                        <!--<th><div align="center">Stock</div></th>-->
                                        <th><div align="center">Estado</div></th>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list_inventario as $list) { ?>
                                        <tr>
                                            <td><input required type="checkbox" id="id_inventario[]" name="id_inventario[]" value="<?php echo $list['id_inventario']; ?>"></td>
                                            
                                            <td ><?php echo $list['codigo_barra']; ?></td>
                                            <!--<td ><?php echo $list['numero']; ?></td>-->
                                            <td ><?php echo $list['nom_tipo_inventario']; ?></td>
                                            <td ><?php echo $list['nom_subtipo_inventario']; ?></td>
                                            <td ><?php echo $list['cod_empresa']; ?></td>
                                            <td ><?php echo $list['cod_sede']; ?></td>
                                            <td ><?php echo $list['nom_local']; ?></td>
                                            <td ><?php echo $list['validacion_msg']; ?></td>
                                            <td ><?php echo $list['usuario_codigo']; ?></td>
                                            <td ><?php if($list['validacion']!=0){echo $list['fecha_validacion'];}  ?></td>
                                            <td ><?php if($list['fecha_validacion']!="00/00/0000 00:00:00"){echo $list['lcheck']; } ?></td>
                                            <!--<td ><?php echo ""; ?></td>-->
                                            <td ><?php echo $list['nom_status']; ?></td>

                                            <td class="text-center" nowrap>
                                                <img title="Editar Datos" data-toggle="modal"  data-target="#modal_full" modal_full="<?= site_url('Snappy/Modal_Update_Inventario') ?>/<?php echo $list["id_inventario"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" />
                                                <?php 
                                                if($list['archivo_validacion']!=""){?> 
                                                <a style="cursor:pointer;" class="" data-toggle="modal" data-target="#documento" data-imagen="<?php echo $list['archivo_validacion']; ?>" title="Documento"> <img title="Imágen 1" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" /></a>
                                                <?php }
                                                ?>
                                                
                                                <!--<img title="Eliminar" onclick="Delete_Codigo('<?php echo $list['id_inventario']; ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" />-->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <input type="hidden" id="cadena" name="cadena" class="form-control"  value="" />
                            <input type="hidden" id="cantidad" name="cantidad" class="form-control"  value="0" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $("#inventario").addClass('active');
        $("#hinventario").attr('aria-expanded','true');
        $("#inventariog").addClass('active');
        document.getElementById("rinventario").style.display = "block";

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
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

        let $dt = $('#example');

        var table=$('#example').DataTable( {
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
        } );


        
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
            //total += this.checked ? price : price * -1;
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
            
        });
    });

    $('#modalBultos').on('shown.bs.modal', function () {
        $('#codigoEscaneado').focus();
    });
    $('#modalBultos').on('shown.bs.modal', function () {
        $('#codigoEscaneado').focus();
    });


</script>

<script>

    function Ver_Scanner(){
        $('#formulario_scanner').submit();
    }
    function Buscar_Estado(id) {
        /*$(document)
        .ajaxStart(function () {
            //screen.fadeIn();
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });*/

        var id = id;
        var url="<?php echo site_url(); ?>Snappy/Busca_Inventario";

        /*var observacion = document.getElementById("observacion");
        var div = document.getElementById("div_archivo");
        var btn = document.getElementById("btn_invitar");*/

        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':id},
            success:function (data) {
                $('#tabla').html(data);
            }
        });
        $('#parametro').val(id);
        var asignados = document.getElementById('asignados');
        var sinasignar = document.getElementById('sinasignar');
        var todos = document.getElementById('todos');
        if(id==1){
                asignados.style.color = '#ffffff';
                sinasignar.style.color = '#000000';
                todos.style.color = '#000000';
        }else if(id==2){
            
            asignados.style.color = '#000000';
            sinasignar.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else if(id==3){
            asignados.style.color = '#000000';
            sinasignar.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Excel_Inventario(){
        var parametro=$('#parametro').val();
        window.location = "<?php echo site_url(); ?>Snappy/Excel_Inventario/"+parametro;
    }

    function Busca_Sede(){
        var dataString = new FormData(document.getElementById('formulario_indexi'));
        var url="<?php echo site_url(); ?>Snappy/Busca_Sede_Local_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_sede').html(data);
                
            }
        });
        Busca_Local();
    }

    function Busca_Local(){
        var dataString = new FormData(document.getElementById('formulario_indexi'));
        var url="<?php echo site_url(); ?>Snappy/Busca_Local_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_local').html(data);
                
            }
        });
    }

    function Delete_Codigo(id){
        var id = id;
        //alert(id);
        var url="<?php echo site_url(); ?>Snappy/Delete_Codigo";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_codigo_inventario':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Snappy/Codigo";
                        });
                    }
                });
            }
        })
    }
    

    function Validar_Inventario(){
        /*$(document)
        .ajaxStart(function () {
            //screen.fadeIn();
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });*/

        var contadorf=$('#cantidad').val();

        var dataString = new FormData(document.getElementById('formulario_indexi'));
        var url="<?php echo site_url(); ?>Snappy/Validar_Inventario";



        if(contadorf>0)
        {
                bootbox.confirm({
                    title: "Validar Códigos",
                    message: "¿Desea validar  "+contadorf+ " códigos?",
                    buttons: {
                        cancel: {
                            label: 'Cancelar'
                        },
                        confirm: {
                            label: 'Confirmar'
                        }
                    },
                    callback: function (result) {
                        if (result==false) {
                        
                        }else{
                        $.ajax({
                            url: url,
                            data:dataString,
                            type:"POST",
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data==""){
                                    swal.fire(
                                    'Validación Exitosa!',
                                    '',
                                    'success'
                                        ).then(function() {
                                            window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                        });
                                    }else{
                                        swal.fire(
                                        'Validación Incompleta!',
                                        ''+data,
                                        'info'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                            }); 
                                    }
                                }
                                
                        }); 
                        }
                        

                    } 
                });
            
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar al menos 1 código.',
                'warning'
            ).then(function() { });
            return false;
        }
    }

    function Asignar_Codigo(){
        /*$(document)
        .ajaxStart(function () {
            //screen.fadeIn();
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });*/

        var contadorf=$('#cantidad').val();

        var dataString = new FormData(document.getElementById('formulario_indexi'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Asignacion_Producto_Inventario";
        var url2="<?php echo site_url(); ?>Snappy/Valida_cantidad_producto";



        if(contadorf>0)
        {
            if (valida_asignacion()) {
                $.ajax({
                            url: url2,
                            data:dataString,
                            type:"POST",
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data!=""){
                                    swal.fire(
                                        'Asignacion denegada!',
                                        ''+data,
                                        'error'
                                            ).then(function() {
                                                //window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                            }); 
                                    }else{

                                        bootbox.confirm({
                                            title: "Asignar Códigos",
                                            message: "¿Desea asignar  "+contadorf+ " códigos?",
                                            buttons: {
                                                cancel: {
                                                    label: 'Cancelar'
                                                },
                                                confirm: {
                                                    label: 'Confirmar'
                                                }
                                            },
                                            callback: function (result) {
                                                if (result==false) {
                                                
                                                }else{
                                                $.ajax({
                                                    url: url,
                                                    data:dataString,
                                                    type:"POST",
                                                    processData: false,
                                                    contentType: false,
                                                    success:function (data) {
                                                        
                                                        if(data!=""){
                                                            swal.fire(
                                                            'Asignación Incompleta!',
                                                            data+'Por favor revisar!',
                                                            'info'
                                                                ).then(function() {
                                                                    //window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                                                });
                                                        }else{
                                                            swal.fire(
                                                            'Asignación Exitosa!',
                                                            '',
                                                            'success'
                                                                ).then(function() {
                                                                    window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                                                }); 
                                                            }
                                                    }
                                                        
                                                }); 
                                                }
                                                

                                            } 
                                        });

                                    }
                                }
                                
                        }); 

                    

            }
            
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar al menos 1 código.',
                'warning'
            ).then(function() { });
            return false;
        }
    }

    function valida_asignacion() {
        if($('#id_producto').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar producto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar empresa.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_sede').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar sede.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_local').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar local.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
    
</script>

<?php $this->load->view('Admin/footer'); ?>
