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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Producto (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85 || 
                        $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                            <a title="Nuevo" style="cursor:pointer;margin-right:5px;" href="<?= site_url('AppIFV/Registrar_Producto_Venta') ?>">
                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo" />
                            </a>
                        <?php } ?>

                        <a onclick="Excel_Producto_Venta();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Producto_Venta(1);" id="matriculados_btn" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Producto_Venta(2);" id="todos_btn" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" name="tipo" id="tipo" value="">
        </div>
        <div class="row">
            <div id="lista_producto_venta" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
        $("#conf_ventas").addClass('active');
        $("#hconf_ventas").attr('aria-expanded', 'true');
        $("#v_productos").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";
        document.getElementById("rconf_ventas").style.display = "block";

        Lista_Producto_Venta(1);
    });

    function Lista_Producto_Venta(t){
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Producto_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':t},
            success:function (resp) {
                const button = document.querySelector('#matriculados_btn');
                const button2 = document.querySelector('#todos_btn');
                $('#lista_producto_venta').html(resp);
                $('#tipo').val(t);
                if(t==2){
                    button.style.color = '#000000';
                    button2.style.color = '#ffffff';
                }else{
                    button.style.color = '#ffffff';
                    button2.style.color = '#000000';
                }
            }
        });
    }

    function Delete_Producto_Venta(id){ 
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Producto_Venta";
        
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_producto':id},
                    success:function () {
                        Lista_Producto_Venta();
                    }
                });
            }
        })
    }

    function Excel_Producto_Venta() {
        var tipo=$('#tipo').val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Producto_Venta/"+tipo;
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>