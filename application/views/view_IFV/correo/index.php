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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Correo (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Correo_Efsrt') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo" />
                        </a>

                        <a onclick="Excel_Correo();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container-fluid">
        <div class="row">
            <div id="lista_correo" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
        $("#hconfiguraciones").attr('aria-expanded', 'true');
        document.getElementById("rconfiguraciones").style.display = "block";
        $("#configuraciones_efsrt").addClass('active');
        $("#hconfiguraciones_efsrt").attr('aria-expanded', 'true');
        document.getElementById("rconfiguraciones_efsrt").style.display = "block";
        $("#c_efsrt_correos").addClass('active');

        Lista_Correo();
    });

    function Lista_Correo(){ 
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Correo_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_correo').html(resp);
            }
        });
    }

    function Delete_Correo(id){
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Correo_Efsrt";
        
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
                    data: {'id_correo':id},
                    success:function () {
                        Lista_Correo();
                    }
                });
            }
        })
    }

    function Descargar_Correo(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Correo_Efsrt/"+id);
    }

    function Excel_Correo(){ 
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Correo_Efsrt";
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>