<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
                    <span class="text-semibold"><b>Documentos PDF</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nuevo Documento PDF" style="cursor:pointer;cursor:hand;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('Administrador/Modal_Insert_Documentos_PDF') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Documento PDF" />
                        </a>
                        <a href="<?= site_url('Administrador/Excel_Documento_PDF') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="lista_documento_pdf">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#documentos_pdf").addClass('active');
        document.getElementById("rcomunicacion").style.display = "block";

        Lista_Documentos_PDF();
    });

    function Lista_Documentos_PDF(){
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

        var url = "<?php echo site_url(); ?>Administrador/Lista_Documentos_PDF";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                $('#lista_documento_pdf').html(data);
            }
        });
    }
</script>

<?php $this->load->view('Admin/footer'); ?>