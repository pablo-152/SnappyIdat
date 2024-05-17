<?php 
$session =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('1headerpreguntas'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Examen de Prácticas</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="template/corck/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="template/corck/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="template/corck/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
</head>
<style>
    .alineacionbtn{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .abtn{
        width: 300px;
        font-size: 24px!important;
        height: 50px;
        font-weight: bold;
    }
</style>
<style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
.contenedor {
  color: #000000;
  text-align: center;
}
.cartel {
  width: 109px;
  height: 109px;
  padding: 10px 0px 5px 0px;
  text-align: center;
  display: inline-block;
  margin: 5px;
  border: 3px solid #000000;
  border-radius: 5px;
}
.cartel>div{
  font-size: 50px;
  font-family: 'Chela One', sans serif;
  animation: fade 3s;
  line-height: 30px;
  margin-top: 5px;
}
.cartel>div>h3 {
  margin-top: 15px;
  font-size: 20px;
  font-weight: normal;
}
.h3 {
  bottom: 0;
  margin: 0 auto ;
}
.contenedor {
  margin-top: 3%;
}
.contenido {
  width: 80%;
  margin: 0 auto;
  border: 0px solid black;
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
    margin-top: 15%;
  }
  .banner {
   margin-bottom: 30px; 
  }
  .cartel {
    height: 99px;
    width: 99px;
  }
  .cartel>div{
    font-size: 45px;
  }
  .cartel>div>h3 {
    font-size: 15px;
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
<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">
    <div class="header-container fixed-top"><br>
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="template/img/logo.png" width="90" height="90" alt="">
                    </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>&nbsp;&nbsp;INSTITUTO FEDERICO VILLARREAL</h3>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
        <header class="navbar0 navbar-expand-sm" id="header0">
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown notification-dropdown">
                </li>
            </ul>
        </header>
    </div><br><br><br>

    <form  method="post" id="formulario" enctype="multipart/form-data" action="<?= site_url('Examen/index1')?>" class="formulario">

        <input type="hidden" name="id_postulante" id="id_postulante" value= '<?php echo $get_id[0]['id_postulante'] ?>'>

        <!--<input type="hidden" name="id_carrera" id="id_carrera" value= '<?php echo $id_carrera ?>'>-->
        <input type="hidden" name="id_examen" id="id_examen" value= '<?php echo $get_examen[0]['id_examen'] ?>'>

    </form>

        <div class="main-container" id="container">
                <div id="content" class="main-content">
                    <div class="container">
                        <div class="container">
                            <h3 class="page-title"><FONT SIZE=5><?php echo $get_examen[0]['nom_examen'] ?></FONT></h3>
                            <h5 class="page-title"><b>Alumno:&nbsp;&nbsp;&nbsp;</b> <?php echo $get_id[0]['apellido_pat']." ".$get_id[0]['apellido_mat'].", ".$get_id[0]['nombres'] ?></h5><br>
                        </div>
                    </div>
                    <div class="col-lg-12 layout-spacing" >
                        <div class="statbox widget box box-shadow" >
                            <div class="widget-content widget-content-area" style="background-color:#c0bdbc">
                                <div id="circle-basic" class="">
                                    <section>
                                        <h2 style="text-align:center">Condiciones e Instrucciones</h2>
                                        <p style="text-align: justify; color:white">
                                            <FONT SIZE=4>
                                            - El examen programado queda activo sólo día y hora establecida, ésta información será indicada por la Coordinación de EFSRT. Duración 30 min.<br>
                                            - Asegúrate que el dispositivo en el cual realices el examen se encuentra cargado y con disponibilidad de internet para evitar que se cuelgue o se pierda la información.<br>
                                            - El puntaje mínimo para calificar es de 10.<br>
                                            -Durante el examen, lea con cuidado cada pregunta. Si lee apresuradamente, puede obviar información y equivocarse.<br>
                                            - El examen consta de 10 preguntas teóricas, una vez iniciado/activado el link sólo puede aplicarse una sola vez, por lo que un segundo intento quedará invalidado.<br>
                                            - Es recomendable marcar cada respuesta, al momento mismo de conocerla.<br><br>

                                            <b>¡¡ EXITOS EN TU EXAMEN!!</b>
                                            </FONT>
                                        </p>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" >
                        <div class="contenedor"> 
                            <div class="contenido">
                                <h4 style="color:black">Tu examen estará disponible en:</h4>  
                                <div class="contador">
                                    <div class="responsivo1">
                                        <!--<div class="cartel">
                                            <div id="dias"></div>
                                            <div class="h3"><h3>Días</h3></div>
                                        </div>-->
                                        <div class="cartel">
                                            <div id="horas"></div>
                                            <div class="h3"><h3 style="color:black">Horas</h3></div>
                                        </div>
                                    </div>
                                    <div class="responsivo2">
                                        <div class="cartel">
                                            <div id="minutos"></div>
                                            <div class="h3"><h3 style="color:black">Minutos</h3></div>
                                        </div>
                                        <div class="cartel">
                                            <div id="segundos"></div>
                                            <div class="h3"><h3 style="color:black">Segundos</h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alineacionbtn"  >
                            <a  type="button" href="https://www.facebook.com/InstitutoFedericoVillarreal"  target="_blank" class="abtn btn  btn-primary5 mb-2 mr-1 " >
                                Dale <b>me  gusta <i><svg style="width: 35px; height: 35px;" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="35" height="35" x="0" y="0" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><g xmlns="http://www.w3.org/2000/svg">	<path style="" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626   v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006   c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154   C167.657,37.881,130.125,0.349,83.829,0.349z" fill="#ffffff" data-original="#010002"/></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g></g></svg></i> </b>
                            </a>
                            <button  type="button" id="btn_asignar" class="abtn btn btn-primary mb-2 mr-1" title="Siguiente" disabled>
                                EMPEZAR 
                            </button>
                        </div>
                    </div>
                    <div class="footer-wrapper">
                        <div class="footer-section f-section-1">
                            <p class="">Copyright © <?php echo date('Y') ?> <a target="_blank" href="https://designreset.com">GLLG</a>, Todos los derechos reservados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal-contenedor12">
        <div class="popup12 modal-cerrar12" id="quitaragregarer12">
            <p class="cerrar12"></p>
            <div class="cuerpo12">
                <div>
                    <h1 style="text-decoration: underline;" ><b>ACUERDATE</b></h1>
                    <h3 class="mensajesubt" style="text-align: justify;">
                        <font size=4>
                        <b>Son 10 preguntas y tienes un tiempo maximo de 30 minutos para terminar</b><br>
                        Si paras a medio ya no puedes volver a hacerlo. Revisa que te encuentras en un local con buena internet. <b>¡Buena Suerte!</b><br>
                        </font>
                    </h3>
                    <a  type="button" id="btn_empezar" class="btn btn-primary5 mb-2 mr-1" title="Iniciar" >
                        INICIAR EXAMEN
                    </a>
                </div>
            </div>
        </div>
    </div>

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
    <script src="template/corck/assets/js/scrollspyNav.js"></script>
</body>
</html>



<script type="text/javascript">
	$('#btn_asignar').on('click', function(e){
            $(".modal-contenedor12").show();
            $(".modal-contenedor12").css("opacity", "1");
            $(".modal-contenedor12").css("visibility", "visible");
            document.getElementById("quitaragregarer12").classList.remove("modal-cerrar12");
    });

    $('#btn_empezar').on('click', function(e){
        $('#formulario').submit();
    });

    $('.cerrar12').click(function(){
        document.getElementById("quitaragregarer12").classList.add("modal-cerrar12");
        setTimeout(function(){
            $(".modal-contenedor12").css("opacity", "0");
            $(".modal-contenedor12").css("visibility", "hidden");
        },850)
    });

    const second = 1000,
    minute = second * 60,
    hour = minute * 60,
    day = hour * 24;

    //let countDown = new Date('Jun 14, 2023 16:38:00').getTime(),
    let countDown = new Date('<?php echo date("M d, Y")." ".$get_tiempo[0]['hora_inicio'] ?>').getTime(),
    x = setInterval(function() {

        let now = new Date().getTime(),distance = countDown - now;

        //document.getElementById('dias').innerText = Math.floor(distance / (day)),
        if(Math.floor((distance % (day)) / (hour))<0 || Math.floor((distance % (day)) / (hour))<0 || Math.floor((distance % (minute)) / second)<0){
            document.getElementById('horas').innerText = 0,
            document.getElementById('minutos').innerText = 0,
            document.getElementById('segundos').innerText = 0;
        }else{
            document.getElementById('horas').innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById('minutos').innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById('segundos').innerText = Math.floor((distance % (minute)) / second);  
        }
        
        

        if (Math.floor((distance % (day)) / (hour)) <= 0 && Math.floor((distance % (hour)) / (minute))<=0 && Math.floor((distance % (minute)) / second)<=0) {
            clearInterval(x); // Detiene el intervalo cuando llega a cero
            //alert("¡Hola!"); // Muestra el mensaje de alerta
            var boton = document.getElementById("btn_asignar");
            boton.disabled = false;
        }

    }, second)
</script>

<?php $this->load->view('3footerpreg'); ?>