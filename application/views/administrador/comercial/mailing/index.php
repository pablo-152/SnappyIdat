<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">

                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
                        <span class="text-semibold"><b>Mailing (Lista)</b></span>
                    </h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Enviar" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Administrador/Modal_Enviar_Mailing') ?>">
                            <img src="<?= base_url() ?>template/img/enviar.PNG">
                        </a>

                        <a onclick="Excel_Mailing();">
                            <img src="<?= base_url() ?>template/img/excel.png" style="margin-left:5px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Mailing(0);" id="btn_activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Mailing(1);" id="btn_todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel">
        </div>

        <div class="row">
            <div class="col-lg-12" id="lista_mailing">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded', 'true');
        $("#mailings").addClass('active');
        document.getElementById("rcomercial").style.display = "block";

        Lista_Mailing(0);
    });

    function Lista_Mailing(tipo) {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var url = "<?php echo site_url(); ?>Administrador/Lista_Mailing";

        $.ajax({
            type: "POST",
            url: url,
            data: {'tipo': tipo},
            success: function(resp) {
                $('#lista_mailing').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var activos = document.getElementById('btn_activos');
        var todos = document.getElementById('btn_todos');

        if (tipo == 0) {
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        } else {
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Excel_Mailing() {
        var tipo_excel = $('#tipo_excel').val();
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Mailing/" + tipo_excel;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>