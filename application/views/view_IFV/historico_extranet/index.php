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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Lista</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Historico_Extranet();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="text-bold">Fecha Inicio:</label>
                        <div class="col">
                            <input type="date" class="form-control" id="fec_inicio" name="fec_inicio" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Fecha Fin:</label>
                        <div class="col">
                            <input type="date" class="form-control" id="fec_fin" name="fec_fin" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold" style="color: transparent;">Fecha Inicio:</label>
                        <div class="col">
                            <button type="button" class="btn btn-primary" onclick="Lista_Historico_Extranet();">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_historico_extranet" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informes").addClass('active');
        $("#hinformes").attr('aria-expanded', 'true');
        $("#historicos_extranet").addClass('active');
		document.getElementById("rinformes").style.display = "block";

        Lista_Historico_Extranet();
    });

    /*function Lista_Historico_Extranet(){
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

        var fec_inicio = $("#fec_inicio").val();
        var fec_fin = $("#fec_fin").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Historico_Extranet";

        $.ajax({
            type:"POST",
            url:url,
            data:{'fec_inicio':fec_inicio,'fec_fin':fec_fin},
            success:function (resp) {
                $('#lista_historico_extranet').html(resp);
            }
        });
    }

    function Excel_Historico_Extranet(){
        var fec_inicio=$('#fec_inicio').val().split("-");
        var fec_inicio = fec_inicio[0]+fec_inicio[1]+fec_inicio[2]
        var fec_fin=$('#fec_fin').val().split("-");
        var fec_fin = fec_fin[0]+fec_fin[1]+fec_fin[2]
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Historico_Extranet/"+fec_inicio+"/"+fec_fin;
    }*/
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>