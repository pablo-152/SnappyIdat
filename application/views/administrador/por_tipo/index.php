<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Por Tipo (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Publicidad();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container-fluid">
        <div class="row">
            <div id="lista_publicidad" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#siredes").addClass('active');
        $("#hiredes").attr('aria-expanded', 'true');
        $("#por_tipos").addClass('active');
		document.getElementById("riredes").style.display = "block";
        document.getElementById("rcomunicacion").style.display = "block";

        //Lista_Publicidad();
    });

    function Lista_Publicidad(){
        Cargando();

        var url="<?php echo site_url(); ?>Administrador/Lista_Publicidad";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_publicidad').html(resp);
            }
        });
    }

    function Excel_Publicidad(){ 
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Publicidad";
    }
</script>

<?php $this->load->view('Admin/footer'); ?>