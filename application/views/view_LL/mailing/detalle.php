<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LL/header'); ?>
<?php $this->load->view('view_LL/nav'); ?>

<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Mailing</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('LittleLeaders/Mailing') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>

                        <a onclick="Excel_Detalle_Mailing();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Detalle_Mailing(1);" id="activos_btn" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Detalle_Mailing(2);" id="todos_btn" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_detalle_mailing" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#mailings").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        Lista_Detalle_Mailing(1);
    });

    function Lista_Detalle_Mailing(tipo){
        Cargando();

        var id_mailing = <?php echo $get_id[0]['id_mailing']; ?>;
        var url="<?php echo site_url(); ?>LittleLeaders/Lista_Detalle_Mailing";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_mailing':id_mailing,'tipo':tipo},
            success:function (resp) {
                $('#lista_detalle_mailing').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var activos = document.getElementById('activos_btn');
        var todos = document.getElementById('todos_btn');
        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Excel_Detalle_Mailing(id){
        var id_mailing = <?php echo $get_id[0]['id_mailing']; ?>;
        var tipo_excel = $('#tipo_excel').val();
        window.location.replace("<?php echo site_url(); ?>LittleLeaders/Excel_Detalle_Mailing/"+id_mailing+"/"+tipo_excel); 
    }
</script>

<?php $this->load->view('view_LL/footer'); ?>