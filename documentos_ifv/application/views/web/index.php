<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>.:: Documentos ::.</title>
	    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/estilo2.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/style-botones.css">
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
                    <h5 class="modal-title"><b>Registrar Ingreso</b></h5>
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
                            
                            <img src="<?= base_url() ?>template/img/iconslupa.png" style="position: absolute;left: 20px;bottom: 15px; width: 5%;" data-toggle="modal" data-target="#modal_ver2" app_crear_ver="<?= site_url('Login/Lista_Historico')?>">
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
                -->
			</div>
			<div class="contenedor-inferior">
                <form id="formulario_cargo" method="POST" enctype="multipart/form-data"  class="contendor_tabla">
                    
                        <div class="div1">
                            <label class="position1">DNI del alumno:</label>
                            <div class="respon-2">
                                <input id="dni_alumno" name="dni_alumno" type="text" maxlength="8" class="solo_numeros">
                            </div>
                    
                            <div class="respon-3">
                                <button type="button" class="btn1 button" onclick="Validar_Documentos();">Validar</button>
                            </div>
                        </div>
                        <div id="div_datos" class="div2">
                            <div class="titu4"><label class="position">Código:</label>
                                <input id="dni_re" name="dni_re" type="text" maxlength="8" class="input">
                            </div>
                            <div class="titu5"><label class="position">Alumno(a):</label>
                                <input id="celu_re" name="celu_re" type="text" maxlength="9" class="">
                            </div>
                            <div class="respon-5"><label class="position">Especialidad:</label>
                                <input id="corre_re" name="corre_re" type="text" maxlength="50" class="">
                            </div>
                        </div>
                        <div class="div4">
                            <div class="titu7"> 
                                <!--<img src="<?= base_url() ?>template/img/IMG_6.png" >-->
                            </div>
                        </div>   
                   
                    
                </form>
                
                    <div class="contenedor-tarjeta">
                        <div class="contenedor-mostrar-datos">
                            <div id="div_recuerda" class="contenedor-mostrar-inputs">
                                <!--<div class="cuadro1">
                                    <label class="cuardro1-text">Recuerda</label>
                                </div>
                                <div class="cuadro2">
                                    <img src="<?= base_url() ?>template/img/IMG_alerta.png" class="cuadro2-img">
                                    <label class="cuadro2-text">Son documentos obligatorios: xxxxx,xxxxx,xxxxx.<br>Puedes enviar solo un documento a la vez.</label>
                                </div>-->
                            </div>
                            <div class="contenedor-mostrar-text-img">
                                <div class="text5" id="cmb_documento">
                                    <label class="descrp5">Documentos a enviar:</label>
                                    <select class="select-css cmb5">
                                            <option>Seleccione</option>
                                            <!--<option>2</option>-->
                                    </select>
                                    <div class="dni5" id="divcampos" >
                                        <label id="textos"class="descrip5-2"></label>
                                        
                                        <label id="textodoc"class="img-dni-2"></label>
                                    </div>
                                </div>
                                <div class="text6">
                                    <form id="formulario_documento" method="POST" enctype="multipart/form-data" class="pruebas">
                                        <img src="<?= base_url() ?>template/img/IMG_NUBE.png" class="img5">
                                        <label class="text5la">Arrastra el documento aqui para subirlo de inmediato</label>
                                        
                                        <label class="text5la2">Peso maximo del documento 1mb.</label>
                                        <input type="file" id="documento" name="documento" >
                                        <input type="hidden" id="Codigo" name="Codigo">
                                        <input type="hidden" id="nom_alumno" name="nom_alumno">
                                        <input type="hidden" id="Apellido_Paterno" name="Apellido_Paterno">
                                        <input type="hidden" id="Apellido_Materno" name="Apellido_Materno">
                                        <input type="hidden" id="Especialidad" name="Especialidad">
                                        <input type="hidden" id="cod_documento" name="cod_documento">
                                        <input type="hidden" id="Dni" name="Dni">
                                        <input type="hidden" id="Email" name="Email">
                                    </form>
                                </div>
                                <div class="contenedor-botones">
                                    <div class="contenedor-boton1">
                                        <button class="colorboton1 cssbuttons-io-button " type="button" onclick="Cancelar_Enviar()"> Cancelar envío
                                        </button>
                                    </div>
                                    <div class="contenedor-boton2">
                                        <button class="colorboton2 cssbuttons-io-button" type="button" onclick="Enviar_Documento()"> Enviar
                                        </button>
                                        
                                    </div>		
                                </div>
                            </div>
                        </div>
                    </div>
			</div>
		</div>
	</body>
</html>


<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    documento.oninput = function() {
        if($('#Codigo').val().trim() === '') {
            Swal(
                'Ups!',
                'Primero tienes que ingresar DNI de un alumno matriculado.',
                'warning'
            ).then(function() { 
                var archivoInput = document.getElementById('documento');
                var archivoRuta = archivoInput.value;
                archivoInput.value = '';
            });
            return false;
        }
        if($('#cod_documento').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar documento a enviar.',
                'warning'
            ).then(function() {
                var archivoInput = document.getElementById('documento');
                var archivoRuta = archivoInput.value;
                archivoInput.value = '';
            });
            return false;
        }
        var archivoInput = document.getElementById('documento');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf)$/i;
        if(!extPermitidas.exec(archivoRuta)){
                Swal(
                    '!Archivo no permitido!',
                    'El archivo debe ser PDF',
                    'error'
                ).then(function() { });
            archivoInput.value = '';
            textodoc.innerHTML = '';
            textos.innerHTML = '';
            return false;
        }else{
            textodoc.innerHTML = '<img src="<?php echo base_url()."template/img/aceptar.png" ?>" alt="">'+documento.value;
            textos.innerHTML = "Se ha subido 1 documento";
        }
        
    };

     function valida(){
        var campos = document.getElementById('divcampos');
        var doc = $('#documento').val();
        if (doc != ''){
            //alert(doc);
            $('#textodoc').html(doc);
            campos.style.display = 'block';
        }else{
            campos.style.display = 'none';
        }
     }
    $(document).ready(function() {

        $('#dni_alumno').focus();
        
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Validar_Documentos(){
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
        
        var url = "<?php echo site_url(); ?>Login/Validar_Documentos";
        var dni_alumno = $("#dni_alumno").val();
        

        $.ajax({
            url: url,
            type: 'POST',
            data: {'dni_alumno':dni_alumno},
            success: function(data){
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: 'No encontramos ningún alumno matriculado con este Documento.',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    $('#div_datos').html(data);
                    Recuerda();
                }  
            }
        });

        //$('#dni_alumno').val('');
        //$('#dni_alumno').focus();
    }

    function Recuerda(){
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

        var url = "<?php echo site_url(); ?>Login/Recuerda";
        var dni_alumno = $("#dni_alumno").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'dni_alumno':dni_alumno},
            success: function(resp){
                //$('#div_recuerda').html(resp);
                $('#cmb_documento').html(resp);
                TipoDoc_Enviar();
            }
        });
    }

	function Lista_Registro_Ingreso(){
        /*$(document)
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
        });*/

        var url = "<?php echo site_url(); ?>Login/Lista_Registro_Ingreso";

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

        var url = "<?php echo site_url(); ?>Login/Botones_Bajos";

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
        
        var url = "<?php echo site_url(); ?>Login/Insert_Alumno_FV";
        var url2 = "<?php echo site_url(); ?>Login/ReInsert_Alumno_FV";
        var pagos_pendientes = $('#pagos_pendientes').val();
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
        var url = "<?php echo site_url(); ?>Login/Insert_Observacion";

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

        var url = "<?php echo site_url(); ?>Login/Insert_Observacion";
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

        var url = "<?php echo site_url(); ?>Login/Autorizacion_Condicionado";
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

        var url = "<?php echo site_url(); ?>Login/No_Ingresa_Condicionado";
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
        window.location = "http://ifv.edu.pe/";
    }
    function Enviar_Documento(){
        
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
        var dataString2 = new FormData(document.getElementById('formulario_documento'));
        var url2="<?php echo site_url(); ?>Login/Enviar_Documento";
        if (Valida_Enviar_Documento()) {
            $.ajax({
                type:"POST",
                url: url2,
                data:dataString2,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        '¡Documento enviado con éxito!',
                        'Te hemos enviado un comprobante a tu correo.',
                        'success'
                    ).then(function() {
                        window.location.reload();
                    });
                }
            }); 
        }  
    }

    function Valida_Enviar_Documento() {
        if($('#Codigo').val().trim() === '') {
            Swal(
                'Ups!',
                'Primero tienes que ingresar DNI de un alumno matriculado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_documento').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar documento a enviar.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#documento').val() === '') {
            Swal(
                'Ups!',
                'Debe adjuntar Documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        var archivoInput = document.getElementById('documento');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf)$/i;
        if(!extPermitidas.exec(archivoRuta)){
                Swal(
                    '!Archivo no permitido!',
                    'El archivo debe ser PDF',
                    'error'
                ).then(function() { });
            archivoInput.value = '';
            return false;
        }
        return true;
    } 
    function TipoDoc_Enviar(){
        $('#cod_documento').val($('#cod_documento1').val());
    }
    function Cancelar_Enviar(){
        window.location.reload();
    }
</script>

<script>
	function abrirmodal(){
 
        $("#modal_ver").modal("show");
	}
    function abrirmodal2(){
        var url = "<?php echo site_url(); ?>Login/Lista_Historico";
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
<script src="<?php echo base_url(); ?>template/plugins/blockui/jquery.blockUI.min.js"></script>
<script src="<?php echo base_url(); ?>template/plugins/blockui/custom-blockui.js"></script>