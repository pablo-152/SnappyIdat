<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_CA/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Despesas (Informe)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Informe_Despesa();">
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
                        <label class="text-bold">Año:</label>
                        <div class="col">
                            <select class="form-control" name="nom_anio" id="nom_anio">
                                <?php foreach($list_anio as $list){ ?>
                                    <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>>
                                        <?php echo $list['nom_anio'];?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2 mb-3">
                        <label class="text-bold">&nbsp;</label>
                        <button type="button" class="form-control btn btn-primary" onclick="Consulta();" style="background-color: #9c8f9e;border-color: #9c8f9e;">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_informe_despesa" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#despesas").addClass('active');
        $("#hdespesas").attr('aria-expanded', 'true');
        $("#informe_despesas").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";
        document.getElementById("rdespesas").style.display = "block";
    });

    function Consulta(){
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

        var nom_anio = $("#nom_anio").val();
        var url = "<?php echo site_url(); ?>Ca/Lista_Informe_Despesa";

        $.ajax({
            type: "POST",
            url: url,
            data: {'nom_anio':nom_anio},
            success:function (data) {
                $('#lista_informe_despesa').html(data);
            }
        });
    }

    function Excel_Informe_Despesa(){
        var nom_anio = $("#nom_anio").val();
        window.location ="<?php echo site_url(); ?>Ca/Excel_Informe_Despesa/"+nom_anio;
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>