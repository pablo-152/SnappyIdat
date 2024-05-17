<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $query_c=mysqli_query($con, "SELECT * FROM conversatorio WHERE estado=1");
    /*$row_c=mysqli_fetch_array($query_c);
    $totalRows_c = mysqli_num_rows($query_c);*/

    $query_d=mysqli_query($con, "SELECT * FROM departamento");
    /*$row_d=mysqli_fetch_array($query_d);
    $totalRows_d = mysqli_num_rows($query_d);*/
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
                <div class="subitemdos-2">
                    <h5 style="display: flex;justify-content: center;align-items: center;"><label class="linea1">&nbsp;Conversatorios&nbsp;</label></h5>
                    <h1 class="linea2">Transformadores</h1>
                    <h1 class="linea3">para la vida</h1>
                    <h6><label class="linea4">Inicio:</label><label class="linea5"> 10 de agosto</label></h6>
                </div>
            </div>
        </div>
       
        <div class="item-2">
            <form class="subitemdos-1 form">
                <div class="subitemdos-2">
                    <h5>Formulario de inscripción</h5>
                </div>

                <div class="inputBox">
                    <input type="text" class="input-form" name="nombres" id="nombres" value="" placeholder="" required="required">
                    <span>Nombres</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBox">
                    <input type="text" class="input-form" name="apellidos" id="apellidos" value="" placeholder="" required="required">
                    <span>Apellidos</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBox ">
                    <input type="text" class="input-form" name="tel" id="tel" value="" placeholder="" maxlength="9" required="required">
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
                    <select id="id_departamento" name="id_departamento" class="input-form" onchange="Departamento();">
                        <option value="0">Seleccione</option>
                        <?php if($totalRows_d>0){ do{ ?>
                            <option value="<?php echo $row_d['id_departamento']?>"><?php echo utf8_encode($row_d['nombre_departamento']); ?></option>
                        <?php } while ($row_d = mysqli_fetch_array($query_d)); } ?>
                    </select>
                    <span>Departamento</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div id="div_provincia" class="inputBox">
                    <select id="id_provincia" name="id_provincia" class="input-form">
                        <option value="0">Seleccione</option>
                    </select>
                    <span>Provincia</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>
             
                <div class="inputBox" >
                    <!--
                        <input list="grados" class="input-form" name="grado_edu" id="grado_edu" value="" placeholder="" required="required">
                        <datalist id="grados">
                            <option data-value="1" value="1º grado"></option>
                            <option data-value="2" value="2º grado"></option>
                            <option data-value="3" value="3º grado"></option>
                            <option data-value="4" value="4º grado"></option>
                            <option data-value="5" value="5º grado"></option>
                        </datalist>

                        <span>Elige tu conversatorio</span>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error Msg</small>
                    -->
                    <select id="id_conversatorio" name="id_conversatorio" class="input-form">
                        <option value="0">Seleccione</option>
                        <?php if($totalRows_c>0){ do{ ?>
                            <option value="<?php echo $row_c['id_conversatorio']?>"><?php echo utf8_encode($row_c['nom_conversatorio']); ?></option>
                        <?php } while ($row_c = mysqli_fetch_array($query_c)); } ?>
                    </select>
                    <span>Elige tu conversatorio</span>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Msg</small>
                </div>

                <div class="inputBoxdos cuadroinpu5">
                    <input type="button" value="Enviar" onclick="Insert_Inscripcion();">
                </div>
            </form>
        </div>
    </section>

    <script>
  

                // validar logeo
        const form = document.getElementById('form');
        const nombres = document.getElementById('nombres');
        const apellidos = document.getElementById('apellidos');
        const tipo = document.getElementById('tipo');
        const numero_dni = document.getElementById('numero_dni');
        const mail = document.getElementById('mail');
        const tel = document.getElementById('tel');
        const grado = document.getElementById('grado_edu');

        form.addEventListener('submit',(event)=>{
            event.preventDefault();
            validate();
        })

        const sendData = (nombresVal, sRate, count) =>{
            if(sRate === count){                    
                    let timerInterval
                    Swal.fire({
                    title: 'Bien hecho! '+nombresVal,
                    icon: 'success',
                    html: 'Te has registrado <b></b>',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                            b.textContent = Swal.getTimerLeft()
                            }
                        }
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                    }).then((result) => {
                    //location.href = `intranetusu/index.html`
                   
                    $(document).ready(function() {

                    var valueuno = $('#tipo').val();
                    console.log(valueuno);
                    alert($('#tiposdoc [value="' + valueuno + '"]').data('value'));
                    
                    var valuedos= $('#grado_edu').val();
                    console.log(valuedos);
                    alert($('#grados [value="' + valuedos + '"]').data('value'));

                    });
               

                    })
            }
        }


        const successMsg = (nombresVal) => {
            let formCon = document.getElementsByClassName('inputBox');
            var count = formCon.length - 1;
            for( var i = 0; i < formCon.length; i++){
                if(formCon[i].className === "inputBox success"){
                    var sRate = 0 + i;
                    //console.log(sRate);
                    sendData(nombresVal, sRate, count);
                }else{
                    return false;
                }
            }
        }
        const validate = () => {
                const nombresVal = nombres.value.trim();
                const apellidosVal = apellidos.value.trim();
                const tipoVal = tipo.value.trim();
                const numero_dniVal = numero_dni.value.trim();
                const mailVal = mail.value.trim();
                const telVal = tel.value.trim();
                const gradoVal = grado.value.trim();


                if(nombresVal === ""){
                    setErrorMsg(nombres, 'Campo en blanco');
                } else if (nombresVal.length < 3) {
                    setErrorMsg(nombres, '3 caracteres como minimo');
                } else {
                    setSuccessMsg(nombres);
                }

                if(apellidosVal === ""){
                    setErrorMsg(apellidos, 'Campo en blanco');
                } else if (apellidosVal.length < 3) {
                    setErrorMsg(apellidos, '3 caracteres como minimo');
                } else {
                    setSuccessMsg(apellidos);
                }

                if(tipoVal == 0){
                    setErrorMsg(tipo, 'Seleccione un tipo de documento');
                } else {
                    setSuccessMsg(tipo);
                }
            
                if(numero_dniVal === ""){
                    setErrorMsg(numero_dni, 'Campo en blanco');
                } else if (numero_dniVal.length == 3) {
                    setErrorMsg(numero_dni, 'El dni tiene 8 caracteres');
                } else {
                    setSuccessMsg(numero_dni);
                }

            
                if(numero_dniVal === ""){
                    setErrorMsg(numero_dni, 'Campo en blanco');
                } else if (numero_dniVal.length == 3) {
                    setErrorMsg(numero_dni, 'El dni tiene 8 caracteres');
                } else {
                    setSuccessMsg(numero_dni);
                }

                var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if(mailVal !== '') {
                        if(pattern.test(mailVal)) {
                            setSuccessMsg(mail);
                        }
                        else {
                            setErrorMsg(mail, 'Correo Incorrecto');
                        }  
                    }else{
                    setErrorMsg(mail, 'Campo en blanco');
                }

                if(telVal === ""){
                    setErrorMsg(tel, 'Campo en blanco');
                } else if (telVal.length < 10) {
                    setErrorMsg(tel, '9 números como minimo');
                } else {
                    setSuccessMsg(tel);
                }

                if(gradoVal == 0){
                    setErrorMsg(grado, 'Campo en blanco');
                } else {
                    setSuccessMsg(grado);
                }


                successMsg(nombresVal);
        }
        function setErrorMsg(input, errormsgs){
            const formControl =input.parentElement;
            const small = formControl.querySelector('small');
            formControl.className = "inputBox error"; 
            small.innerText =errormsgs;
        }
        function setSuccessMsg(input){
            const formControl =input.parentElement;
            formControl.className = "inputBox success"; 
        }

        function setErrorMsga(input, errormsgs){
            const formControl =input.parentElement;
            const small = formControl.querySelector('small');
            formControl.className = "inputBox cuadroinpu4 error"; 
            small.innerText =errormsgs;
        }
        function setSuccessMsga(input){
            const formControl =input.parentElement;
            formControl.className = "inputBox cuadroinpu4 success"; 
        }

        
    </script>
</body>
</html>

<script>
    function Departamento(){
        var id_departamento=$("#id_departamento").val();
        var url="provincia.php";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_departamento':id_departamento},
            success:function (data) {
                $('#div_provincia').html(data);
            }
        });
    }

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

        var url="enviar.php";

        var nombres=$("#nombres").val();
        var apellidos=$("#apellidos").val();
        var tel=$("#tel").val();
        var mail=$("#mail").val();
        var id_departamento=$("#id_departamento").val();
        var id_provincia=$("#id_provincia").val();
        var id_conversatorio=$("#id_conversatorio").val();

        if (Valida_Inscripcion()) {
            $.ajax({
                type:"POST",
                url:url,
                data:{'nombres':nombres,'apellidos':apellidos,'mail':mail,'tel':tel,
                    'id_departamento':id_departamento,'id_provincia':id_provincia,
                    'id_conversatorio':id_conversatorio},
                success:function (data) {
                    var val=data.trim();
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
                            window.location = "https://snappy.org.pe/LD1/";
                        });
                    }
                }
            });
        }
    }

    function Valida_Inscripcion() {
        emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

        var celu = $('#tel').val();
        var num = celu.split('');

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

        if ($('#tel').val().trim() === ''){
            Swal(
                'Ups!',
                'Debe ingresar Teléfono.',
                'warning'
            ).then(function() { });
            return false;
        }

        var celu = $('#tel').val();
        var num = celu.split('');

        if(num[0]!=9) {
            Swal(
                'Ups!',
                'Formato de Telefono Inválido.',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#mail').val().trim() === ''){
            Swal(
                'Ups!',
                'Debe ingresar Correo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if(!emailRegex.test($('#mail').val())) {
            Swal(
                'Ups!',
                'Formato de Correo Inválido.',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_departamento').val() === '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Departamento.',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_provincia').val() === '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Provincia.',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_conversatorio').val() === '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Conversatorio.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    $('#nombres').bind('keypress', function(event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $('#apellidos').bind('keypress', function(event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
  
    $('#mail').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9a-zA-ZáéíñóúüÁÉÍÑÓÚÜ_@.-]/g, '');
    });

    $('#tel').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script> 