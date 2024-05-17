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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Grupos (Lista)</b></span></h4>
                    <h3 style="font-size: 15px; color:white;position: absolute;top: 40%;left: 10%;margin: -20px calc(50% - 400px) 0 calc(50% - 400px);"><span style="font-weight: bold;">ALUMNOS GRUPOS:</span> Matriculados(<?php echo $list_grupo[0]['total_matriculados']; ?>); Promovidos(<?php echo  $list_grupo[0]['total_promovidos']; ?>) <span style="font-weight: bold;"> Total: <?php echo  array_sum($list_grupo[0]); ?></span></h3>  
                    <h3 style="font-size: 15px; color:white;position: absolute;top: 40%;left: 10%;margin: 5px calc(50% - 400px) 0 calc(50% - 400px);"><span style="font-weight: bold;">ALUMNOS LISTA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>     Matriculados(<?php echo $list_matriculados[0]['total_a_matriculados']; ?>); Promovidos(<?php echo  $list_matriculados[0]['total_a_promovidos']; ?>)  <span style="font-weight: bold;">  Total: <?php echo  array_sum($list_matriculados[0]); ?></span></h3>     
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85){  ?>
                            <a type="button" href="<?= site_url('AppIFV/Registrar_Grupo_C') ?>"> 
                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo"> 
                            </a>
                        <?php } ?>

                        <a onclick="Excel_Grupo_C();" style="margin-left: 5px;"> 
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Grupo_C(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Grupo_C(3);" id="pendientes" style="color: #000000;background-color: #BF9000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Terminados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Grupo_C(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel">
            <input type="hidden" id="g_matriculados" value="<?php echo $list_grupo[0]['total_matriculados']; ?>">
            <input type="hidden" id="g_promovidos" value="<?php echo $list_grupo[0]['total_promovidos']; ?>">
            <input type="hidden" id="l_matriculados" value="<?php echo $list_matriculados[0]['total_a_matriculados']; ?>">
            <input type="hidden" id="l_promovidos" value="<?php echo $list_matriculados[0]['total_a_promovidos']; ?>">
        </div>

        <div class="row">
            <div id="lista_grupo" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#grupos").addClass('active');
        $("#hgrupos").attr('aria-expanded', 'true'); 
        $("#grupos_c").addClass('active');
		document.getElementById("rgrupos").style.display = "block";

        Lista_Grupo_C(1);

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

    function Lista_Grupo_C(tipo){
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Lista_Grupo_C";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'tipo':tipo},
            success: function(resp){
                $('#lista_grupo').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        var pendientes = document.getElementById('pendientes');

        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
            pendientes.style.color = '#000000';
        }else if(tipo==2){
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
            pendientes.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#000000';
            pendientes.style.color = '#ffffff';
        }
    }

    function Delete_Grupo_C(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Grupo_C";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_grupo':id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Grupo_C";
                        });
                    }
                });
            }
        })
    }

    function Excel_Grupo_C(){ 
        Cargando();
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Grupo_C/"+tipo_excel;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>