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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Lista de Alumnos</b></span></h4>
                </div>

                    
                <div class="heading-elements">
                    <div class="heading-btn-group">

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
            <a onclick="Lista_Matriculados_C(1);" id="matriculados_btn" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Matriculados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matriculados_C(4);" id="promovidos_btn" style="color: #ffffff;background-color: #7F7F7F ;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Promovidos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matriculados_C(3);" id="retirados_btn" style="color: #000000; background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Retirados</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Lista_Matriculados_C(2);" id="todos_btn" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="g_matriculados" value="<?php echo "0";//$list_grupo[0]['total_matriculados']; ?>">
            <input type="hidden" id="g_promovidos" value="<?php echo "0";//$list_grupo[0]['total_promovidos']; ?>">
            <input type="hidden" id="l_matriculados" value="<?php echo "0";//$list_matriculados[0]['total_a_matriculados']; ?>">
            <input type="hidden" id="l_promovidos" value="<?php echo "0";//$list_matriculados[0]['total_a_promovidos']; ?>">
        </div>

        <div class="row"> 
            <div class="col-lg-12" id="lista_alumno" style="overflow-x: auto;">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#calendarizaciones").addClass('active');
        $("#hcalendarizaciones").attr('aria-expanded', 'true');
        $("#matriculados_c").addClass('active');
		document.getElementById("rcalendarizaciones").style.display = "block";

        Lista_Matriculados_C(1);

        var g_matriculados = $('#g_matriculados').val();
        var g_promovidos = $('#g_promovidos').val();
        var l_matriculados = $('#l_matriculados').val();
        var l_promovidos = $('#l_promovidos').val();

        if(g_matriculados!=l_matriculados || g_promovidos!=l_promovidos){
            Swal({
                title: 'Alerta Roja',
                text: "¡No coinciden los datos de la parte superior!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        }
    });

    function Lista_Matriculados_C(tipo){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Lista_Matriculados_C";

        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo},
            success:function (data) {
                $('#lista_alumno').html(data);
                $('#tipo_excel').val(tipo);
            }
        });

        var matriculados = document.getElementById('matriculados_btn');
        var todos = document.getElementById('todos_btn');
        var retirados = document.getElementById('retirados_btn');
        var promovidos = document.getElementById('promovidos_btn');
        if(tipo==1){
            todos.style.color = '#000000';
            matriculados.style.color = '#ffffff';
            retirados.style.color = '#000000'; 
            promovidos.style.color = '#000000';
        }else if(tipo==2){
            todos.style.color = '#ffffff';
            matriculados.style.color = '#000000';
            retirados.style.color = '#000000';
            promovidos.style.color = '#000000';
        }else if(tipo==3){
            retirados.style.color = '#ffffff';
            todos.style.color = '#000000';
            matriculados.style.color = '#000000';
            promovidos.style.color = '#000000';
        }else if(tipo==4){
            todos.style.color = '#000000';
            matriculados.style.color = '#000000';
            retirados.style.color = '#000000';
            promovidos.style.color = '#ffffff';
        }
    }

    function Actualizar_Lista_Matriculados_C(){  
        Cargando();

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
        Cargando();
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Matriculados_C/"+id);
    }

    function Excel_Matriculados_C(){
        Cargando();
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Matriculados_C/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>