<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>.:: Asistencia ::.</title>
	    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/estilo2.css">
        <link href="<?=base_url() ?>template/chosen/chosen.css" rel="stylesheet"> 
        <link href="<?=base_url() ?>template/css/core.css" rel="stylesheet" type="text/css">
        <script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>
        <link href="<?=base_url() ?>template/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url() ?>template/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url() ?>template/assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url() ?>template/assets/css/components.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>
        <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/forms/selects/select2.min.js"></script>
        <link rel="stylesheet" href="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.css')?>">
	</head>

    <div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title"><b>Registrar Ingreso</b></h5>
                </div>

                <div class="modal-body" style="max-height:520px; overflow:auto;">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Observación:</label>
                        </div>
                        <div class="form-group col-md-10">
                            <textarea class="form-control" id="observacion" name="observacion" placeholder="Observación" rows="5"></textarea>
                        </div>
                    </div>  	 
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="alumno_observacion" name="alumno_observacion">
                    <button type="button" class="btn btn-primary" style="margin-top:8px;" onclick="Insert_Observacion()">
                        <i class="glyphicon glyphicon-ok-sign"></i> Informar
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="acceso_modal_eli" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content"></div>
        </div>
    </div>

    <div id="acceso_modal_autorizacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body" style="max-height:520px; overflow:auto;">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Esta acción obliga a una clave de administrador:</label>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="password" class="form-control" id="clave_admin_condicionado" name="clave_admin_condicionado" placeholder="Clave">
                        </div>
                    </div>  	           	                	        
                </div> 
                
                <div class="modal-footer">
                    <input type="hidden" id="alumno_condicionado_autorizacion" name="alumno_condicionado_autorizacion">
                    <input type="hidden" id="observacion_condicionado_autorizacion" name="observacion_condicionado_autorizacion">
                    <button type="button" class="btn btn-primary" onclick="Autorizacion_Condicionado()">
                        Validar
                    </button>
                </div>
            </div>
        </div>
    </div>

	<div id="modal_ver" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title"><b>Registrar Ingresoa</b></h5>
                </div>
    
                <div class="modal-body" style="max-height:520px; overflow:auto;">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <div class="contenedor-seleccionar">
                                <label class="card activar1" id="activar1" for="card1"><label for="card1" class="descrip3">Falta</label><input type="checkbox" id="card1" name="opcion" value="1"><label for="card1" class="circulo"></label></label>
                                <label class="card activar2" id="activar2" for="card2"><label for="card2" class="descrip3">Retraso</label><input type="checkbox" id="card2" name="opcion" value="2"><label for="card2" class="circulo"></label></label>
                                <label class="card activar3" id="activar3" for="card3"><label for="card3" class="descrip3">Fotocheck</label><input type="checkbox" id="card3" name="opcion" value="3"><label for="card3" class="circulo"></label></label>
                                <label class="card activar4" id="activar4" for="card4"><label for="card4" class="descrip3">Documentos</label><input type="checkbox" id="card4" name="opcion" value="4"><label for="card4" class="circulo"></label></label>
                                <label class="card activar5" id="activar5" for="card5"><label for="card5" class="descrip3">Foto</label><input type="checkbox" id="card5" name="opcion" value="5"><label for="card5" class="circulo"></label></label>
                                <label class="card activar6" id="activar6" for="card6"><label for="card6" class="descrip3">Uniforme</label><input type="checkbox" id="card6" name="opcion" value="6"><label for="card6" class="circulo"></label></label>
                                <label class="card activar7" id="activar7" for="card7"><label for="card7" class="descrip3">Presentación</label><input type="checkbox" id="card7" name="opcion" value="7"><label for="card7" class="circulo"></label></label>
                                <label class="card activar8" id="activar8" for="card8"><label for="card8" class="descrip3">Pagos</label><input type="checkbox" id="card8" name="opcion" value="8"><label for="card8" class="circulo"></label></label>
                            </div>
                        </div>
					    <div class="col-md-12 row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control" id="observacion_condicionado" name="observacion_condicionado" placeholder="Observación" rows="5" style="width: 102% !important;"></textarea>
                                </div>
                        </div>

					    <div class="modal-footer text-center">
                            <!--
                            <input type="text" id="alumno_condicionado9" name="alumno_condicionado9" value="<?php $codigo_alumno ?>"><?php echo $codigo_alumno ?>
                            
                            <img src="<?= base_url() ?>template/img/iconslupa.png" style="position: absolute;left: 20px;bottom: 15px; width: 5%;" data-toggle="modal" data-target="#modal_ver2" app_crear_ver="<?= site_url('Asistencia/Lista_Historico')?>">
                            -->
                            <button type="button" class="btn" style="background-color:#c5e0b4;width:120px;" onclick="Ingresa_Condicionado()">Ingresa</button>
                            <button type="button" class="btn" style="background-color:#eaeaa3;width:120px;" onclick="Abrir_Autorizacion()">Autorización</button>
                            <button type="button" class="btn" style="background-color:#f8cbad;width:120px;" onclick="No_Ingresa_Condicionado()">NO Ingresa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="modal_ver2" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content"></div>
        </div>
    </div>

    <div id="modal_registro_manual" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><b>Registrar Ingreso</b></h5>
                    </div>

                    <div class="modal-body" style="max-height:520px; overflow:auto;">
                        <div id="select_registro_manual" class="col-md-12 row">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Alumno:</label>
                            </div>
                            <div class="form-group col-md-10">
                                <select class="form-control basic" name="alumno" id="alumno" onchange="Traer_Pendientes();">
                                    <option value="0">Seleccione</option>
                                    <?php foreach($list_alumno as $list){  ?>
                                        <option value="<?php echo $list['Codigoa']; ?>"><?php echo $list['nombres']; ?></option> 
                                    <?php } ?>
                                </select>
                            </div>
                        </div>  	           	                	        
                    </div> 
                    
                    <div class="modal-footer">
                        <input type="hidden" id="documentos_pendientes" name="documentos_pendientes">
                        <button type="button" class="btn btn-primary" onclick="Insert_Alumno_FV_Modal()">
                            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                
    <script>
        $("#acceso_modal").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_per"));
        });

        $("#acceso_modal_mod").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_mod"));
        });

        $("#acceso_modal_eli").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_eli"));
        });

        $("#acceso_modal_error").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_error"));
        });

        $("#acceso_modal_autorizacion").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_autorizacion"));
        });

 		$("#modal_ver2").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_ver"));
        });

    </script>

	<body>
		<div class="contenedor-general">
            <div class="contenedor-superior">
				<div class="contenedor-img">
					<img src="<?= base_url() ?>template/img/logo_ifv-blanco.png">
				</div>
                <!--
                <div class="contenedor-imgpalabras3">
					<img src="<?= base_url() ?>template/img/Iconos Descargar y Subir Archivo-06.png">
				</div>
                <div class="contenedor-imgpalabras4">
					<img src="<?= base_url() ?>template/img/Iconos Descargar y Subir Archivo-07.png">
				</div>
                -->
				<div class="contenedor-reloj">
					<div id="countdown">
						<div id='tiles'></div>
						<div class="labels">
							<li>Hora</li>
							<li>Minutos</li>
							<li>Segundos</li>
						</div>
					</div>
				</div>
			</div>
			<div class="contenedor-inferior">
				<div class="contenedor-tabla" id="tabla">
				</div>

				<div class="contenedor-datos">
					<div class="contenedor-busqueda">
						<div class="contenedor-busqueda-input">
							<input type="password" class="text" id="codigo_alumno" name="codigo_alumno" onkeypress="if(event.keyCode == 13){ Insert_Alumno_FV(); }">
                            <?php if($_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==10 || $_SESSION['usuario'][0]['id_usuario']==76 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                                <!--<a class="contenedor-busqueda-lupa" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Asistencia/Modal_Registro_Ingreso') ?>">
                                    <img src="<?= base_url() ?>template/img/lupa.png" class="contenedor-busqueda-lupa-img"></img>
                                </a>-->

                                <a class="contenedor-busqueda-lupa" data-toggle="modal" data-target="#acceso_modal_eli" app_crear_eli="<?= site_url('Asistencia/Modal_Valida_Registro_Manual') ?>">
                                    <img src="<?= base_url() ?>template/img/lupa.png" class="contenedor-busqueda-lupa-img"></img>
                                </a>
                            <?php }else{ ?>
                                <a class="contenedor-busqueda-lupa" href="#">
                                    <img src="<?= base_url() ?>template/img/lupa.png" class="contenedor-busqueda-lupa-img"></img>
                                </a>
                            <?php } ?>
						</div>
					</div>

					<div class="contenedor-tarjeta" id="div_busqueda">
					</div>

					<div class="contenedor-botones" id="botones_bajos">
					</div>
				</div>
			</div>
            <!--
            <div class="flotante">
                <img src="<?= base_url() ?>template/img/cuadrados.png">
            </div>
            -->
		</div>
	</body>
</html>

<script src="<?php echo base_url(); ?>template/plugins/blockui/jquery.blockUI.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/blockui/custom-blockui.js"></script>
<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>

<script>
    $(document).ready(function() {
        Lista_Registro_Ingreso();
        Botones_Bajos();
        $('#codigo_alumno').focus();
    });

	function Lista_Registro_Ingreso(){
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

        var url = "<?php echo site_url(); ?>Asistencia/Lista_Registro_Ingreso";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#tabla').html(resp);
            }
        });
    }

    function Botones_Bajos(){
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

        var url = "<?php echo site_url(); ?>Asistencia/Botones_Bajos";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#botones_bajos').html(resp);
            }
        });
    }

	function Insert_Alumno_FV(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 600,
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
                fadeIn: 600,
                timeout: 50,
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
        
        var url = "<?php echo site_url(); ?>Asistencia/Insert_Alumno_FV";
        var url2 = "<?php echo site_url(); ?>Asistencia/ReInsert_Alumno_FV";
        var url3 = "<?php echo site_url(); ?>Asistencia/Update_Alumno_FV";
        var codigo_alumno = $("#codigo_alumno").val();

        $.ajax({
            url: url,
            type: 'POST', 
            data: {'codigo_alumno':codigo_alumno},
            success: function(data){
                if(data=="error"){
                    swal.fire(
                        'Registro Denegado',
                        '¡No se encontró el alumno!',
                        'error'
                    ).then(function() {
                        $('#div_busqueda').html('');
                    });
                }else if(data=="promovido"){
                    swal.fire(
                        'Registro Denegado',
                        '¡Alumno no Matriculado!',
                        'error'
                    ).then(function() {
                        $('#div_busqueda').html('');
                    });
                }else if(data=="repetido"){
                    Swal({
                        title: '¿Realmente desea registrar nuevamente el ingreso',
                        text: "El registro será registrado nuevamente",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: url2,
                                data: {'codigo_alumno':codigo_alumno},
                                success:function (data) {
                                    $('#div_busqueda').html(data);
                                    Lista_Registro_Ingreso();
                                    Botones_Bajos();
                                    if($('#simbolo').val()==1){
                                        //$("#acceso_modal_mod").modal("show");
                                        $("#alumno_observacion").val(codigo_alumno);
                                    }else if($('#simbolo').val()==2){
                                        $("#modal_ver").modal("show");
                                        //$("#acceso_modal_mod").modal("show");
                                        $("#alumno_observacion").val(codigo_alumno);
                                    }else if($('#simbolo').val()==3){
                                        $("#modal_ver").modal("show");
                                        //$("#acceso_modal_error").modal("show");
                                        $("#alumno_condicionado").val(codigo_alumno);
                                    }
                                }
                            });
                        }
                    })
                }else if(data=="pagos"){
                    swal.fire(
                        'Registro Denegado',
                        '¡Pendiente Pago Mat + Cuota 1!',
                        'error'
                    ).then(function() {
                        $('#div_busqueda').html('');
                    });
                }else if(data=="cuotas"){
                    swal.fire(
                        '¡No apto para ingreso!',
                        'Pendiente pagos',
                        'error'
                    ).then(function() {
                        $('#div_busqueda').html('');
                    });
                }else if(data=="reingreso"){
                    Swal({
                        title: '¿Realmente desea registrar nuevamente el ingreso',
                        text: "El registro será registrado nuevamente",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: url2,
                                data: {'codigo_alumno':codigo_alumno},
                                success:function (data) {
                                    $('#div_busqueda').html(data);
                                    Lista_Registro_Ingreso();
                                    Botones_Bajos();
                                    if($('#simbolo').val()==1){
                                        //$("#acceso_modal_mod").modal("show");
                                        $("#alumno_observacion").val(codigo_alumno);
                                    }else if($('#simbolo').val()==2){
                                        $("#modal_ver").modal("show");
                                        //$("#acceso_modal_mod").modal("show");
                                        $("#alumno_observacion").val(codigo_alumno);
                                    }else if($('#simbolo').val()==3){
                                        $("#modal_ver").modal("show");
                                        //$("#acceso_modal_error").modal("show");
                                        $("#alumno_condicionado").val(codigo_alumno);
                                    }
                                }
                            });
                        }else{
                            $.ajax({
                                type: "POST",
                                url: url3,
                                data: {'codigo_alumno':codigo_alumno},
                                success:function (data) {
                                    $('#div_busqueda').html(data);
                                    Lista_Registro_Ingreso();
                                    Botones_Bajos();
                                    if($('#simbolo').val()==1){
                                        //$("#acceso_modal_mod").modal("show");
                                        $("#alumno_observacion").val(codigo_alumno);
                                    }else if($('#simbolo').val()==2){
                                        $("#modal_ver").modal("show");
                                        //$("#acceso_modal_mod").modal("show");
                                        $("#alumno_observacion").val(codigo_alumno);
                                    }else if($('#simbolo').val()==3){
                                        $("#modal_ver").modal("show");
                                        //$("#acceso_modal_error").modal("show");
                                        $("#alumno_condicionado").val(codigo_alumno);
                                    }
                                }
                            });
                        }
                    })
                }else{
                    $('#div_busqueda').html(data);
                    Lista_Registro_Ingreso();
                    Botones_Bajos();
                    if($('#simbolo').val()==1){
                        //$("#acceso_modal_mod").modal("show");
                        $("#alumno_observacion").val(codigo_alumno);
                    }else if($('#simbolo').val()==2){
                        $("#modal_ver").modal("show");
                        //$("#acceso_modal_mod").modal("show");
                        $("#alumno_observacion").val(codigo_alumno);
                    }else if($('#simbolo').val()==3){
                        $("#modal_ver").modal("show");
                        //$("#acceso_modal_error").modal("show");
                        $("#alumno_condicionado").val(codigo_alumno);
                    }
                }
            }
        });

        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    function Insert_Observacion(){
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

        var codigo_alumno = $('#codigo_alumno').val();
        var observacion = $('#observacion').val();
        var url = "<?php echo site_url(); ?>Asistencia/Insert_Observacion";

        if(Valida_Insert_Observacion()){
            $.ajax({
                url: url,
                type:"POST",
                data: {'codigo_alumno':codigo_alumno,'observacion':observacion},
                success: function(data){
                    $('#div_busqueda').html(data);
                    Lista_Registro_Ingreso();
                    Botones_Bajos();
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
       
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    function Valida_Insert_Observacion() {
        if($('#observacion').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Observación.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    } 
     
    $("#acceso_modal_mod").on("hidden.bs.modal", function () {
        $('#observacion').val('');
        $('#alumno_observacion').val('');
    });  

    $("#acceso_modal_eli").on("hidden.bs.modal", function () {
        $('#clave_admin').val('');
    }); 

    function Ingresa_Condicionado(){
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
        var card1 = document.getElementById('activar1');
        var card2 = document.getElementById('activar2');
        var card3 = document.getElementById('activar3');
        var card4 = document.getElementById('activar4');
        var card5 = document.getElementById('activar5');
        var card6 = document.getElementById('activar6');
        var card7 = document.getElementById('activar7');
        var card8 = document.getElementById('activar8');
        var chbox1 = document.getElementById('card1');
        var chbox2 = document.getElementById('card2');
        var chbox3 = document.getElementById('card3');
        var chbox4 = document.getElementById('card4');
        var chbox5 = document.getElementById('card5');
        var chbox6 = document.getElementById('card6');
        var chbox7 = document.getElementById('card7');
        var chbox8 = document.getElementById('card8');
        
        if(chbox1.checked){
            var tipo = chbox1.value;
        }
        if(chbox2.checked){
            var tipo = chbox2.value;
        }
        if(chbox3.checked){
            var tipo = chbox3.value;
        }
        if(chbox4.checked){
            var tipo = chbox4.value;
        }
        if(chbox5.checked){
            var tipo = chbox5.value;
        }
        if(chbox6.checked){
            var tipo = chbox6.value;
        }
        if(chbox7.checked){
            var tipo = chbox7.value;
        }
        if(chbox8.checked){
            var tipo = chbox8.value;
        }

        var url = "<?php echo site_url(); ?>Asistencia/Insert_Observacion";
        var observacion = $('#observacion_condicionado').val();
        var codigo_alumno = $("#cod_alum").val();

        if(observacion==""){
            Swal({
                title: 'No escribiste en observaciones. Es importante que menciones',
                text: "El registro será registrado sin observaciones",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {'codigo_alumno':codigo_alumno,'observacion':observacion,'tipo':tipo},
                        success:function (data) {
                            $('#div_busqueda').html(data);
                            Lista_Registro_Ingreso();
                            Botones_Bajos();
                            $("#modal_ver").modal("hide");
                        }
                    });
                }
            })
        }else{
            $.ajax({
                url: url,
                type: 'POST',
                data: {'codigo_alumno':codigo_alumno,'observacion':observacion,'tipo':tipo},
                success: function(data){
                    $('#div_busqueda').html(data);
                    Lista_Registro_Ingreso();
                    Botones_Bajos();
                    $("#modal_ver").modal("hide");
                }
            });
        }
        chbox1.checked=false;
        chbox2.checked=false;
        chbox3.checked=false;
        chbox4.checked=false;
        chbox5.checked=false;
        chbox6.checked=false;
        chbox7.checked=false;
        chbox8.checked=false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
        $('#observacion_condicionado').val('');
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    function Abrir_Autorizacion(){
        var codigo_alumno = $("#cod_alum").val();
        var observacion = $('#observacion_condicionado').val();
        
        $("#modal_ver").modal("hide");
        $("#acceso_modal_autorizacion").modal("show");
        $('#alumno_condicionado_autorizacion').val(codigo_alumno);
        $("#observacion_condicionado_autorizacion").val(observacion);
    }

    function Autorizacion_Condicionado(){
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
        
        var card1 = document.getElementById('activar1');
        var card2 = document.getElementById('activar2');
        var card3 = document.getElementById('activar3');
        var card4 = document.getElementById('activar4');
        var card5 = document.getElementById('activar5');
        var card6 = document.getElementById('activar6');
        var card7 = document.getElementById('activar7');
        var card8 = document.getElementById('activar8');
        var chbox1 = document.getElementById('card1');
        var chbox2 = document.getElementById('card2');
        var chbox3 = document.getElementById('card3');
        var chbox4 = document.getElementById('card4');
        var chbox5 = document.getElementById('card5');
        var chbox6 = document.getElementById('card6');
        var chbox7 = document.getElementById('card7');
        var chbox8 = document.getElementById('card8');
        
        if(chbox1.checked){
            var tipo = chbox1.value;
        }
        if(chbox2.checked){
            var tipo = chbox2.value;
        }
        if(chbox3.checked){
            var tipo = chbox3.value;
        }
        if(chbox4.checked){
            var tipo = chbox4.value;
        }
        if(chbox5.checked){
            var tipo = chbox5.value;
        }
        if(chbox6.checked){
            var tipo = chbox6.value;
        }
        if(chbox7.checked){
            var tipo = chbox7.value;
        }
        if(chbox8.checked){
            var tipo = chbox8.value;
        }

        var url = "<?php echo site_url(); ?>Asistencia/Autorizacion_Condicionado";
        var observacion = $('#observacion_condicionado_autorizacion').val();
        var codigo_alumno = $("#alumno_condicionado_autorizacion").val();
        var clave_admin = $("#clave_admin_condicionado").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'codigo_alumno':codigo_alumno,'observacion':observacion,'clave_admin':clave_admin,'tipo':tipo},
            success: function(data){
                if(data=="error"){
                    Swal({
                        title: 'Autorización Denegada',
                        text: "¡Clave Incorrecta!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    $('#div_busqueda').html(data);
                    $("#acceso_modal_autorizacion").modal("hide");
                    Lista_Registro_Ingreso();
                    Botones_Bajos();
                }
            }
        });
        chbox1.checked=false;
        chbox2.checked=false;
        chbox3.checked=false;
        chbox4.checked=false;
        chbox5.checked=false;
        chbox6.checked=false;
        chbox7.checked=false;
        chbox8.checked=false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
        $('#observacion_condicionado').val('');
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    $("#acceso_modal_autorizacion").on("hidden.bs.modal", function () {
        $('#clave_admin_condicionado').val('');
    }); 

    function No_Ingresa_Condicionado(){
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
        var card1 = document.getElementById('activar1');
        var card2 = document.getElementById('activar2');
        var card3 = document.getElementById('activar3');
        var card4 = document.getElementById('activar4');
        var card5 = document.getElementById('activar5');
        var card6 = document.getElementById('activar6');
        var card7 = document.getElementById('activar7');
        var card8 = document.getElementById('activar8');
        var chbox1 = document.getElementById('card1');
        var chbox2 = document.getElementById('card2');
        var chbox3 = document.getElementById('card3');
        var chbox4 = document.getElementById('card4');
        var chbox5 = document.getElementById('card5');
        var chbox6 = document.getElementById('card6');
        var chbox7 = document.getElementById('card7');
        var chbox8 = document.getElementById('card8');
        
        if(chbox1.checked){
            var tipo = chbox1.value;
        }
        if(chbox2.checked){
            var tipo = chbox2.value;
        }
        if(chbox3.checked){
            var tipo = chbox3.value;
        }
        if(chbox4.checked){
            var tipo = chbox4.value;
        }
        if(chbox5.checked){
            var tipo = chbox5.value;
        }
        if(chbox6.checked){
            var tipo = chbox6.value;
        }
        if(chbox7.checked){
            var tipo = chbox7.value;
        }
        if(chbox8.checked){
            var tipo = chbox8.value;
        }

        var url = "<?php echo site_url(); ?>Asistencia/No_Ingresa_Condicionado";
        var observacion = $('#observacion_condicionado').val();
        var codigo_alumno = $("#cod_alum").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'codigo_alumno':codigo_alumno,'observacion':observacion,'tipo':tipo},
            success: function(data){
                Lista_Registro_Ingreso();
                Botones_Bajos();
                $("#modal_ver").modal("hide");
            }
        });
        chbox1.checked=false;
        chbox2.checked=false;
        chbox3.checked=false;
        chbox4.checked=false;
        chbox5.checked=false;
        chbox6.checked=false;
        chbox7.checked=false;
        chbox8.checked=false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
        $('#observacion_condicionado').val('');
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    $("#acceso_modal_error").on("hidden.bs.modal", function () {
        $('#observacion_condicionado').val('');
        $('#alumno_condicionado').val('');
    });  

    function Salir(){
        window.location = "<?php echo site_url(); ?>Login/logout";
    }
</script>

<script>
	function actual() {
        fecha=new Date(); //Actualizar fecha.
        hora=fecha.getHours(); //hora actual
        minuto=fecha.getMinutes(); //minuto actual
        segundo=fecha.getSeconds(); //segundo actual
        if (hora<10) { //dos cifras para la hora
            hora="0"+hora;
        }
        if (minuto<10) { //dos cifras para el minuto
            minuto="0"+minuto;
        }
        if (segundo<10) { //dos cifras para el segundo
            segundo="0"+segundo;
        }
        //ver en el recuadro del reloj:
        mireloj = hora+" : "+minuto+" : "+segundo;	
        return mireloj; 
    }

    function actualizar() { //función del temporizador
        fecha=new Date(); //Actualizar fecha.
        hora=fecha.getHours(); //hora actual
        minuto=fecha.getMinutes(); //minuto actual

        var label = document.getElementById('countdown');
		/*
        if(Number(hora)>=7){
            if(Number(hora)==7 && (Number(minuto)==0 || Number(minuto)==1 || Number(minuto)==2 || Number(minuto)==3 || 
            Number(minuto)==4 || Number(minuto)==5 || Number(minuto)==6 || Number(minuto)==7 || Number(minuto)==8 || 
            Number(minuto)==9 || Number(minuto)==10 || Number(minuto)==11 || Number(minuto)==12 || Number(minuto)==13 || 
            Number(minuto)==14 || Number(minuto)==15 || Number(minuto)==16 || Number(minuto)==17 || Number(minuto)==18 || 
            Number(minuto)==19 || Number(minuto)==20 || Number(minuto)==21 || Number(minuto)==22 || Number(minuto)==23 || 
            Number(minuto)==24 || Number(minuto)==25 || Number(minuto)==26 || Number(minuto)==27 || Number(minuto)==28 || 
            Number(minuto)==29 || Number(minuto)==30)){
                label.style.backgroundColor = '#6B586E';
            }else{
                label.style.backgroundColor = '#C00';
            }
        }else{
            label.style.backgroundColor = '#6B586E';
        }
		*/

        mihora=actual(); //recoger hora actual
        mireloj=document.getElementById("tiles"); //buscar elemento reloj
        //mireloj.innerHTML=mihora; //incluir hora en elemento
		mireloj.innerHTML = "<span>" + hora + "</span><span>" + minuto + "</span><span>" + segundo + "</span>"; 
    }

    setInterval(actualizar,1000); //iniciar temporizador
</script>

<script>
	function abrirmodal(){
 
        $("#modal_ver").modal("show");
	}
    function abrirmodal2(){
        var url = "<?php echo site_url(); ?>Asistencia/Lista_Historico";
        var codigo_alumno = $("#cod_alum").val();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {'codigo_alumno':codigo_alumno},
            success: function(resp){
                //$('#tabla').html(resp);
            }
        });
		//$("#modal_ver2").modal("show");
	}
</script>

<style>
    .descrip3{
        font-size: 13px;
        display: block;
        width: 100%;
        text-align: center;
        align-self: center;
        }
    input[type='checkbox']{
        display: none;
    }
    .contenedor-seleccionar{
        width: 100%;
        display: grid;
        grid-template-columns: repeat(8 , 1fr);
        
    }
    .card {
        width: 90px;
        height: 100px;
        border-radius: 2px;
        background: #dcdbdc;
        border: 3px solid transparent;
        margin: 10px auto 40px;
        caret-color: transparent;
        margin: 0 auto;
        display: grid;
        grid-template-rows: repeat(1 , 1fr);
    }
    .card-active{
    /*border: 2px solid #0a0c0a4a;*/
    background: #92d14f;
  }

	.contenedor-tabla::-webkit-scrollbar-button:vertical:start:increment {
            background: transparent url('<?= base_url() ?>template/img/arrow_up.png') no-repeat center center;
	}
	.contenedor-tabla::-webkit-scrollbar-button:vertical:end:increment {
		background: transparent url('<?= base_url() ?>template/img/arrow_down.png') no-repeat center center;
	}
	.contenedor-tabla::-webkit-scrollbar-button:vertical:start:decrement {
		background: transparent url('<?= base_url() ?>template/img/arrow_up.png') no-repeat center center;
	}
	.contenedor-tabla::-webkit-scrollbar-button:vertical:end:decrement {
		background: transparent url('<?= base_url() ?>template/img/arrow_down.png') no-repeat center center;
	}
	#tabla{
		/*background: linear-gradient(rgb(113 199 245 / 55%),rgb(113 199 245 / 55%)),url('<?=base_url()?>/template/img/imagen1.png');*/
		/*background-image: url('<?= base_url() ?>template/img/imagen1.png');
		opacity: .5;*/
		background:#f8f9fd;
	}
</style>
<script>
  var card1 = document.getElementById('activar1');
  var card2 = document.getElementById('activar2');
  var card3 = document.getElementById('activar3');
  var card4 = document.getElementById('activar4');
  var card5 = document.getElementById('activar5');
  var card6 = document.getElementById('activar6');
  var card7 = document.getElementById('activar7');
  var card8 = document.getElementById('activar8');
  var chbox1 = document.getElementById('card1');
  var chbox2 = document.getElementById('card2');
  var chbox3 = document.getElementById('card3');
  var chbox4 = document.getElementById('card4');
  var chbox5 = document.getElementById('card5');
  var chbox6 = document.getElementById('card6');
  var chbox7 = document.getElementById('card7');
  var chbox8 = document.getElementById('card8');
  $(function () {
    
    $('.activar1').click(function () {
      if(chbox1.checked == true) {
        card1.classList.add("card-active");
        chbox2.checked = false;
        chbox3.checked = false;
        chbox4.checked = false;
        chbox5.checked = false;
        chbox6.checked = false;
        chbox7.checked = false;
        chbox8.checked = false;
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card1.classList.remove("card-active");
      }
    });

    $('.activar2').click(function () {
      
      if(chbox2.checked == true) {
        card2.classList.add("card-active");
        chbox1.checked = false;
        chbox3.checked = false;
        chbox4.checked = false;
        chbox5.checked = false;
        chbox6.checked = false;
        chbox7.checked = false;
        chbox8.checked = false;
        card1.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card2.classList.remove("card-active");
      }
    });

    $('.activar3').click(function () {
      
      if(chbox3.checked == true) {
        card3.classList.add("card-active");
        chbox1.checked = false;
        chbox2.checked = false;
        chbox4.checked = false;
        chbox5.checked = false;
        chbox6.checked = false;
        chbox7.checked = false;
        chbox8.checked = false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card3.classList.remove("card-active");
      }
    });

    $('.activar4').click(function () {
      
      if(chbox4.checked == true) {
        card4.classList.add("card-active");
        chbox1.checked = false;
        chbox2.checked = false;
        chbox3.checked = false;
        chbox5.checked = false;
        chbox6.checked = false;
        chbox7.checked = false;
        chbox8.checked = false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card4.classList.remove("card-active");
      }
    });

    $('.activar5').click(function () {
      
      if(chbox5.checked == true) {
        card5.classList.add("card-active");
        chbox1.checked = false;
        chbox2.checked = false;
        chbox3.checked = false;
        chbox4.checked = false;
        chbox6.checked = false;
        chbox7.checked = false;
        chbox8.checked = false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card5.classList.remove("card-active");
      }
    });

    $('.activar6').click(function () {
      
      if(chbox6.checked == true) {
        card6.classList.add("card-active");
        chbox1.checked = false;
        chbox2.checked = false;
        chbox3.checked = false;
        chbox4.checked = false;
        chbox5.checked = false;
        chbox7.checked = false;
        chbox8.checked = false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card7.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card6.classList.remove("card-active");
        
      }
    });

    $('.activar7').click(function () {
     
      if(chbox7.checked == true) {
        card7.classList.add("card-active");
        chbox1.checked = false;
        chbox2.checked = false;
        chbox3.checked = false;
        chbox4.checked = false;
        chbox5.checked = false;
        chbox6.checked = false;
        chbox8.checked = false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card8.classList.remove("card-active");
      }else{
        card7.classList.remove("card-active");
        
      }
    });

    $('.activar8').click(function () {
     
      if(chbox8.checked == true) {
        card8.classList.add("card-active");
        chbox1.checked = false;
        chbox2.checked = false;
        chbox3.checked = false;
        chbox4.checked = false;
        chbox5.checked = false;
        chbox6.checked = false;
        chbox7.checked = false;
        card1.classList.remove("card-active");
        card2.classList.remove("card-active");
        card3.classList.remove("card-active");
        card4.classList.remove("card-active");
        card5.classList.remove("card-active");
        card6.classList.remove("card-active");
        card7.classList.remove("card-active");
      }else{
        card8.classList.remove("card-active");
        
      }
    });
  });
</script>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    $('.basic').select2({
        dropdownParent: $('#modal_registro_manual')
    });

    function Limpiar_Select_Alumno(){ 
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

        var url="<?php echo site_url(); ?>Asistencia/Limpiar_Select_Alumno";

        $.ajax({
            type:"POST",
            url: url,
            success:function (resp) {
                $('#select_registro_manual').html(resp);
            }
        });
    }

    function Traer_Pendientes(){
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

        var url="<?php echo site_url(); ?>Asistencia/Traer_Pendientes";
        var alumno = $('#alumno').val();

        $.ajax({
            type:"POST",
            url: url,
            data: {'alumno':alumno},
            success:function (data) {
                $('#documentos_pendientes').val(data);
            }
        });
    }

    function Insert_Alumno_FV_Modal(){
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "<?php echo site_url(); ?>Asistencia/Insert_Alumno_FV_Modal";
        var url2 = "<?php echo site_url(); ?>Asistencia/ReInsert_Alumno_FV_Modal";
        var url3 = "<?php echo site_url(); ?>Asistencia/Update_Alumno_FV_Modal";
        var documentos_pendientes = $('#documentos_pendientes').val();
        var alumno = $('#alumno').val();

        if(Valida_Insert_Alumno_FV_Modal()){
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success: function(data){
                    if(data=="error"){
                        swal.fire(
                            'Registro Denegado',
                            '¡No se encontró el alumno!',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else if(data=="repetido"){
                        Swal({
                            title: '¿Realmente desea registrar nuevamente el ingreso',
                            text: "El registro será registrado nuevamente",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: url2,
                                    data: dataString,
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        $('#div_busqueda').html(data);
                                        $("#modal_registro_manual .close").click()
                                        Lista_Registro_Ingreso();
                                        Botones_Bajos();
                                        if($('#simbolo').val()==1){
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==2){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==3){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_error").modal("show");
                                            $("#alumno_condicionado").val(codigo_alumno);
                                        }
                                    }
                                });
                            }
                        })
                    }else if(data=="pagos"){
                        swal.fire(
                            'Registro Denegado',
                            '¡Pendiente Pago Mat + Cuota 1!',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else if(data=="cuotas"){
                        swal.fire(
                            '¡No apto para ingreso!',
                            'Pendiente pagos',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else if(data=="reingreso"){
                        Swal({
                            title: '¿Realmente desea registrar nuevamente el ingreso',
                            text: "El registro será registrado nuevamente",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: url2,
                                    data: dataString,
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        $('#div_busqueda').html(data);
                                        $("#modal_registro_manual .close").click()
                                        Lista_Registro_Ingreso();
                                        Botones_Bajos();
                                        if($('#simbolo').val()==1){
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==2){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==3){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_error").modal("show");
                                            $("#alumno_condicionado").val(codigo_alumno);
                                        }
                                    }
                                });
                            }else{
                                $.ajax({
                                    type: "POST",
                                    url: url3,
                                    data: dataString,
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        $('#div_busqueda').html(data);
                                        $("#modal_registro_manual .close").click()
                                        Lista_Registro_Ingreso();
                                        Botones_Bajos();
                                        if($('#simbolo').val()==1){
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==2){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==3){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_error").modal("show");
                                            $("#alumno_condicionado").val(codigo_alumno);
                                        }
                                    }
                                });
                            }
                        })
                    }else if(data=="duplicidad"){ 
                        swal.fire(
                            '¡Registro Denegado!',
                            'No se puede hacer más de 10 registros manuales',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else{
                        $('#div_busqueda').html(data);
                        $("#modal_registro_manual .close").click()
                        Lista_Registro_Ingreso();
                        Botones_Bajos();
                        if($('#simbolo').val()==1){
                            //$("#acceso_modal_mod").modal("show");
                            $("#alumno_observacion").val(codigo_alumno);
                        }else if($('#simbolo').val()==2){
                            $("#modal_ver").modal("show");
                            //$("#acceso_modal_mod").modal("show");
                            $("#alumno_observacion").val(codigo_alumno);
                        }else if($('#simbolo').val()==3){
                            $("#modal_ver").modal("show");
                            //$("#acceso_modal_error").modal("show");
                            $("#alumno_condicionado").val(codigo_alumno);
                        }
                    }
                }
            });
        }
        
        Limpiar_Select_Alumno();
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    function Valida_Insert_Alumno_FV_Modal() {
        if($('#alumno').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>