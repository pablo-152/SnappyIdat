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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Solicitud (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Solicitud();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a id="activos" style="color: #ffffff;background-color: #00C000;height:32px;width:150px;padding:5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a id="todos" style="color: #000000; background-color: #0070c0;height:32px;width:150px;padding:5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
        </div>

        <div class="row">
            <div id="lista_solicitud" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#titulacion").addClass('active');
        $("#htitulacion").attr('aria-expanded', 'true');
        $("#solicitudes").addClass('active');
		document.getElementById("rtitulacion").style.display = "block";

        Lista_Solicitud();
    });

    function Lista_Solicitud(){
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Solicitud";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_solicitud').html(resp);
            }
        });
    }

    function Excel_Solicitud() {
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Solicitud";
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>