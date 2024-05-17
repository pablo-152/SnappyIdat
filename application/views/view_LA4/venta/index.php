<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA4/header'); ?>
<?php $this->load->view('view_LA4/nav'); ?>  
 
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Venta (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" href="<?= site_url('Laleli4/Nueva_Venta') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo" />
                        </a>

                        <a onclick="Excel_Venta();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_venta" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#venta").addClass('active');
        $("#hventa").attr('aria-expanded', 'true');
        $("#v_listas_ventas").addClass('active');
		document.getElementById("rventa").style.display = "block";

        Lista_Venta();
    });

    function Lista_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Lista_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_venta').html(resp);
            }
        });
    }

    function Excel_Venta() {
        window.location = "<?php echo site_url(); ?>Laleli4/Excel_Venta";
    }
</script>

<?php $this->load->view('view_LA4/footer'); ?>