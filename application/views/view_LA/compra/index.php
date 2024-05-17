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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Compra (Lista)</b></span></h4>
                </div>
 
                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Compra();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_compra" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#compra").addClass('active');
        $("#hcompra").attr('aria-expanded', 'true');
        $("#c_listas_compras").addClass('active');
		document.getElementById("rcompra").style.display = "block";

        Lista_Compra();
    });

    function Lista_Compra(){
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

        var url="<?php echo site_url(); ?>Laleli/Lista_Compra";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_compra').html(resp);
            }
        });
    }

    function Excel_Compra() {
        window.location = "<?php echo site_url(); ?>Laleli/Excel_Compra";
    }
</script>

<?php $this->load->view('view_LA/footer'); ?>