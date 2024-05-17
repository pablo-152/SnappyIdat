<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA3/header'); ?>
<?php $this->load->view('view_LA3/nav'); ?> 

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Transferencia (Lista)</b></span></h4>
                </div>
 
                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Pdf_Informe_Transferencia();" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/exportar_pdf.png" alt="Exportar Excel" />
                        </a>

                        <a onclick="Excel_Informe_Transferencia();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_informe_transferencia" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informes").addClass('active');
        $("#hinformes").attr('aria-expanded', 'true');
        $("#i_transferencias").addClass('active');
		document.getElementById("rinformes").style.display = "block";

        Lista_Informe_Transferencia();
    });

    function Lista_Informe_Transferencia(){
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

        var url="<?php echo site_url(); ?>Laleli3/Lista_Informe_Transferencia";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_informe_transferencia').html(resp);
            }
        });
    }

    function Pdf_Informe_Transferencia() { 
        window.open('<?php echo site_url(); ?>Laleli3/Pdf_Informe_Transferencia', '_blank');
    }

    function Excel_Informe_Transferencia() {
        window.location = "<?php echo site_url(); ?>Laleli3/Excel_Informe_Transferencia";
    }
</script>

<?php $this->load->view('view_LA3/footer'); ?>