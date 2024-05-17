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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Pagos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('AppIFV/Pagos') ?>" style="margin-right:5px;">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>

                        <a onclick="Excel_Detalle_Pagos();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="heading-btn-group">
            <?php if($_SESSION['usuario'][0]['id_nivel']==12 || $_SESSION['usuario'][0]['id_nivel']==15){ ?>
                <?php if($get_id[0]['cancelado']==1){ ?>
                    <a onclick="Lista_Detalle_Pagos(1);" id="cancelados" style="background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Cancelados</span><i class="icon-arrow-down52"></i></a>
                <?php } ?>
            <?php }else{ ?>
                <a onclick="Lista_Detalle_Pagos(1);" id="cancelados" style="background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Cancelados</span><i class="icon-arrow-down52"></i></a>
            <?php } ?>
            <a onclick="Lista_Detalle_Pagos(2);" id="vencidos" style="background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Vencidos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Detalle_Pagos(3);" id="pendientes" style="background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Pendientes</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Lista_Detalle_Pagos(4);" id="todos" style="background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
        </div>

        <div class="row">
            <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['Id']; ?>">
            <input type="hidden" id="tipo_excel" name="tipo_excel">
            <input type="hidden" id="nivel_tabla" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>">
            <input type="hidden" id="cancelado_tabla" value="<?php echo $get_id[0]['cancelado']; ?>">
            <div id="lista_detalle_pagos" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informes").addClass('active');
        $("#hinformes").attr('aria-expanded', 'true');
        $("#pagos").addClass('active');
		document.getElementById("rinformes").style.display = "block";

        Lista_Detalle_Pagos(2);
    });

    function Lista_Detalle_Pagos(tipo){
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

        var url = "<?php echo site_url(); ?>AppIFV/Lista_Detalle_Pagos";
        var id_producto = $("#id_producto").val();
    
        $.ajax({
            url: url,
            type: 'POST',
            data: {'tipo':tipo,'id_producto':id_producto},
            success: function(resp){
                $('#lista_detalle_pagos').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var nivel = $("#nivel_tabla").val();
        var cancelado = $("#cancelado_tabla").val();

        if(nivel==12 || nivel==15){
            if(cancelado==1){
                var cancelados = document.getElementById('cancelados');
                var vencidos = document.getElementById('vencidos');
                var pendientes = document.getElementById('pendientes');
                var todos = document.getElementById('todos');
                if(tipo==1){
                    cancelados.style.color = '#ffffff';
                    vencidos.style.color = '#000000';
                    pendientes.style.color = '#000000';
                    todos.style.color = '#000000';
                }else if(tipo==2){
                    cancelados.style.color = '#000000';
                    vencidos.style.color = '#ffffff';
                    pendientes.style.color = '#000000';
                    todos.style.color = '#000000';
                }else if(tipo==3){
                    cancelados.style.color = '#000000';
                    vencidos.style.color = '#000000';
                    pendientes.style.color = '#ffffff';
                    todos.style.color = '#000000';
                }else{
                    cancelados.style.color = '#000000';
                    vencidos.style.color = '#000000';
                    pendientes.style.color = '#000000';
                    todos.style.color = '#ffffff';
                }
            }else{
                var vencidos = document.getElementById('vencidos');
                var pendientes = document.getElementById('pendientes');
                var todos = document.getElementById('todos');
                if(tipo==2){
                    vencidos.style.color = '#ffffff';
                    pendientes.style.color = '#000000';
                    todos.style.color = '#000000';
                }else if(tipo==3){
                    vencidos.style.color = '#000000';
                    pendientes.style.color = '#ffffff';
                    todos.style.color = '#000000';
                }else{
                    vencidos.style.color = '#000000';
                    pendientes.style.color = '#000000';
                    todos.style.color = '#ffffff';
                }
            }
        }else{
            var cancelados = document.getElementById('cancelados');
            var vencidos = document.getElementById('vencidos');
            var pendientes = document.getElementById('pendientes');
            var todos = document.getElementById('todos');
            if(tipo==1){
                cancelados.style.color = '#ffffff';
                vencidos.style.color = '#000000';
                pendientes.style.color = '#000000';
                todos.style.color = '#000000';
            }else if(tipo==2){
                cancelados.style.color = '#000000';
                vencidos.style.color = '#ffffff';
                pendientes.style.color = '#000000';
                todos.style.color = '#000000';
            }else if(tipo==3){
                cancelados.style.color = '#000000';
                vencidos.style.color = '#000000';
                pendientes.style.color = '#ffffff';
                todos.style.color = '#000000';
            }else{
                cancelados.style.color = '#000000';
                vencidos.style.color = '#000000';
                pendientes.style.color = '#000000';
                todos.style.color = '#ffffff';
            }
        }
    }

    function Excel_Detalle_Pagos() {
        var id_producto = $("#id_producto").val();
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Detalle_Pagos/"+tipo_excel+"/"+id_producto;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>