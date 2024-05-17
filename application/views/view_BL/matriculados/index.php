<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<style>
    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Lista</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Matriculados();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Buscar(1);" id="matriculados" style="color:#ffffff;background-color:#92D050;" class="form-group btn clase_boton"><span>Matriculados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Buscar(2);" id="todos" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
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
        $("#matriculados").addClass('active');
		document.getElementById("ralumnos").style.display = "block";
        Buscar(1);
    });

    function Buscar(tipo){
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

        var url="<?php echo site_url(); ?>BabyLeaders/Lista_Matriculados";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (data) {
                $('#lista_alumno').html(data);
                $('#tipo').val(tipo);
            }
        });

        var matriculados = document.getElementById('matriculados');
        var todos = document.getElementById('todos');

        if(tipo==1){
          matriculados.style.color = '#FFFFFF';
          todos.style.color = '#000000';
        }else{
          matriculados.style.color = '#000000';
          todos.style.color = '#FFFFFF';
        }
    }

    function Excel_Matriculados(){
        var tipo=$('#tipo').val();
        window.location ="<?php echo site_url(); ?>BabyLeaders/Excel_Matriculados/"+tipo;
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>