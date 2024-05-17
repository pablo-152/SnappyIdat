<?php 
$session =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('1headerpreguntas'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Examen de Admisión</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="template/corck/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="template/corck/assets/css/pluginspregunta.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="template/corck/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        .contenedor {
            color: #ffffff;
            text-align: center;
        }
        .cartel {
            width: 57px;
            height: 80px;
            padding: 10px 0px 5px 0px;
            text-align: center;
            display: inline-block;
            margin: 0px;
            border: 0px solid #ffffff;
            border-radius: 5px;
        }
        .cartel>div{
            font-size: 36px;
            font-family: 'Chela One', sans serif;
            animation: fade 3s;
            line-height: 30px;
            margin-top: 0px;
        }
        .cartel>div>h3 {
            margin-top: 0px;
            font-size: 12px;
            font-weight: normal;
        }
        .h3 {
            bottom: 0;
            margin: 0 auto ;
        }
        .contenedor {
            margin-top: 10%;
        }
        .contenido {
            width: 80%;
            margin: 0 auto;
            border: 0px solid #ffffff;
            z-index: 10;
        }
        li {
            display: inline-block;
            font-size: 1.5em;
            list-style-type: none;
            padding: 1em;
            text-transform: uppercase;
        }
        li span {
            display: block;
            font-size: 4.5rem;
        }
        .numeros {
            font-family: 'Chela one', sans-serif;
            font-size: 60px;
            transition: .3s;
            animation-name: fade;
            animation-duration: 3s;
        }
        .responsivo1 {
            display: inline-block
        }
        .responsivo2 {
            display: inline-block
        }
        @media (max-width: 450px) {  
            .contenedor {
                margin-top: 0%;
            }
            .banner {
            margin-bottom: 30px; 
            }
            .cartel {
                height: 60px;
                width: 60px;
            }
            .cartel>div{
                font-size: 35px;
            }
            .cartel>div>h3 {
                font-size: 9px;
                margin-top: 0px;
            }
        }
        @keyframes fade {
            0%   {
                opacity: 0;
            }
                30%   {
                opacity: 0;
            }  
                100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">
    
    <div class="header-container fixed-top">
        <header  class="header navbar navbar-expand-sm" id="headeer">
            <ul class="navbar-item flex-row" >
                <li class="nav-item align-self-center page-heading " >
                    <div class="page-header" >
                        <div class="page-title" ><br>
                            <h3 style="color:#757474"><?php echo $get_examen[0]['nom_examen'] ?></b></h3>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">
                
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="template/img/logo2.png" width="55" height="55" alt="">
                        <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>-->
                    </a>
                </li>

            </ul>

        </header>

        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item ">
                <li class="nav-item  notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="template/img/mate.png" width="50" height="50" alt="">
                    </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row" >
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header" >
                        
                        <div class="page-title" id="nom_area">
                            <!--<h6>RAZONAMIENTO <b>MATEMÁTICO</b></h6>-->
                            
                            <div class="contenedor"> 
                                <div class="contador">
                                    <!--<div class="responsivo1">
                                        <label style="color:#ffffff">Tiempo Restante:</label>
                                    </div>-->
                                    <div class="responsivo1">
                                        <div class="cartel">
                                            <div id="horas"></div>
                                            <div class="h3"><h3 style="color:#ffffff">Horas</h3></div>
                                        </div>
                                    </div>
                                    <div class="responsivo2">
                                        <div class="cartel">
                                            <div id="minutos"></div>
                                            <div class="h3"><h3 style="color:#ffffff">Minutos</h3></div>
                                        </div>
                                        <div class="cartel">
                                            <div id="segundos"></div>
                                            <div class="h3"><h3 style="color:#ffffff">Segundos</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            
            <!--<input type="hidden" class="col-sm-5" id="timerr" name="timerr"  value="<?php echo $timer ?>">
            <input type="hidden" class="col-sm-5" id="timermodal" name="timermodal"  value="<?php echo $timer-600000 ?>">
            <input type="hidden" class="col-sm-5" id="timer120" name="tiempo_limite"  value="<?php echo $timer120-600000 ?>">
            <input type="hidden" class="col-sm-5" id="timer120final" name="timer120final"  value="<?php echo $timer120 ?>">-->
            
        </header>
        
    </div><br><br><br><br>
    
       
    <form  method="post" id="formulario" enctype="multipart/form-data" action="<?= site_url('Examen/Resultado')?>" class="formulario">
        <div class="main-container" id="container">
                <input type="hidden" name="id_postulante" id="id_postulante" value= '<?php echo $id_postulante ?>'>
                <input type="hidden" name="id_examen" id="id_examen" value= '<?php echo $id_examen ?>'>
                
                <div id="content" class="main-content">
                    <div class="container">
                        <div class="container">
                        <?php $contador=1;$n=0;
                            while($contador<=10){?>
                                    <div class="row">
                                        <div id="pregunta<?php echo $contador ?>" class="col-lg-12 layout-spacing">
                                            <div class="statbox widget box box-shadow">
                                                <div class="widget-header" style="background-color:#ee9a2d">                                
                                                    <div class="row" >
                                                        <div  class="col-xl-12 col-md-12 col-sm-12" >
                                                            <h4 style="color:white" >Responda a la siguiente pregunta:</h4>
                                                        </div>                                                                        
                                                    </div>
                                                </div>
                                                <div class="widget-content widget-content-area">
                                                    <fieldset class="form-group mb-4">
                                                        <div class="row" >
                                                            <div class="col-xl-10 col-md-10 col-sm-10" >
                                                                <div class="form-check">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-15" align="left">
                                                                                <h6 style="color:black" ><?php echo $contador.". ".$list_pregunta[$n]['pregunta']; ?>&nbsp;&nbsp;<?php if($list_pregunta[$n]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="javascript:void(0);" onclick="Img_P<?php echo $contador ?>();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                                        
                                                    
                                                            <div class="col-xl-10 col-lg-9 col-sm-10">
                                                                <?php $f=0;foreach ($list_respuesta as $rpta ){$f++; ?>
                                                                    <?php if($list_pregunta[$n]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                                        <div class="form-check">
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div class="col-1" >
                                                                                        <input type="radio"  style="width: 30px;" id="id_respuesta<?php echo $f ?>" name="id_respuesta<?php echo $contador ?>" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                                    </div>
                                                                                    <div class="col-15" align="left">
                                                                                        <label class="form-check-label" for="id_respuesta<?php echo $f ?>" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                            <?php echo $rpta['desc_respuesta'] ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $contador++;$n++;
                            }
                        ?>

                        </div>
                    </div>
                    <div class="col-lg-9" >
                        <div align="center"  >
                            <!--<img src="template/img/1.png" id="por1" alt="">-->
                            <img src="template/img/8.png" id="por1" alt="">
                            
                            <button  type="button" onclick="Siguiente()" class="btn btn-primary mb-2 mr-1" title="Siguiente" >
                                SIGUIENTE
                            </button>
                        </div>
                    </div>
                    <div class="footer-wrapper">
                        <div class="footer-section f-section-1">
                            <p class="">Copyright © 2021 <a target="_blank" href="https://designreset.com">GLLG</a>, Todos los derechos reservados.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php 
            $contador=1;
            $n=0;
            while($contador<=10){?>
            <div class="modal-contenedor<?php if($contador!=1){echo $contador;} ?>">
                <div class="popup<?php if($contador!=1){echo $contador;} ?> modal-cerrar<?php if($contador!=1){echo $contador;} ?>" id="quitaragregarer<?php if($contador!=1){echo $contador;} ?>">       
                    <p class="cerrar<?php if($contador!=1){echo $contador;} ?>"></p>
                        <div class="cuerpo<?php if($contador!=1){echo $contador;} ?>">
                        <img  src="<?php echo $get_link[0]['url_config'].$list_pregunta[$n]['img']; ?>" width="220" height="350"/>
                        </div>
                </div>
            </div>
            <script>
                $('.cerrar<?php if($contador!=1){echo $contador;} ?>,.modal-contenedor<?php if($contador!=1){echo $contador;} ?>').click(function(){
                    document.getElementById("quitaragregarer<?php if($contador!=1){echo $contador;} ?>").classList.add("modal-cerrar<?php if($contador!=1){echo $contador;} ?>");
                    setTimeout(function(){
                        $(".modal-contenedor<?php if($contador!=1){echo $contador;} ?>").css("opacity", "0");
                        $(".modal-contenedor<?php if($contador!=1){echo $contador;} ?>").css("visibility", "hidden");
                    },850)
                });

                function Img_P<?php echo $contador; ?>(){
                    $(".modal-contenedor<?php if($contador!=1){echo $contador;} ?>").show();
                    $(".modal-contenedor<?php if($contador!=1){echo $contador;} ?>").css("opacity", "1");
                    $(".modal-contenedor<?php if($contador!=1){echo $contador;} ?>").css("visibility", "visible");
                    document.getElementById("quitaragregarer<?php if($contador!=1){echo $contador;} ?>").classList.remove("modal-cerrar<?php if($contador!=1){echo $contador;} ?>");                  
                }
            </script>
            <?php $contador++;$n++;}
        ?>
    </form>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="template/corck/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="template/corck/bootstrap/js/popper.min.js"></script>
    <script src="template/corck/bootstrap/js/bootstrap.min.js"></script>
    <script src="template/corck/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="template/corck/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="template/corck/plugins/highlight/highlight.pack.js"></script>
    <script src="template/corck/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="template/corck/assets/js/scrollspyNav.js"></script>
</body>
</html>

<script type="text/javascript">
	function Siguiente(){
        if (Valida_Preguntas()) {
            $('#formulario').submit();
        }
    }
    function Valida_Preguntas(){
        <?php 
            $contador=1;
            $n=0;
            while($contador<=10){?>
            if (!$("input[name=id_respuesta<?php echo $contador; ?>]").is(":checked")) {
                $(".modal-contenedor11").show();
                $(".modal-contenedor11").css("opacity", "1");
                $(".modal-contenedor11").css("visibility", "visible");
                document.getElementById("quitaragregarer11").classList.remove("modal-cerrar11");  
                document.getElementById("pregunta").innerHTML = "<?php echo $contador; ?>";
                return false;
            }
            <?php $contador++;$n++;}
        ?>
        return true;
    }
    
    /*var base_url = '<?php echo site_url(); ?>';
    timer='<?php echo $timer; ?>';//$('#timerr').val();
    timer2='<?php echo $timer-600000; ?>';//$('#timermodal').val();
    timer120='<?php echo $timer120-600000; ?>';//$('#timer120').val();
    timer120final='<?php echo $timer120 ?>';//$('#timer120final').val();
    $(document).ready(function() {
        clearTimeout(timeout);
    } );
    
    setTimeout(update, timer120final);
    setTimeout(update, timer);

    setTimeout(modal_tiempo, timer2);
    setTimeout(modal_tiempo, timer120);
    
    function update() {
        var dataString = 1;
        id_postulante=$('#id_postulante').val();
        id_examen=$('#id_examen').val();
        var url="<?php echo site_url(); ?>Examen/Tiempo_limite";
        $.ajax({
            type:"POST",
            url: url,
            data: {'id_postulante':id_postulante,'id_examen':id_examen},
            
            success:function (data) {
                $(".modal-contenedor14").show();
                $(".modal-contenedor14").css("opacity", "1");
                $(".modal-contenedor14").css("visibility", "visible");
                document.getElementById("quitaragregarer14").classList.remove("modal-cerrar14");
                SinTiempo();
                
            }
        });
        
    }

    function modal_tiempo() {
        if(timer120<0 || timer2<0){

        }else{
            $(".modal-contenedor13").show();
            $(".modal-contenedor13").css("opacity", "1");
            $(".modal-contenedor13").css("visibility", "visible");
            document.getElementById("quitaragregarer13").classList.remove("modal-cerrar13");  
            
        }
    }*/

    

    function salir() {
        window.location.href = "http://www.ifv.edu.pe/"; //esta función te saca
    }

    const second = 1000,
    minute = second * 60,
    hour = minute * 60,
    day = hour * 24;

    //let countDown = new Date('Jun 14, 2023 16:38:00').getTime(),
    let countDown = new Date('<?php echo date("M d, Y")." ".date("H:i:s", strtotime($get_tiempo[0]['hora_final'])) ?>').getTime(),
    x = setInterval(function() {

        let now = new Date().getTime(),distance = countDown - now;

        if(Math.floor((distance % (day)) / (hour))<0 || Math.floor((distance % (day)) / (hour))<0 || Math.floor((distance % (minute)) / second)<0){
            document.getElementById('horas').innerText = 0,
            document.getElementById('minutos').innerText = 0,
            document.getElementById('segundos').innerText = 0;
        }else{
            document.getElementById('horas').innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById('minutos').innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById('segundos').innerText = Math.floor((distance % (minute)) / second);  
        }

        /*if(Math.floor((distance % (hour)) / (minute))===10 && Math.floor((distance % (minute)) / second)===0){
            $(".modal-contenedor13").show();
            $(".modal-contenedor13").css("opacity", "1");
            $(".modal-contenedor13").css("visibility", "visible");
            document.getElementById("quitaragregarer13").classList.remove("modal-cerrar13"); 
        }*/

        if (Math.floor((distance % (day)) / (hour)) <= 0 && Math.floor((distance % (hour)) / (minute))<=0 && Math.floor((distance % (minute)) / second)<=0) {
            clearInterval(x);
            SinTiempo();
            //window.location = "<?php echo site_url(); ?>Examen/Tiempo_limite_2/"+<?php echo $id_postulante ?>+"/"+<?php echo $id_examen ?>;
        }

    }, second)

    function SinTiempo() {
        var dataString = new FormData(document.getElementById('formulario'));
        var url = "<?php echo site_url(); ?>Examen/Tiempo_limite_2";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                window.location = "<?php echo site_url(); ?>Examen/Tiempo_Agotado";
            }
        });
    }
        
</script>
<?php $this->load->view('3footerpreg'); ?>