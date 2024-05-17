<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;"> 
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Colaboradores Obs.(Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Colaborador_Obs();"> 
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
            <div id="lista_colaborador_obs" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded','true');
        $("#informe_colaborador").addClass('active');
        $("#hinforme_colaborador").attr('aria-expanded','true');
        $("#colaborador_obs").addClass('active');
		document.getElementById("rinforme_colaborador").style.display = "block";
        document.getElementById("rcolaboradores").style.display = "block";

        Lista_Colaborador_Obs(); 
    });

    function Lista_Colaborador_Obs(tipo){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Lista_Colaborador_Obs";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_colaborador_obs').html(resp);
            }
        });
    }

    function Excel_Colaborador_Obs(){
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Colaborador_Obs";
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>
<?php $this->load->view('view_IFV/utils/index.php'); ?>
