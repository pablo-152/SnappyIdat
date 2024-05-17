<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .img-presentation-small {
        width: 100px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }
    .x_x_panel h3{ 
        margin: 0px 0px 0px 0px;
    }
    .x_x_panel h4{ 
        margin: 0px 0px 0px 0px;
        font-size: 15px;
    }
    .x_x_panel{
        display: flex;
        width: 300px;
        flex-direction: row;
        text-align: center;
        justify-content: space-between;
        position: absolute;
        color: #fff;
        top: 50%;
        right: 165px;
        margin-top: -30px;
    }

    .x_x_panel .lab{
        width: 67px;
        height: 64.59px;
        display: grid;
        align-content: center;
    }

</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Lista de Postulantes</b></span></h4>
                    <!--<h3 style="font-size: 15px; color:white;position: absolute;top: 40%;left: 10%;margin: -20px calc(50% - 400px) 0 calc(50% - 400px);"><span style="font-weight: bold;">ALUMNOS GRUPOS:</span> Matriculados(<?php //echo $list_grupo[0]['total_matriculados']; ?>); Promovidos(<?php //echo  $list_grupo[0]['total_promovidos']; ?>) <span style="font-weight: bold;"> Total: <?php //echo  array_sum($list_grupo[0]); ?></span></h3>  
                    <h3 style="font-size: 15px; color:white;position: absolute;top: 40%;left: 10%;margin: 5px calc(50% - 400px) 0 calc(50% - 400px);"><span style="font-weight: bold;">ALUMNOS LISTA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>     Matriculados(<?php //echo $list_matriculados[0]['total_a_matriculados']; ?>); Promovidos(<?php //echo  $list_matriculados[0]['total_a_promovidos']; ?>)  <span style="font-weight: bold;">  Total: <?php //echo  array_sum($list_matriculados[0]); ?></span></h3>-->
                </div>
                
                <!--<div class="x_x_panel">
                    <div class="lab" style="background-color: #89ce47;">
                        <h3><?php //echo $cantidadnulos1[0]['total_aldia'];  ?></h3>
                        <h4>Al Día</h4>
                    </div>
                    <div class="lab" style="background-color: #a1a1a1;">
                        <h3><?php //echo $cantidadnulos1[0]['total_p1'];  ?></h3>
                        <h4>Pdt 1</h4>
                    </div>               
                    <div class="lab" style="background-color: #fbcdad;">
                        <h3><?php //echo $cantidadnulos1[0]['total_p2'];  ?></h3>
                        <h4>Pdt 2</h4>
                    </div>
                    <div class="lab" style="background-color: #e07e80;">
                        <h3><?php //echo $cantidadnulos1[0]['total_p3'];  ?></h3>
                        <h4>Pdt 3+</h4>
                    </div>
                </div>-->
                    
                    
                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <!--<a href="#"><onclick="Actualizar_Lista_Matriculados_C();"-->
                            <!--<img src="<?= base_url() ?>template/img/actualizar_lista.png">
                        </a>-->
                        <a title="Nuevo" type="button" data-toggle="modal" data-target="#acceso_modal_mod" href="http://localhost/new_snappy/index.php?/AppIFV/Registrar_Postulante">
                            <img src="http://localhost/new_snappy/template/img/nuevo.png">
                        </a>

                        <a onclick="Excel_Matriculados_C();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="tipo_excel" value="1">
 
    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Postulantes_Formulario_Lista(4);" id="promovidos_btn" style="color: #ffffff;background-color: #00c000 ;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Finalizadas</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Postulantes_Formulario_Lista(1);" id="matriculados_btn" style="color: #ffffff;background-color: #37b5e7;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todas</span><i class="icon-arrow-down52"></i></a>
            <!--<a onclick="Lista_Matriculados_C(3);" id="retirados_btn" style="color: #000000; background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Retirados</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Lista_Matriculados_C(2);" id="todos_btn" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="g_matriculados" value="<?php echo "0";//$list_grupo[0]['total_matriculados']; ?>">
            <input type="hidden" id="g_promovidos" value="<?php echo "0";//$list_grupo[0]['total_promovidos']; ?>">
            <input type="hidden" id="l_matriculados" value="<?php echo "0";//$list_matriculados[0]['total_a_matriculados']; ?>">
            <input type="hidden" id="l_promovidos" value="<?php echo "0";//$list_matriculados[0]['total_a_promovidos']; ?>">-->
        </div>
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-lg-12" id="lista_alumno" style="overflow-x: auto;">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#admision_formulario").addClass('active');
        $("#hadmision_formulario").attr('aria-expanded', 'true');
        $("#lista").addClass('active');
		document.getElementById("radmision_formulario").style.display = "block";

        Postulantes_Formulario_Lista(4);
    });

    function Postulantes_Formulario_Lista(tipo){ 
        /*$(document)
        .ajaxStart(function () {
          $.blockUI({
            message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#F18900" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/ifv_logo.png"></div>',
            fadeIn: 800,
            overlayCSS: {
              backgroundColor: '#1b2024',
              opacity: 0.8,
              zIndex: 1200,
              cursor: 'wait'
            },
            css: {
              border: 0,
              color: '#fff',
              zIndex: 1201,
              padding: 0,
              backgroundColor: 'transparent'
            }
          });
        })
        .ajaxStop(function () {
          $.blockUI({
            message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#F18900" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/ifv_logo.png"></div>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
              backgroundColor: '#1b2024',
              opacity: 0.8,
              zIndex: 1200,
              cursor: 'wait'
            },
            css: {
              border: 0,
              color: '#fff',
              zIndex: 1201,
              padding: 0,
              backgroundColor: 'transparent'
            }
          });
        });*/
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Postulantes_Formulario_Lista";

        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo},
            success:function (data) {
                $('#lista_alumno').html(data);
                $('#tipo_excel').val(tipo);
            }
        });

        /*var matriculados = document.getElementById('matriculados_btn');*/
        var todos = document.getElementById('matriculados_btn'); // todos 1
        var finalizado = document.getElementById('promovidos_btn'); // finalizado 4
        /*var promovidos = document.getElementById('promovidos_btn');*/
        if(tipo==1){
            todos.style.color = '#ffffff';
            finalizado.style.color = '#000000'; 
            
        }else if(tipo==4){
            todos.style.color = '#000000';
            finalizado.style.color = '#ffffff';
        }
    }
/*
    function Actualizar_Lista_Matriculados_C(){  
        $(document)
        .ajaxStart(function () {
          $.blockUI({
            message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#F18900" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/ifv_logo.png"></div>',
            fadeIn: 800,
            overlayCSS: {
              backgroundColor: '#1b2024',
              opacity: 0.8,
              zIndex: 1200,
              cursor: 'wait'
            },
            css: {
              border: 0,
              color: '#fff',
              zIndex: 1201,
              padding: 0,
              backgroundColor: 'transparent'
            }
          });
        })
        .ajaxStop(function () {
          $.blockUI({
            message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#F18900" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/ifv_logo.png"></div>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
              backgroundColor: '#1b2024',
              opacity: 0.8,
              zIndex: 1200,
              cursor: 'wait'
            },
            css: {
              border: 0,
              color: '#fff',
              zIndex: 1201,
              padding: 0,
              backgroundColor: 'transparent'
            }
          });
        });

        var url="<?php echo site_url(); ?>AppIFV/Actualizar_Lista_Matriculados_C";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Matriculados_C(1);
                });
            }
        });
    }

    function Descargar_Foto_Matriculados_C(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Matriculados_C/"+id);
    }*/

    function Excel_Matriculados_C(){
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Postulantes_Formulario/"+tipo_excel;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>