<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('ceba2/header'); ?>
<?php $this->load->view('ceba2/nav'); ?>

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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Matrícula (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo grado" style="cursor:pointer;margin-right:5px;" href="<?= site_url('Ceba2/Modal_Matricula') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nueva Matrícula" />
                        </a>
                        <a onclick="Excel_Matricula();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Matricula(1);" id="matriculados" style="color:#ffffff;background-color:#00C000;" class="form-group btn clase_boton"><span>Matriculados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Matricula(2);" id="todos" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="parametro" name="parametro" value="1">
        </div>

        <div class="row">
            <div id="lista_matricula" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#alumno").addClass('active');
        $("#halumno").attr('aria-expanded', 'true');
        $("#matriculas").addClass('active');
		document.getElementById("ralumno").style.display = "block";

        Lista_Matricula(1);
    });

    function Lista_Matricula(parametro){
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

        var url="<?php echo site_url(); ?>Ceba2/Lista_Matricula";

        $.ajax({
            type:"POST",
            url:url,
            data:{'parametro':parametro},
            success:function (resp) {
                $('#lista_matricula').html(resp);
                $('#parametro').val(parametro);
            }
        });

        var matriculados = document.getElementById('matriculados');
        var todos = document.getElementById('todos');

        if(parametro==1){
          matriculados.style.color = '#FFFFFF';
          todos.style.color = '#000000';
        }else{
          matriculados.style.color = '#000000';
          todos.style.color = '#FFFFFF';
        }
    }

    function Excel_Matricula(){
        var parametro=$('#parametro').val();
        window.location ="<?php echo site_url(); ?>Ceba2/Excel_Matricula/"+parametro;
    }
</script>
</script>

<?php $this->load->view('ceba2/validaciones'); ?>
<?php $this->load->view('ceba2/footer'); ?>