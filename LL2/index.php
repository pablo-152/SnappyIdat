<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?> 

<?php
    $query_d=mysqli_query($con, "SELECT * FROM producto_interes WHERE id_empresa=2 AND id_sede=2 AND estado=2 AND formulario=1 ORDER BY orden_producto_interes ASC");
    $row_d=mysqli_fetch_array($query_d);
    $totalRows_d = mysqli_num_rows($query_d);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <div class="icono2">
            <img src="img/Logo-BL_Mesa-de-trabajo-1.png">
        </div>

        <div class="contenedor-central">
            <div class="icono">
                <img src="img/UnFuturoDeCambio_Mesa de trabajo 1.png">
            </div>
            <div class="img-prin">
                <img src="img/vasco.png" id="img-re">
            </div>
        </div>

        <div class="contenedor-secundario">
            <form id="formulario_cargo" method="POST" enctype="multipart/form-data"  class="">
                <div class="div1">
                    <div class="respon-1">
                        <label class="color-sub colortitu1"><!--Charla Informativa--></label>
                    </div>
				<!--
                    <div class="respon-4">
                        <svg version="1.1" id="Capa_1" class="nuevoo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill-rule:evenodd;clip-rule:evenodd;fill:#36b4e5;}
                        </style>
                        <path class="st0" d="M33.63,31.29c-1.29,0-2.34-1.05-2.34-2.34v-2.34h-9.35v9.35h56.12v-9.35h-9.35v2.34c0,1.29-1.05,2.34-2.34,2.34
                            h-4.68c-1.29,0-2.34-1.05-2.34-2.34v-2.34H40.65v2.34c0,1.29-1.05,2.34-2.34,2.34H33.63z M59.35,17.26H40.65v-2.34
                            c0-1.29-1.05-2.34-2.34-2.34h-4.68c-1.29,0-2.34,1.05-2.34,2.34v2.34H14.92c-1.29,0-2.34,1.05-2.34,2.34v65.48
                            c0,1.29,1.05,2.34,2.34,2.34h70.15c1.29,0,2.34-1.05,2.34-2.34V19.6c0-1.29-1.05-2.34-2.34-2.34H68.71v-2.34
                            c0-1.29-1.05-2.34-2.34-2.34h-4.68c-1.29,0-2.34,1.05-2.34,2.34L59.35,17.26z M21.94,45.32v32.74h56.12V45.32H21.94z"/>
                        </svg>
                        <label class="color-sub colortitu2">18 <label class="mes">Noviembre</label> <label class="hr"></label> </label>
                    </div>
				-->
                    <div class="respon-9">
                        <label class="color-sub-2">Déjanos tus datos y nos contactaremos contigo.</label>
                    </div>
                    <div class="respon-2">
                        <input type="text" class="corre_re no_paste" id="nombres" name="nombres" placeholder="Nombres:" onkeypress="return solo_letras(event);">
                    </div>
                    <div class="respon-3">
                        <input type="text" class="corre_re no_paste" id="apellidos" name="apellidos" placeholder="Apellidos:" onkeypress="return solo_letras(event);">
                    </div>
                </div>

                <div class="div2">

                    <div class="titu2">
                        <input type="text" class="corre_re no_paste" id="tel" name="tel" placeholder="Numero de Celular:" maxlength="9" onkeypress="return numeros(event)">
                    </div>

                    <div class="titu3">
                        <input type="text" class="corre_re no_paste" id="mail" name="mail" placeholder="Correo Electronico:"  onkeypress="return solo_correos(event);">
                    </div>
                </div>

                <div class="div3">
                    <div class="respon-5">
                        <select id="grado" name="grado">
                            <option value="0">Seleccione</option>
                            <?php if($totalRows_d>0){ do{ ?>
                                <option value="<?php echo $row_d['id_producto_interes']?>"><?php echo utf8_encode($row_d['nom_producto_interes']); ?></option>
                            <?php } while ($row_d = mysqli_fetch_array($query_d)); } ?>
                        </select>
                    </div>
                </div>


                <div class="div4">
                    <div class="titu6" >
                        <input type="checkbox" id="checkbox1" name="checkbox1" value="1"><label class="label1" for="checkbox1"><div id="tick_mark"></div></label>
                    </div>
                    <div class="titu7"> 
                        <label>Acepto las <a class="labelform" style="cursor:pointer;color:blue;" href="Politica_Privacidad.pdf" target="_blank">Políticas de Privacidad.</a></label>
                    </div>
                    <div class="titu9" >
                        <input type="checkbox" id="checkbox2" name="checkbox2" value="0"><label class="label1" for="checkbox2"><div id="tick_mark"></div></label>
                    </div>
                    <div class="titu10"> 
                        <label>Acepto recibir información útil sobre eventos y programas de Global Leadership Group para finalidades adicionales. Puedo darme de baja en cualquier momento.</label>
                    </div>
                    <div class="titu8"> 
                        <button type="button" class="btn2 button" id="button"  onclick="Insert_Inscripcion()" data-loading-text="Loading..." autocomplete="off">
                            Enviar
                        </button> 
                    </div>
                </div>
            </form>

            <div class="img-borde-inf">
                <img src="img/cuadros abajo-01.png" id="img-bo2">
            </div>
        </div>
    </div>
</body>

<script>
    // Obtén todos los elementos de entrada con la clase 'noPasteInput'
    const noPasteInputs = document.querySelectorAll('.no_paste');

    // Agrega un evento para prevenir el pegado en cada elemento
    noPasteInputs.forEach(function(inputElement) {
        inputElement.addEventListener('paste', function (e) {
            e.preventDefault();
        });
    });

    function Insert_Inscripcion(){
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

        var url="validar.php";
        var nombres=$("#nombres").val();
        var apellidos=$("#apellidos").val();
        var mail=$("#mail").val();
        var tel=$("#tel").val();
        var grado=$("#grado").val();
        var checkbox2=$("#checkbox2").val();

        if($("#checkbox2").is(":checked")){
            checkbox2=1;
        }

        if (Valida_Inscripcion()) {
            $.ajax({
                type:"POST",
                url:url,
                data:{'nombres':nombres,'apellidos':apellidos,'mail':mail,'tel':tel,'grado':grado,'checkbox2':checkbox2},
                success:function (data) {
                    var val=data.trim();
                    if(val=="validez"){
                        Swal({
                            title: 'Envío Denegado!',
                            text: "Evento Inactivo!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        if(val=="error"){
                            Swal({
                                title: 'Envío Denegado!',
                                text: "Ya te has registrado anteriormente!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else{
                            swal.fire(
                                'Envío Exitoso!',
                                'Haga clic en el botón!',
                                'success'
                            ).then(function() {
                                window.location.reload();
                            });
                        }
                    }
                }
            });
        }
    }

    function Valida_Inscripcion() {
        emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

        if($('#nombres').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#apellidos').val().trim() === ''){
            Swal(
                'Ups!',
                'Debe ingresar Apellidos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mail').val().trim() === '' && $('#tel').val().trim() === ''){
            Swal(
                'Ups!',
                'Debe ingresar Correo electrónico o Teléfono.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mail').val()!=''){
            if(!emailRegex.test($('#mail').val())) {
                Swal(
                    'Ups!',
                    'Correo electrónico inválido.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#tel').val()!=''){
            var celu = $('#tel').val();
            var num = celu.split('');

            if(celu.length!=9) {
                Swal(
                    'Ups!',
                    'Teléfono debe tener 9 dígitos.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if(num[0]!=9) {
                Swal(
                    'Ups!',
                    'Teléfono debe iniciar con 9.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if ($('#grado').val() === '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }
        var condiciones = $("#checkbox1").is(":checked");
        if (condiciones!=true) {
            Swal(
                'Ups!',
                'Debe aceptar Políticas de Privacidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function solo_letras(e) {
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8) return true;
        patron =/[A-Za-z\s]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }
    
    function solo_correos(e) {
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8) return true;
        patron = /^[a-zA-Z0-9@.]*$/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }

    function numeros(e){
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = "0123456789";
        especiales = [8,37,39,46];
        tecla_especial = false

        for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            } 
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial)
            return false;
    }
</script>
