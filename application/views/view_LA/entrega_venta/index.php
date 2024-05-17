<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA/header'); ?>
<?php $this->load->view('view_LA/nav'); ?> 

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Entregas (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Entrega_Venta();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Entrega_Venta(1);" id="pendientes" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Entrega_Venta(2);" id="listos" style="color: #000000;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Listos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Entrega_Venta(3);" id="entregados" style="color: #ffffff; background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span style="color: #ffffff;">Entregados</span><i style="color: #ffffff;" class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_entrega_venta" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#venta").addClass('active');
        $("#hventa").attr('aria-expanded', 'true');
        $("#v_entregas").addClass('active');
		document.getElementById("rventa").style.display = "block";

        Lista_Entrega_Venta(1);
    });

    function Lista_Entrega_Venta(tipo){
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

        var url="<?php echo site_url(); ?>Laleli/Lista_Entrega_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (resp) {
                $('#lista_entrega_venta').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var pendientes = document.getElementById('pendientes');
        var listos = document.getElementById('listos');
        var entregados = document.getElementById('entregados');
        if(tipo==1){
            pendientes.style.color = '#ffffff';
            listos.style.color = '#000000';
            entregados.style.color = '#000000';
        }else if(tipo==2){
            pendientes.style.color = '#000000';
            listos.style.color = '#ffffff';
            entregados.style.color = '#000000';
        }else{
            pendientes.style.color = '#000000';
            listos.style.color = '#000000';
            entregados.style.color = '#ffffff';
        }
    }

    function Update_Venta_Lista(id){
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

        var url="<?php echo site_url(); ?>Laleli/Update_Venta_Lista";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_venta':id},
            success:function (resp) {
                Lista_Entrega_Venta(1);
            }
        });
    }

    function Excel_Entrega_Venta() {
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>Laleli/Excel_Entrega_Venta/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_LA/footer'); ?>