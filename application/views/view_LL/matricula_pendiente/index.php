<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_LL/header'); ?>
<?php $this->load->view('view_LL/nav'); ?>

<style>
    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px; 
        color: black;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Matriculas (Lista)</b></span></h4>
                </div> 

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Matricula_Pendiente();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Matricula_Pendiente(1);" id="pendientes" style="background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matricula_Pendiente(2);" id="nuevos" style="background-color:#FEFE00;" class="form-group btn clase_boton"><span>Nuevos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matricula_Pendiente(3);" id="todos" style="background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo" name="tipo" value="1">
        </div>

        <div class="row">
            <div class="col-lg-12" id="lista_alumno"> 
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#alumnos").addClass('active');
        $("#halumnos").attr('aria-expanded','true');
        $("#matriculas_pendientes").addClass('active');
		document.getElementById("ralumnos").style.display = "block";

        Lista_Matricula_Pendiente(1);
    });

    function Lista_Matricula_Pendiente(tipo){
        Cargando();

        var url="<?php echo site_url(); ?>LittleLeaders/Lista_Matricula_Pendiente";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (data) {
                $('#lista_alumno').html(data);
                $('#tipo').val(tipo);
            }
        });

        var pendientes = document.getElementById('pendientes');
        var nuevos = document.getElementById('nuevos'); 
        var todos = document.getElementById('todos');

        if(tipo==1){
            pendientes.style.color = '#FFFFFF';
            nuevos.style.color = '#000000';
            todos.style.color = '#000000';
        }else if(tipo==2){
            pendientes.style.color = '#000000';
            nuevos.style.color = '#FFFFFF';
            todos.style.color = '#000000';
        }else{
            pendientes.style.color = '#000000';
            nuevos.style.color = '#000000';
            todos.style.color = '#FFFFFF';
        }
    }

    function Excel_Matricula_Pendiente(){
        var tipo=$('#tipo').val();
        window.location ="<?php echo site_url(); ?>LittleLeaders/Excel_Matricula_Pendiente/"+tipo;
    }
</script>

<?php $this->load->view('view_LL/footer'); ?>