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
        right: 120px;
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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Lista de Uniformes</b></span></h4>
                </div>

                    
                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Matriculados_C();">
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
            <a onclick="Lista_Uniforme(1);" id="matriculados" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Matriculados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Uniforme(4);" id="promovidos" style="display:none" class="form-group btn"><span>Promovidos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Uniforme(3);" id="retirados" style="display:none" class="form-group btn"><span>Retirados</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Lista_Uniforme(2);" id="todos" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
        </div>

        <div class="row">
            <div class="col-lg-12" id="lista_alumno">
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
        Lista_Uniforme(1);
    });

    function Lista_Uniforme(tipo){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
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
                message: '<svg> ... </svg>',
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Uniforme";

        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo},
            success:function (data) {
                $('#lista_alumno').html(data);
                $('#tipo_excel').val(tipo);
            }
        });

        var matriculados = document.getElementById('matriculados');
        var todos = document.getElementById('todos');
        var retirados = document.getElementById('retirados');
        var promovidos = document.getElementById('promovidos');
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

    function Descargar_Foto_Uniforme(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Uniforme/"+id);
    }

    function Excel_Uniforme(){
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Uniforme/"+tipo_excel;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>