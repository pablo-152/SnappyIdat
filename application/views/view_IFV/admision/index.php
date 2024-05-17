<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading"> 
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Admisión M1 (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Admision();"> 
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Modulo_Admision(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Modulo_Admision(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" value="1">
        </div>

        <div class="row">
            <div class="col-lg-12" id="lista_admision">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#admision_formulario").addClass('active');
        $("#hadmision_formulario").attr('aria-expanded', 'true');
        $("#admisiones").addClass('active');
		document.getElementById("radmision_formulario").style.display = "block";
        Lista_Modulo_Admision(1);
    });

    function Lista_Modulo_Admision(tipo){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Lista_Modulo_Admision";

        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo},
            success:function (data) {
                $('#lista_admision').html(data);
                $('#tipo_excel').val(tipo);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Excel_Admision(){
        Cargando();
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Admision/"+tipo_excel;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>