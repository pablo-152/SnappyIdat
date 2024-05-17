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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Lista de Alumnos</b></span></h4>
                </div> 

                <div class="x_x_panel">
                    <div class="lab" style="background-color: #89ce47;">
                        <h3><?php echo $informe[0]['total_al_dia'];  ?></h3>
                        <h4>Al Día</h4>
                    </div>
                    <div class="lab" style="background-color: #a1a1a1;">
                        <h3><?php echo $informe[0]['total_p1'];  ?></h3>
                        <h4>Pdt 1</h4>
                    </div>               
                    <div class="lab" style="background-color: #fbcdad;">
                        <h3><?php echo $informe[0]['total_p2'];  ?></h3>
                        <h4>Pdt 2</h4>
                    </div>
                    <div class="lab" style="background-color: #e07e80;">
                        <h3><?php echo $informe[0]['total_p3'];  ?></h3>
                        <h4>Pdt 3+</h4>
                    </div>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="#"><!-- onclick="Actualizar_Lista_Matriculados();"-->
                            <img src="<?= base_url() ?>template/img/actualizar_lista.png">
                        </a>

                        <a onclick="Excel_Matriculados();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Matriculados(1);" id="matriculados_btn" style="background-color:#00C000;" class="form-group btn clase_boton"><span>Matriculados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matriculados(5);" id="retirados_btn" style="background-color: #C00000;" class="form-group btn clase_boton"><span>Retirados</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Lista_Matriculados(4);" id="asignado_btn" style="background-color:#a1a1a1;" class="form-group btn clase_boton"><span>Asignados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matriculados(2);" id="proxano_btn" style="background-color:#F18A00;" class="form-group btn clase_boton"><span>Prox Año</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Lista_Matriculados(3);" id="todos_btn" style="background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo" name="tipo"> 
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
        $("#matriculados").addClass('active');
		document.getElementById("ralumnos").style.display = "block";

        Lista_Matriculados(1);
    });

    function Lista_Matriculados(tipo){
        Cargando();

        var url="<?php echo site_url(); ?>LittleLeaders/Lista_Matriculados";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (data) {
                $('#lista_alumno').html(data);
                $('#tipo').val(tipo);
            }
        });

        var matriculados = document.getElementById('matriculados_btn');
        var retirados = document.getElementById('retirados_btn');
        var proxano = document.getElementById('proxano_btn');
        var todos = document.getElementById('todos_btn');
        var asignado = document.getElementById('asignado_btn');

        if(tipo==1){
            matriculados.style.color = '#FFFFFF';
            retirados.style.color = '#000000';
            proxano.style.color = '#000000';
            asignado.style.color = '#000000';
            todos.style.color = '#000000';
        }else if(tipo==2){
            matriculados.style.color = '#000000';
            retirados.style.color = '#000000';
            proxano.style.color = '#FFFFFF';
            asignado.style.color = '#000000';
            todos.style.color = '#000000';
        }else if(tipo==3){
            matriculados.style.color = '#000000';
            retirados.style.color = '#000000';
            asignado.style.color = '#000000';
            proxano.style.color = '#000000';
            todos.style.color = '#FFFFFF';
        }else if(tipo==4){
            matriculados.style.color = '#000000';
            retirados.style.color = '#000000';
            asignado.style.color = '#FFFFFF';
            proxano.style.color = '#000000';
            todos.style.color = '#000000';
        }else if(tipo==5){
            matriculados.style.color = '#000000';
            retirados.style.color = '#FFFFFF';
            asignado.style.color = '#000000';
            proxano.style.color = '#000000';
            todos.style.color = '#000000';
        }
    }

    function Actualizar_Lista_Matriculados(){  
        Cargando();

        var tipo=$('#tipo').val();
        var url="<?php echo site_url(); ?>LittleLeaders/Actualizar_Lista_Matriculados";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                Lista_Matriculados(tipo);
            }
        });
    }

    function Descargar_Foto_Matriculados(id){
        window.location.replace("<?php echo site_url(); ?>LittleLeaders/Descargar_Foto_Matriculados/"+id);
    }

    function Excel_Matriculados(){
        var tipo=$('#tipo').val();
        window.location ="<?php echo site_url(); ?>LittleLeaders/Excel_Matriculados/"+tipo;
    }
</script>

<?php $this->load->view('view_LL/footer'); ?>