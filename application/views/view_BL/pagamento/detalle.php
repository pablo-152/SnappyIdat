<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<style>
    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Pagos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('BabyLeaders/Pagamento') ?>" style="margin-right:5px;">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                        
                        <a onclick="Excel_Detalle_Pagamento();"> 
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Detalle_Pagamento(1);" id="cancelados_btn" style="background-color:#00C000;color: #000;" class="form-group btn clase_boton"><span>Cancelados</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Detalle_Pagamento(2);" id="pendientes_btn" style="background-color: #C00000;color: #000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['id_producto']; ?>">
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_detalle_pagamento" class="col-lg-12"> 
            </div>
        </div>
    </div>
</div> 

<script>
    $(document).ready(function() {
        $("#contabilidad_sunat").addClass('active');
        $("#hcontabilidad_sunat").attr('aria-expanded','true');
        $("#pagamentos").addClass('active');
		document.getElementById("rcontabilidad_sunat").style.display = "block";

        Lista_Detalle_Pagamento(1);
    });

    function Lista_Detalle_Pagamento(tipo){
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

        var id_producto = $("#id_producto").val();
        var url="<?php echo site_url(); ?>BabyLeaders/Lista_Detalle_Pagamento";

        $.ajax({
            type:"POST",
            url:url, 
            data:{'id_producto':id_producto,'tipo':tipo}, 
            success:function (resp) {
                $('#lista_detalle_pagamento').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var cancelados = document.getElementById('cancelados_btn');
        var pendientes = document.getElementById('pendientes_btn');

        if(tipo==1){
            cancelados.style.color = '#FFFFFF';
            pendientes.style.color = '#000000';
        }else{
            cancelados.style.color = '#000000';
            pendientes.style.color = '#FFFFFF';
        }
    }

    function Excel_Detalle_Pagamento(){ 
        var id_producto = $("#id_producto").val();
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>BabyLeaders/Excel_Detalle_Pagamento/"+id_producto+"/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>