<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<style>
    .gris:hover{
        background-color: #a5a5a5;
        color: #FFF;
    }

    .gris{
        background-color: #cecece;
        color: #FFF;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        margin-top: 10px;
        display: block;
    }

    .col-lg-1 {
        width: 12.33333333%;
    }

    .btn_negro{
        background-color: #3C3C3C;
    }

    @media (max-width:1200px){
        .col-md-4 {
            width: 24.333333%;
        }
    }

    @media (max-width:768px){
        .col-lg-1 {
            width: 100%;
        }
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Balance (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Balance();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom:20px;">
        <div class="row">
            <?php foreach ($list_anio as $list) { ?>
                <div class="col-lg-1 col-md-4 col-sm-6 col-12 text-center">
                    <a id="btn_anio_<?php echo $list['nom_anio']; ?>" class="btn gris" onclick="Lista_Balance('<?php echo $list['nom_anio']; ?>');">
                        <?php echo $list['nom_anio']; ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <input type="hidden" id="anio_seleccionado" name="anio_seleccionado">

    <div class="container-fluid" style="margin-bottom:20px;">
        <div class="row">
            <div id="lista_balance" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#c_balances").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";

        Lista_Balance('<?php echo date('Y'); ?>');
    });

    function Lista_Balance(anio) {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        $('.gris').removeClass('btn_negro');
        $('#btn_anio_'+anio).addClass('btn_negro');

        $('#anio_seleccionado').val(anio);
        var url = "<?php echo site_url(); ?>BabyLeaders/Lista_Balance"; 

        $.ajax({
            url: url,
            type: 'POST',
            data: {'anio':anio},
            success: function(data) {
                $('#lista_balance').html(data);
            }
        });
    }

    function Excel_Balance(){
        var anio = $('#anio_seleccionado').val();
        window.location = "<?php echo site_url(); ?>BabyLeaders/Excel_Balance/"+anio;
    }

    function Excel_Balance_Boleta(anio,mes) {
        window.location = "<?php echo site_url(); ?>BabyLeaders/Excel_Balance_Boleta/"+anio+"/"+mes;
    }

    function Excel_Balance_Nota_Debito(anio,mes) {
        window.location = "<?php echo site_url(); ?>BabyLeaders/Excel_Balance_Nota_Debito/"+anio+"/"+mes;
    }

    function Excel_Balance_Nota_Credito(anio,mes) {
        window.location = "<?php echo site_url(); ?>BabyLeaders/Excel_Balance_Nota_Credito/"+anio+"/"+mes;
    }

    function Excel_Balance_Factura(anio,mes) {
        window.location = "<?php echo site_url(); ?>BabyLeaders/Excel_Balance_Factura/"+anio+"/"+mes;
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>