<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('ceba2/header'); ?>
<?php $this->load->view('ceba2/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;"> 
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Alumnos Obs.(Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Alumno_Obs();"> 
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">            
            <input type="hidden" id="tipo_excel" value="2">
        </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_alumno_obs" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informes").addClass('active');
        $("#hinformes").attr('aria-expanded','true');
        $("#alumnos_obs").addClass('active');
		document.getElementById("rinformes").style.display = "block";

        Lista_Alumno_Obs(); 
    });

    function Lista_Alumno_Obs(tipo){ 
        Cargando();

        var url="<?php echo site_url(); ?>Ceba2/Lista_Alumno_Obs";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_alumno_obs').html(resp);
            }
        });
    }

    function Excel_Alumno_Obs(){
        window.location ="<?php echo site_url(); ?>Ceba2/Excel_Alumno_Obs";
    }
</script>

<?php $this->load->view('ceba2/validaciones'); ?>
<?php $this->load->view('ceba2/footer'); ?>