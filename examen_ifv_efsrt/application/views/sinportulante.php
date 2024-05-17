<?php 

//$session_alumno =  $_SESSION['dni_alumno'][0];

defined('BASEPATH') OR exit('No direct script access allowed');

//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];

?>

<?php $this->load->view('1headerpreguntas'); ?>



			<!-- Page Wrapper -->

            <div class="modall-container">

                <div class="modall modal-closer" id="quitaragregar">

                    <div class="cuerpololamento">

                        <div>

                            <h1 class="mensajet">Hola!

                            </h1><br>

                            <h3 style="text-align: justify; " class="mensajesubt">

                            Tu examen ya no se encuentra disponible.<br><br>

                            Alguna duda por favor entra en contacto con nosotros. <?php echo date('H:i:s', time()); ?><br>

                                <!--<br><br>

                                ¿Desea volver este <br> tema desde el inicio e <br> 

                                intentar de nuevo el examen? <img onclick="Reintentar_Tema();" src="<?= base_url() ?>template/css/modalsexamenmas/si.png" width="40px" height="40px"  alt="">-->

                                

                            </h3>

                        </div>

                    </div>

                </div>

            </div>



    <div class="page-wrapper">

        <div class="content container-fluid">

            <!-- Page Header -->

            <div class="page-header">

            <div class="row">

                    <div class="col-sm-12">

                        <!--<h3 class="page-title">Postulante no encontrado</h3>

                        <h3 class="page-title">o ya respondiste el examen</h3>-->

                        

                    </div>

                </div>

            </div>

            <!-- /Page Header -->

            

                	

        </div>

    </div>



<script>

    var base_url = '<?php echo site_url(); ?>';

    var timeout;



    $(document).ready(function() {

        clearTimeout(timeout); 

        contadorSesion();

    } );



    function contadorSesion() {

        timeout = setTimeout(salir, 20000);//3 segundos para no demorar tanto 

    }



    function salir() {

        window.location.href = "http://www.ifv.edu.pe/"; //esta función te saca

    }

</script>

<?php $this->load->view('3footerpreg'); ?>