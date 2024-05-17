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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
    <script src="jquery-3.2.1.min.js"></script>
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="blockui/jquery.blockUI.min.js"></script>
    <script src="blockui/custom-blockui.js"></script>
</head>
<body>
    <section class="grid-1">
        <div class="item-1">
            <div class="subitem-1">

            </div>
            <div class="subitem-2">

            </div>
        </div>
        <div class="item-2">
            <div class="subitemdos-1">
                <h1>Charla Informativa - 18 de Febrero</h1>
            </div>
            <div class="subitemdos-2">
                <h5>Déjanos tus datos y nos contactaremos contigo</h5>
            </div>

            <form class="subitemdos-1 form">
                <div class="inputBox">
                    <input type="text" class="input-form" name="nombres" id="nombres" value="" placeholder="" required="required" onkeypress="return solo_letras(event);">
                    <span>Nombres</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBox">
                    <input type="text" class="input-form" name="apellidos" id="apellidos" value="" placeholder="" required="required" onkeypress="return solo_letras(event);">
                    <span>Apellidos</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <!--<div class="inputBox">
                    <select id="dni" name="dni" class="input-form">
                        <option value="0">Seleccione</option>
                        <option value="1">DNI</option>
                        <option value="2">Pasaporte</option>
                    </select>
                    <span>Tipo documento</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBox">
                    <input type="text" class="input-form" name="numero_dni" id="numero_dni" value="" placeholder="" required="required">
                    <span>N de documento</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>-->

                <div class="inputBox">
                    <input type="text" class="input-form" name="mail" id="mail" value="" placeholder="" required="required">
                    <span>Correo electrónico</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBox ">
                    <input type="text" class="input-form" name="tel" id="tel" value="" placeholder="" maxlength="9" required="required" onkeypress="return numeros(event)">
                    <span>Teléfono</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBox cuadroinpu4">
                    <select id="grado" name="grado" class="input-form">
                        <option value="0">Seleccione</option>
                        <?php if($totalRows_d>0){ do{ ?>
                            <option value="<?php echo $row_d['id_producto_interes']?>"><?php echo utf8_encode($row_d['nom_producto_interes']); ?></option>
                        <?php } while ($row_d = mysqli_fetch_array($query_d)); } ?>
                    </select>
                    <span>Grado</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBoxdos cuadroinpu5">
                    <input type="button" value="Enviar" onclick="Insert_Inscripcion();">
                </div>


            </form>

            <div class="last-item">
                <div>
                    <div class="check_estilos1"> 
                        <div class="centradoinput">
                            <input class="input-checkbox" id="checkbox1" type="checkbox" name="checkbox1" value="1">
                        </div>
                        <div class="centradolabel">
                            <label class="labelform" for="">Acepto las <a class="labelform" style="cursor:pointer;color:blue;" href="Politica_Privacidad.pdf" target="_blank">Políticas de Privacidad.</a></label>
                        </div>
                    </div>
    
                    <div class="check_estilos2">
                        <div class="centradoinput">
                            <input class="input-checkbox" id="checkbox2" type="checkbox" name="checkbox2" value="0">
                        </div>
                        <div class="centradolabel">
                            <label class="labelform" for="">Acepto recibir información útil sobre eventos y programas de Global Leadership Group para finalidades adicionales. Puedo darme de baja en cualquier momento.</label>
                        </div>
                    
                    </div>
                </div>
                <div class="solocelular" >
                    <img class="indexmaximo" src="03.png" alt="" srcset="">
                </div>
		<div class="nuevodiv" >
        		<label class="nuevolabel">info@littleleaders.edu.pe</label>
    		</div>

            </div>

        </div>
    </section>
    
</body>
</html>

<script>
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
                                window.location = "https://snappy.org.pe/LL2/";
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