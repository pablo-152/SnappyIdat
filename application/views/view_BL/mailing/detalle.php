<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Mailing</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('BabyLeaders/Mailing') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>

                        <a href="<?= site_url('BabyLeaders/Excel_Detalle_Mailing') ?>/<?php echo $get_id[0]['id_mailing']; ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_detalle_mailing" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#mailings").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        Lista_Detalle_Mailing();
    });

    function Lista_Detalle_Mailing(){
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

        var id_mailing = <?php echo $get_id[0]['id_mailing']; ?>;
        var url="<?php echo site_url(); ?>BabyLeaders/Lista_Detalle_Mailing";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_mailing':id_mailing},
            success:function (resp) {
                $('#lista_detalle_mailing').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>