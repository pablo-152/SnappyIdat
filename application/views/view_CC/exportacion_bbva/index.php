<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Recaudación (Exportación)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nueva Recaudación" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('CursosCortos/Modal_Exportacion_Bbva') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nueva Recaudación" />
                        </a>
                        <a href="<?= site_url('CursosCortos/Excel_Seccion') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_exportacion_bbva" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad_sunat").addClass('active');
        $("#hcontabilidad_sunat").attr('aria-expanded', 'true');
        $("#exportaciones").addClass('active');
		document.getElementById("rcontabilidad_sunat").style.display = "block";

        Lista_Exportacion_Bbva();
    });

    function Lista_Exportacion_Bbva(){
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

        var url="<?php echo site_url(); ?>CursosCortos/Lista_Exportacion_Bbva";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_exportacion_bbva').html(resp);
            }
        });
    }

    function Generar_Txt(id){    
        window.location = "<?php echo site_url(); ?>CursosCortos/Generar_Txt/"+id;
    }
</script>

<?php $this->load->view('view_CC/footer'); ?>