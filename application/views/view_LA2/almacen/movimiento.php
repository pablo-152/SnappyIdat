<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA2/header'); ?>
<?php $this->load->view('view_LA2/nav'); ?> 
 
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo "(".$get_producto[0]['codigo'].") ".$get_producto[0]['descripcion']." - ".$get_producto[0]['talla']; ?></b></span></h4>
                </div> 

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('Laleli2/Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>

                        <a href="<?= site_url('Laleli2/Excel_Movimiento_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>/<?php echo str_replace('-','_',$get_producto[0]['codigo']); ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <input type="hidden" id="id_almacen" value="<?php echo $get_id[0]['id_almacen']; ?>">
            <input type="hidden" id="cod_producto" value="<?php echo $get_producto[0]['codigo']; ?>">
            <div id="lista_movimiento_almacen" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#almacen").addClass('active');
        $("#halmacen").attr('aria-expanded', 'true');
        $("#a_listas_almacenes").addClass('active');
		document.getElementById("ralmacen").style.display = "block";

        Lista_Movimiento_Almacen();
    });

    function Lista_Movimiento_Almacen(){
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

        var url="<?php echo site_url(); ?>Laleli2/Lista_Movimiento_Almacen";
        var id_almacen = $("#id_almacen").val();
        var cod_producto = $("#cod_producto").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_almacen':id_almacen,'cod_producto':cod_producto},
            success:function (resp) {
                $('#lista_movimiento_almacen').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('view_LA2/footer'); ?>