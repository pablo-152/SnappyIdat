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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Tipo Producto (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Tipo_Venta') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo" />
                        </a>
                        <a href="<?= site_url('AppIFV/Excel_Tipo_Venta') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_tipo_venta" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
        $("#conf_ventas").addClass('active');
        $("#hconf_ventas").attr('aria-expanded', 'true');
        $("#v_tipos").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";
        document.getElementById("rconf_ventas").style.display = "block";
        Lista_Tipo_Venta();
    });

    function Lista_Tipo_Venta(){
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Tipo_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_tipo_venta').html(resp);
            }
        });
    }

    function Delete_Tipo_Venta(id){ 
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Tipo_Venta";
        
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
                    data: {'id_tipo':id},
                    success:function () {
                        Lista_Tipo_Venta();
                    }
                });
            }
        })
    }

    function Descargar_Foto_Tipo_Venta(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Tipo_Venta/"+id);
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>