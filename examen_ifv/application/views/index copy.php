<?php 
$session =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('1headerpreguntas'); ?>

			<!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
            <div class="row">
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                    <div class="container-fluid px-1 py-5 mx-auto">
                        <div class="row d-flex justify-content-center">
                            <div class="col-xl-12 col-lg-8 col-md-11">
                                <div class="card rounded-0 b-0">
                                <img src="<?= base_url() ?>/template/img/banner.png" class="imgbanner">
                                    <div class="row d-flex justify-content-sm-end justify-content-start px-5">
                                        
                                        
                                        <div class="card-body show pt-0"><br>
                                        <h3 class="page-title">Examen&nbsp;de&nbsp;Admision&nbsp;20/02</h3>
                                        <h5 class="page-title"><b>Alumno:&nbsp;&nbsp;&nbsp;</b> <?php echo $apellido_pat." ".$apellido_mat.", ".$nombres ?> <b>Carrera que postula:&nbsp;&nbsp;</b><?php echo $nom_carrera; ?></h5><br>
                                        <p style="text-align: justify;">
                                            Acuerdate que son 80 preguntas y tienes un tiempo maximo de XX minutos para terminar.
                                            Si paras a medio ya no puedes volver a hacerlo.<br>
                                            Revisa que te encuentras en un local con buena internet.
                                            ¡Buena Suerte!
                                            </p>
                                            <form  method="post" id="formulario" enctype="multipart/form-data" action="<?= site_url('Examendeadmision/Index1')?>" class="formulario">
                                                <input type="hidden" name="id_postulante" id="id_postulante" value= '<?php echo $id_postulante ?>'>
                                                <input type="hidden" name="id_carrera" id="id_carrera" value= '<?php echo $id_carrera ?>'>
                                            </form>
                                            
                                            <div style="align:right;" >
                                                <a target="_blank" href="https://www.facebook.com/InstitutoFedericoVillarreal"><img  src="<?= base_url() ?>/template/img/like.png" width="120px" alt=""></a>
                                                <a type="button" id="btn_asignar"><img  src="<?= base_url() ?>/template/img/iniciar.png" width="120px" height="29px" alt=""></a>
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
                                                        tiempo maximo de 90 minutos
                                                        para terminar</b><br>
                                                        Si paras a medio ya no puedes
                                                        volver a hacerlo. Revisa que te
                                                        encuentras en un local con buena
                                                        internet. <b>¡Buena Suerte!</b><br>
                                                        </font></h3>
                                                        <a type="button" align="center" id="btn_empezar"><img  src="<?= base_url() ?>/template/img/iniciar.png" width="100px" height="29px" alt=""></a>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
                	
        </div>
    </div>

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