<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .sin_negra{
        font-weight: normal;
    }
    .estilo_boton{
        font-weight:bold;
        height:32px;
        width:150px;
        padding:5px;
    }

    .verde{
        color:#FFF;
        background-color:#92D050;
    }

    .azul{
        color:#FFF;
        background-color:#0070c0;
    }

    .rojo{
        color:#FFF;
        background-color:#C00000;
    }

    .verde:hover{
        color:#FFF;
    }

    .azul:hover{
        color:#FFF;
    }

    .rojo:hover{
        color:#FFF;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Descripción de libro <?php echo $get_id[0]['cod_biblioteca']; ?> (Detalle)</b></span></h4>
                </div>
                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nueva Módulo" style="width: 198px;margin-right: 5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Buscar_Alumno_Libro/1') ?>" >
                            <img  src="<?= base_url() ?>template/img/solicitar.png" />
                        </a>
                        <a title="Nueva Módulo" style="width: 198px; margin-right: 5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Buscar_Alumno_Libro/2') ?>">
                            <img  src="<?= base_url() ?>template/img/devolver.png" />
                        </a>
                        <?php if($sesion['id_nivel']==1 || $sesion['id_nivel']==6 || $sesion['id_nivel']==7){?>
                        <a title="Nueva Módulo" style="width: 198px; margin-right: 5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Buscar_Alumno_Libro/3') ?>">
                            <img src="<?= base_url() ?>template/img/perdido.png" />
                        </a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_detalle" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Código:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Código" readonly value="<?php echo $get_id[0]['cod_biblioteca']; ?>">
                </div>

                <div class="form-group col-md-8">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Estado:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Estado" readonly value="<?php echo $get_id[0]['nom_estado']; ?>">
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Especialidad:</label>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" id="id_especialidad" name="id_especialidad" onchange="Modulo();" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_especialidad as $list){ ?>
                            <option value="<?php echo $list['id_especialidad']; ?>" <?php if($list['id_especialidad']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>>
                                <?php echo $list['nom_especialidad']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Módulo:</label>
                </div>
                <div id="select_modulo" class="form-group col-md-1">
                    <select class="form-control" id="id_modulo" name="id_modulo" onchange="Ciclo();" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_modulo as $list){ ?>
                            <option value="<?php echo $list['id_modulo']; ?>" <?php if($list['id_modulo']==$get_id[0]['id_modulo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_modulo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Ciclo:</label>
                </div>
                <div id="select_ciclo" class="form-group col-md-1">
                    <select class="form-control" id="id_ciclo" name="id_ciclo" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_ciclo as $list){ ?>
                            <option value="<?php echo $list['id_ciclo']; ?>" <?php if($list['id_ciclo']==$get_id[0]['id_ciclo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_ciclo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">U. Didáctica:</label>
                </div>
                <div id="select_unidad_didactica" class="form-group col-md-3">
                    <select class="form-control" id="id_unidad_didactica" name="id_unidad_didactica" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_unidad_didactica as $list){ ?>
                            <option value="<?php echo $list['id_unidad_didactica']; ?>" <?php if($list['id_unidad_didactica']==$get_id[0]['id_unidad_didactica']){ echo "selected"; } ?>>
                                <?php echo $list['nom_unidad_didactica']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Título:</label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="<?php echo $get_id[0]['titulo']; ?>" disabled>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Sub-Título:</label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="subtitulo" name="subtitulo" placeholder="Sub-Título" value="<?php echo $get_id[0]['subtitulo']; ?>" disabled>
                </div>
            </div>
            
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Autor:</label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="autor" name="autor" placeholder="Autor" value="<?php echo $get_id[0]['autor']; ?>" disabled>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Editorial:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="editorial" name="editorial" placeholder="Editorial" value="<?php echo $get_id[0]['editorial']; ?>" disabled>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Año:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros" id="anio" name="anio" placeholder="Año" value="<?php echo $get_id[0]['anio']; ?>" disabled>
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Cant.:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros" id="cantidad" name="cantidad" placeholder="Cantidad" value="<?php echo $get_id[0]['cantidad']; ?>" disabled>
                </div>

                <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Tipo:</label>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" value="<?php echo $get_id[0]['tipo']; ?>" disabled>
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Fecha Compra:</label>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" value="<?php echo $get_id[0]['fecha_compra']; ?>" disabled>
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Monto:</label>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="number" class="form-control" id="monto" name="monto" placeholder="Monto" value="<?php echo $get_id[0]['monto']; ?>" disabled>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Observaciones:</label>
                </div>
                <div class="form-group col-md-11">
                    <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" rows="5" disabled><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>

            <div class="col-md-12 row text-center" style="margin-bottom:15px;">
                
                
                <!--<a class="btn estilo_boton rojo" ><span>Perdido</span></a>-->
            </div>

            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>
            <div class="panel panel-flat">
                <!--<div class="panel-heading">
                    <h5 class="panel-title">Datos de alumno</h5>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a onclick="Consulta_Almuno_Temporal_Biblioteca()"><i class="glyphicon glyphicon-refresh"></i></a></li>
                        </ul>
                    </div>
                </div>-->
                <div id="div_alumno">
                    <table class="table datatable-reorder-realtime" >
                        <input type="hidden" id="accion" name="accion">
                    </table>
                </div>
                
            </div>

            <div class="modal-footer">
                <input type="hidden" id="id_biblioteca" name="id_biblioteca" value="<?php echo $get_id[0]['id_biblioteca']; ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Accion_biblioteca();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Registro_Biblioteca') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>
<form id="formulario_scanner" method="post" target="print_popup" action="<?= site_url('AppIFV/Scanner_Requisitado')?>" onsubmit="window.open('about:blank','print_popup','width=530,height=600');">
    <input type="hidden" id="valor" name="valor" >
</form>

<script>
    $(document).ready(function() {
        $("#bibliotecas").addClass('active');
        $("#hbibliotecas").attr('aria-expanded', 'true');
        $("#registros_biblioteca").addClass('active');
		document.getElementById("rbibliotecas").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Modulo(){
        $(document)
        .ajaxStart(function () {
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
        });
        
        var id_especialidad = $('#id_especialidad').val();

        if(id_especialidad>0){
            var url = "<?php echo site_url(); ?>AppIFV/Biblioteca_Especialidad_Modulo";
        
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_especialidad':id_especialidad},
                success:function (resp) {
                    $('#select_modulo').html(resp);
                }
            });
        }else{
            $('#select_modulo').html('<select class="form-control" id="id_modulo" name="id_modulo"><option value="0">Seleccione</option></select>');
        }

        Unidad_Didactica();
    }

    function Ciclo(){
        $(document)
        .ajaxStart(function () {
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
        });
        
        var id_especialidad = $('#id_especialidad').val();
        var id_modulo = $('#id_modulo').val();

        if(id_modulo>0){
            var url = "<?php echo site_url(); ?>AppIFV/Biblioteca_Modulo_Ciclo";
        
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_especialidad':id_especialidad,'id_modulo':id_modulo},
                success:function (resp) {
                    $('#select_ciclo').html(resp);
                }
            });
        }else{
            $('#select_ciclo').html('<select class="form-control" id="id_ciclo" name="id_ciclo"><option value="0">Seleccione</option></select>');
        }
    }

    function Unidad_Didactica(){
        $(document)
        .ajaxStart(function () {
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
        });
        
        var id_especialidad = $('#id_especialidad').val();

        if(id_especialidad>0){
            var url = "<?php echo site_url(); ?>AppIFV/Unidad_Didactica";
        
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_especialidad':id_especialidad},
                success:function (resp) {
                    $('#select_unidad_didactica').html(resp);
                }
            });
        }else{
            $('#select_unidad_didactica').html('<select class="form-control" id="id_unidad_didactica" name="id_unidad_didactica"><option value="0">Seleccione</option></select>');
        }
    }

    function Update_Accion_biblioteca(){
        $(document)
        .ajaxStart(function () {
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
        });

        var dataString = new FormData(document.getElementById('formulario_detalle'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Accion_Biblioteca";

        if (Valida_Update_Accion_biblioteca()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    var cadena = data;
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);
                    if (validacion == 1) {
                        swal.fire(
                            'Solicitud Denegada',
                            '¡El Libro no está disponible, por favor verificar!',
                            'error'
                        ).then(function() {
                        });
                    }if (validacion == 2) {
                        swal.fire(
                            'Devolución Denegada',
                            '¡El Libro ya fue devuelto, por favor verificar!',
                            'error'
                        ).then(function() {
                        });
                    }if (validacion == "") {
                        swal.fire(
                            'Registro Exitoso',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Registro_Biblioteca";
                        });
                    }
                    
                }
            });
        }
    }

    function Ver_Scanner(o){
        $('#valor').val(o);
        $('#formulario_scanner').submit();
    }

    function Valida_Update_Accion_biblioteca() {
        if($('#accion').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar acción (Requisito, Devolver o Perdido).',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#pagamento_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Pagamento.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }

    function Consulta_Almuno_Temporal_Biblioteca(){
        $(document)
        .ajaxStart(function () {
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
        });

        var url="<?php echo site_url(); ?>AppIFV/Consulta_Almuno_Temporal_Biblioteca";

        $.ajax({
            url:url,
            type:"POST",
            success:function (data) {
                $('#div_alumno').html(data);
            }
        });
        
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>