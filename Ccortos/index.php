<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>
<!-- 
<?php
    $query_d = mysqli_query($con, "SELECT * FROM producto_interes 
                WHERE id_empresa=11 AND id_sede=27 AND formulario=1
                ORDER BY orden_producto_interes ASC");
    $row_d = mysqli_fetch_array($query_d);
    $totalRows_d = mysqli_num_rows($query_d);
?>
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />
        <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style2.css">
        <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
        <script src="jquery-3.2.1.min.js"></script>
        <script src="sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="blockui/jquery.blockUI.min.js"></script>
        <script src="blockui/custom-blockui.js"></script>
    </head>
    <body>
        <div class="grid-1">
            <div class="item-1">
                <div class="subitem-1">
                    <div class="subitemdos-2">
                    </div>
                </div>
            </div>
       
            <div class="item-2">
                <form class="subitemdos-1 form">
                    <div class="subitemdos-2">
                        <h5>Formulario de Inscripci&oacute;n</h5>
				<!--<div class="respon-4">
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
<div class="respon-9">
                        <label class="color-sub-2">Déjanos tus datos y nos contactaremos contigo</label>
                    </div>-->
                    </div>

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

                    <div class="inputBox ">
                        <input type="text" class="input-form" name="tel" id="tel" value="" placeholder="" maxlength="9" required="required" onkeypress="return numeros(event)">
                        <span>Número celular</span>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error Msg</small>
                    </div>

                    <div class="inputBox">
                        <input type="text" class="input-form" name="mail" id="mail" value="" placeholder="" required="required">
                        <span>Correo electrónico</span>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error Msg</small>
                    </div>

                    
                
                    <div class="inputBox" >
                        <select id="grado" name="grado" class="input-form">
                            <option value="0">Cursos de interes</option>
                            <?php if($totalRows_d>0){ do{ ?>
                                <option value="<?php echo $row_d['id_producto_interes']?>"><?php echo utf8_encode($row_d['nom_producto_interes']); ?></option>
                            <?php } while ($row_d = mysqli_fetch_array($query_d)); } ?>
                        </select>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error Msg</small>
                    </div>

                    <div class="inputBoxdos cuadroinpu5">
                        <input type="button" value="Enviar" onclick="Insert_Inscripcion();">
                    </div>
                </form>
            </div>
        
        </div>
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

        if (Valida_Inscripcion()) {
            $.ajax({
                type:"POST",
                url:url,
                data:{'nombres':nombres,'apellidos':apellidos,'mail':mail,'tel':tel,'grado':grado},
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
                'Debe seleccionar Tema.',
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

    $("#tel").keyup(function(){               
        var ta      =   $("#tel");
        letras      =   ta.val().replace(/ /g, "");
        ta.val(letras)
        this.value = this.value.replace(/[^0-9]/g,'');
    }); 
</script> 