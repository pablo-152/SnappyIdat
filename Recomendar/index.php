<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomendar</title>
    <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
    <script src="jquery-3.2.1.min.js"></script>
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="blockui/jquery.blockUI.min.js"></script>
    <script src="blockui/custom-blockui.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-botones.css">
</head>
<body>
    <div class="contenedor-general">
        <div class="contenedor-central">
            <div class="icono">
                <img src="img/logo-ifv-01.png">
            </div>
            
            <div class="img-prin">
                <img src="img/imagen-reco.png" id="img-re">
            </div>
            <div class="img-borde-inf">
                <img src="img/cuadros abajo-01.png" id="img-bo">
            </div>
            <div class="img-borde-sup">
                <img src="img/cuadros arriba.png" id="img-su">
            </div>
        </div>
        <div class="contenedor-secundario">
            <div class="img-secun">
                <img src="img/cuadros arriba.png" id="img-su2">
            </div>
            <div class="img-secun-refe">
                <img src="img/icono referidos-01.png" id="img-ref">
            </div>
            <form id="formulario_cargo" method="POST" enctype="multipart/form-data"  class="">
                <div class="div1">
                    <div class="respon-1">
                        <label class="">Insertar DNI:</label>
                    </div>
                    <div class="respon-2">
                        <input id="otro_1" name="otro_1" type="text" maxlength="8" class="" onkeypress="ValidaSoloNumeros()">
                    </div>
                    <div class="respon-3">
                        <button type="button" class="btn1 button" onclick="Insert_Cargo()">Validar</button>
                    </div>
                </div>
                <div class="div2">
                    <div class="sub-titu">
                        <label class="">Tu Invitado:</label>
                    </div>
                    <div class="titu2">
                        <label class="">DNI:</label>
                    </div>
                    <div class="titu4">
                        <input id="dni_re" name="dni_re" type="text" maxlength="8" class="" onkeypress="ValidaSoloNumeros()">
                    </div>
                    <div class="titu3">
                        <label class="">Celular:</label>
                    </div>
                    <div class="titu5">
                        <input id="celu_re" name="celu_re" type="text" maxlength="9" class="" onkeypress="ValidaSoloNumeros()">
                    </div>
                </div>
                <div class="div3"> 
                    <div class="respon-4">
                        <label class="">Correo Electrónico:</label>
                    </div>
                    <div class="respon-5">
                        <input id="corre_re" name="corre_re" type="text" maxlength="50" class="">
                    </div>
                </div>
                <div class="div4">
                    <div class="titu6" >
                        <input type="checkbox" id="_checkbox"><label class="label1" for="_checkbox"><div id="tick_mark"></div></label>
                    </div>
                    <div class="titu7"> 
                        <label>Acepto <a href="Terminos_Condiciones.pdf" target="_blank" style="color:#0000EE;text-decoration:underline;">Términos y Condiciones</a></label>
                    </div>
                    <div class="titu8"> 
                        <button type="button" class="btn2 button" id="button" disabled onclick="Insert_Cargo1()" data-loading-text="Loading..." autocomplete="off">
                            Guardar
                        </button>
                    </div>
                </div>
                <!--
                <button type="button" class="btn btn-default" onclick="Cancelar()">
                    <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                </button>-->  

                <div class="img-borde-inf">
                    <img src="img/cuadros abajo-01.png" id="img-bo2">
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    function Insert_Cargo(){
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

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="validar.php";

        if (valida_registros_cargo()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    var data=data.trim();
                    if(data=="no-existe"){
                        document.getElementById("button").disabled = true;

                        Swal(
                            'Validación Denegada',
                            'Ese DNI no se encuentra Registrado',
                            'error'
                        ).then(function() { });
                    }else if (data=="existe"){
                        document.getElementById("button").disabled = false;
                        
                        Swal(
                            'Validación Exitosa',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() { });
                    }
                }
            });
        }
    }
                  
    function Cancelar(){
        window.location = "index.php";
    }

    function valida_registros_cargo() {
        if($('#otro_1').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingregar DNI.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#otro_1').val().trim().length!=8) {
            Swal(
                'Ups!',
                'El número de DNI debe contener 8 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function ValidaSoloNumeros() {
        if ((event.keyCode < 48) || (event.keyCode > 57)) 
        event.returnValue = false;
    }

    function Insert_Cargo1(){
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

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="enviar_mensaje.php";

        if (valida_registros_cargo1()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Swal(
                        'Enviado!',
                        'Se le envió una mensaje a tu invitado',
                        'success'
                    ).then(function() {
                        window.location = "index.php";
                    });
                }
            });
        }
    }
                  
    function Cancelar(){
        window.location = "index.php";
    }

    function valida_registros_cargo1() {
        if($('#dni_re').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar DNI del invitado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#dni_re').val().trim().length!=8) {
            Swal(
                'Ups!',
                'El número de DNI del invitado debe contener 8 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celu_re').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Celular del invitado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#corre_re').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Correo Electrónico del invitado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(!$('#_checkbox').is(':checked')) {
            Swal(
                'Ups!',
                'Debe aceptar Condiciones.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
