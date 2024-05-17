<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo $get_id[0]['nom_empresa']." (".$get_id[0]['cuenta_bancaria'].")"; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                            <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ca/Modal_Mes_Detalle_Saldo_Banco') ?>/<?php echo $get_id[0]['id_estado_bancario']; ?>">  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Evento" />
                            </a>
                        <?php } ?>
                        <a style="margin-right:5px;" href="<?= site_url('Ca/Excel_Detalle_Saldo_Banco') ?>/<?php echo $get_id[0]['id_estado_bancario']; ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                        <a type="button" href="<?= site_url('Ca/Saldo_Banco') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <input type="hidden" id="id_estado_bancario" name="id_estado_bancario" value="<?php echo $get_id[0]['id_estado_bancario']; ?>">
        <div class="row">
            <div id="lista_detalle_saldo_banco" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded','true');
        $("#saldo_bancos").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";

        Lista_Detalle_Saldo_Banco();
    });

    function Lista_Detalle_Saldo_Banco(){
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

        var url="<?php echo site_url(); ?>Ca/Lista_Detalle_Saldo_Banco";
        var id_estado_bancario = $("#id_estado_bancario").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_estado_bancario':id_estado_bancario},
            success:function (resp) {
                $('#lista_detalle_saldo_banco').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>