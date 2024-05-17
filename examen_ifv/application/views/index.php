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

    <link href="template/corck/assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->

    <link href="template/corck/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />

</head>

<style>

.alineacionbtn{

			display: flex;

			flex-direction: row;

			justify-content: space-between;

			/*margin-left: 30px;

    		margin-right: 30px;*/

			

		}

		.abtn{

			width: 300px;

			font-size: 24px!important;

			height: 50px;

			font-weight: bold;

		}

</style>

<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">

    

    <div class="header-container fixed-top"><br>

        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item flex-row navbar-dropdown">

                

                <li class="nav-item dropdown notification-dropdown">

                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <img src="template/img/logo.png" width="90" height="90" alt="">

                        <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>-->

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

                            <h3></h3>

                            <!--<h6>RAZONAMIENTO <b>MATEMÁTICO</b></h6>-->

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

    

       

    <form  method="post" id="formulario" enctype="multipart/form-data" action="<?= site_url('Examendeadmision/index1')?>" class="formulario">

        <input type="hidden" name="id_postulante" id="id_postulante" value= '<?php echo $id_postulante ?>'>

        <input type="hidden" name="id_carrera" id="id_carrera" value= '<?php echo $id_carrera ?>'>
        <input type="hidden" name="id_examen" id="id_examen" value= '<?php echo $id_examen ?>'>

    </form>

        <div class="main-container" id="container">

                <div id="content" class="main-content">

                    <div class="container">

                        <div class="container">



                        <h3 class="page-title"><FONT SIZE=5><?php echo $nom_examen ?></FONT></h3>

                        <h5 class="page-title"><b>Alumno:&nbsp;&nbsp;&nbsp;</b> <?php echo $apellido_pat." ".$apellido_mat.", ".$nombres ?> <b>Carrera que postula:&nbsp;&nbsp;</b><?php echo $nom_carrera; ?></h5><br>

                           

                        </div>

                    </div>

                    

                    <div class="col-lg-12 layout-spacing" >

                        <div class="statbox widget box box-shadow" >

                            

                            <div class="widget-content widget-content-area" style="background-color:#c0bdbc">

                                <div id="circle-basic" class="">

                                    <section>

                                        <h2 style="text-align:center">Condiciones e Instrucciones</h2>

                                        <p style="text-align: justify; color:white"><FONT SIZE=4>

                                        - El examen de admisión está integrado por 80 Preguntas. 4 puntos cada una.<br>

                                        - Tiempo límite de desarrollo: 120 minutos.<br>

                                        - Lee detenidamente cada pregunta y marca la respuesta correcta.<br>

                                        - El postulante sólo puede aplicar el examen una sola vez.<br>

                                        - Los resultados serán publicados a través de nuestra web institucional (<a target="_blank" href="http://www.ifv.edu.pe/admision/">http://www.ifv.edu.pe/admision/</a>) en el icono “ResultadosAdmisión” el <?php echo $fecha_resultados ?>.<br>

                                        <b>¡Éxitos en tu examen!</b>

                                        </FONT></p>

                                        

                                    </section>

                                </div>



                            </div>

                        </div>

                    </div>

                    <!--<div class=" toolbar ">

                        <div class="alineacionbtn">

                            <a  type="button" href="https://www.facebook.com/InstitutoFedericoVillarreal"  target="_blank" class="btn  btn-primary5 mb-2 mr-1 abtn" >

                                Dale <b>me  gusta</b>

                            </a>

                            <a  type="button" id="btn_empezar" class="btn btn-primary5 mb-2 mr-1 abtn" title="Iniciar" >

                                INICIAR EXAMEN

                            </a>

                        </div>

                    </div>-->

                    <div class="col-lg-12" >

                        <div class="alineacionbtn"  >

                            <a  type="button" href="https://www.facebook.com/InstitutoFedericoVillarreal"  target="_blank" class="abtn btn  btn-primary5 mb-2 mr-1 " >

                                Dale <b>me  gusta <i><svg style="width: 35px; height: 35px;" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="35" height="35" x="0" y="0" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><g xmlns="http://www.w3.org/2000/svg">	<path style="" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626   v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006   c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154   C167.657,37.881,130.125,0.349,83.829,0.349z" fill="#ffffff" data-original="#010002"/></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g></g></svg></i> </b>

                            </a>

                            

                            <button  type="button" id="btn_asignar" class="abtn btn btn-primary mb-2 mr-1" title="Siguiente" >

                                EMPEZAR

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



    <div class="modal-contenedor12">

        <div class="popup12 modal-cerrar12" id="quitaragregarer12">

            <p class="cerrar12"></p>

            <div class="cuerpo12">

                <div>

                    <h1 style="text-decoration: underline;" ><b>ACUERDATE</b></h1>

                

                    <h3 class="mensajesubt" style="text-align: justify;"><font size=4>

                    <b>Son 80 preguntas y tienes un

                    tiempo maximo de 120 minutos

                    para terminar</b><br>

                    Si paras a medio ya no puedes

                    volver a hacerlo. Revisa que te

                    encuentras en un local con buena

                    internet. <b>¡Buena Suerte!</b><br>

                    </font></h3>

                    <a  type="button" id="btn_empezar" class="btn btn-primary5 mb-2 mr-1" title="Iniciar" >

                                INICIAR EXAMEN

                    </a>

                    <!--<a type="button" align="center" id="btn_empezar"><img  src="<?= base_url() ?>/template/img/iniciar.png" width="100px" height="29px" alt=""></a>-->

                </div>

            </div>

            

        </div>

    </div>

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

	$('#btn_asignar').on('click', function(e){

            $(".modal-contenedor12").show();

            $(".modal-contenedor12").css("opacity", "1");

            $(".modal-contenedor12").css("visibility", "visible");

            document.getElementById("quitaragregarer12").classList.remove("modal-cerrar12");  

        //$('#formulario').submit();

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

</script>

<?php $this->load->view('3footerpreg'); ?>