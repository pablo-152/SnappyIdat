<?php
$sesion =  $_SESSION['usuario'][0]; 
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Base de Datos (SMS)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo Curso" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Administrador/Modal_Base_Datos') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>

                        <a onclick="Excel_Base_Datos();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Base_Datos(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Base_Datos(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_base_datos" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded', 'true');
        $("#smensaje_sms").addClass('active');
        $("#hmensaje_sms").attr('aria-expanded', 'true');
        $("#bd_mensajes").addClass('active');
        document.getElementById("rmensaje_sms").style.display = "block";
        document.getElementById("rcomercial").style.display = "block";

        Lista_Base_Datos(1);
    });

    function Lista_Base_Datos(tipo){
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

        var url="<?php echo site_url(); ?>Administrador/Lista_Base_Datos";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (resp) {
                $('#lista_base_datos').html(resp);
                $("#tipo_excel").val(tipo);
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

    function Delete_Base_Datos(id) {
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

        var url = "<?php echo site_url(); ?>Administrador/Delete_Base_Datos";

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
                    data: {'id_base_datos':id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Administrador/Base_Datos";
                        });
                    }
                });
            }
        })
    }

    function Excel_Base_Datos(){
        var tipo = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Base_Datos/"+tipo;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>