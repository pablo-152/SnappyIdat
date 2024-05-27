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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Motivo Contactenos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <!--<a title="Nueva Módulo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('AppIFV/Modal_C_Motivo_Contactenos') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>-->

                        <a type="button" title="Nueva Módulo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_C_Motivo_Contactenos') ?>">  
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Módulo" />
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_C_Motivo_Contactenos') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="busqueda">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {


        $("#configuraciones").addClass('active');
        $("#hconfiguraciones").attr('aria-expanded', 'true');
        document.getElementById("rconfiguraciones").style.display = "block";
        $("#configuraciones_ifvonline").addClass('active');
        $("#hconfiguraciones_ifvonline").attr('aria-expanded', 'true');
        document.getElementById("rconfiguraciones_ifvonline").style.display = "block";
        $("#conf_ifvonline_conta").addClass('active');
        /*$("#sconf_fv_ifvonline").addClass('active');
        $("#conf_ifvonline_conta").addClass('active');
        $("#hconf_fv_ifvonline").attr('aria-expanded', 'true');
        document.getElementById("rconf_fv_ifvonline").style.display = "block";*/
        
        List_C_Motivo_Contactenos();
        $("#acceso_modal_mod").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_mod"));
        });
    });
</script>

<script>
    function List_C_Motivo_Contactenos(){
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

        var url="<?php echo site_url(); ?>AppIFV/List_C_Motivo_Contactenos";
        
        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                $('#busqueda').html(data);
            }
        });
    }
    function Delete_C_Motivo_Contactenos(id){
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_C_Motivo_Contactenos";
        
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
                    data: {'id_motivo':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            List_C_Motivo_Contactenos();
                        });
                    }
                });
            }
        })
    }
</script>
<?php $this->load->view('view_IFV/footer'); ?>