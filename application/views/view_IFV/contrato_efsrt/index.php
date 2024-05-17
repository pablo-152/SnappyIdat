<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<?php $this->load->view('view_IFV/header'); ?>  
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Contrato (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Actualizar_Lista_Contrato_Efsrt();">
                            <img src="<?= base_url() ?>template/img/actualizar_lista.png">
                        </a>

                        <a onclick="Excel_Contrato_Efsrt();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="heading-btn-group">
            <a onclick="Lista_Contrato_Efsrt(1);" id="pendientes" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Contrato_Efsrt(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_contrato" class="col-lg-12" style="overflow-x: auto;">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true');
        $("#contratos_efsrt").addClass('active');
		document.getElementById("rpracticas").style.display = "block";

        Lista_Contrato_Efsrt(1);
    });

    function Lista_Contrato_Efsrt(tipo){
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Contrato_Efsrt";

        $.ajax({
            url:url,
            type:"POST",
            data: {'tipo':tipo},
            success:function (resp) {
                $('#lista_contrato').html(resp);
                $("#tipo_excel").val(tipo);
            }
        }); 

        var pendientes = document.getElementById('pendientes');
        var todos = document.getElementById('todos');
        if(tipo==1){
            pendientes.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            pendientes.style.color = '#000000'; 
            todos.style.color = '#ffffff';
        }
    }

    function Actualizar_Lista_Contrato_Efsrt(id){ 
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

        var tipo_excel=$('#tipo_excel').val();
        var url="<?php echo site_url(); ?>AppIFV/Actualizar_Lista_Contrato_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                Lista_Contrato_Efsrt(tipo_excel);
            }
        });
    }

    function Reenviar_Email_Efsrt(id){  
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

        var tipo_excel=$('#tipo_excel').val();
        var url="<?php echo site_url(); ?>AppIFV/Reenviar_Email_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_documento_firma':id},
            success:function (data) {
                Lista_Contrato_Efsrt(tipo_excel);
            } 
        });
    }

    function Validar_Arpay(id){ 
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

        var tipo_excel=$('#tipo_excel').val();
        var url="<?php echo site_url(); ?>AppIFV/Validar_Arpay";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_documento_firma':id},
            success:function (data) {
                Lista_Contrato_Efsrt(tipo_excel);
            }
        });
    }

    function Delete_Contrato(id){
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

        var tipo_excel=$('#tipo_excel').val();
        var url="<?php echo site_url(); ?>AppIFV/Delete_Contrato";

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
                    type:"POST",
                    url:url,
                    data: {'id_documento_firma':id},
                    success:function () {
                        Lista_Contrato_Efsrt(tipo_excel);
                    }
                });
            }
        })
    }

    function Excel_Contrato_Efsrt() {
        var tipo_excel=$('#tipo_excel').val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Contrato_Efsrt/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>