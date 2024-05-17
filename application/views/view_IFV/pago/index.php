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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Pagos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Pagos();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row" style="margin-bottom: 15px;"> 
            <?php foreach($list_grafico as $list){ ?>
                <div class="col-lg-2 col-xs-12">
                    <div class="small-box" style="color:#fff;background:<?php echo $list['color']; ?>">
                        <div class="inner" align="center">
                            <h3 style="font-size: 32px;">
                                <?php echo $list['cantidad']; ?>
                            </h3>
                            <h3 style="font-size: 25px;">
                                <?php echo "s./ ".number_format($list['monto'],2); ?>
                            </h3>
                            <br>
                        </div>
                        <center><a onclick="Excel_Grafico_Pagos('<?php echo $list['id_especialidad']; ?>');" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;"><?php echo $list['abreviatura']; ?> <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="heading-btn-group">
            <a onclick="Lista_Pagos(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Pagos(2);" id="matriculas_cuotas" style="color: #ffffff;background-color: #7F7F7F;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Matriculas y Cuotas</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Pagos(3);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div> 

        <div class="row">
            <div id="lista_pagos" class="col-lg-12">
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

        Lista_Pagos(1);
    });

    function Lista_Pagos(tipo){
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

        var url = "<?php echo site_url(); ?>AppIFV/Lista_Pagos";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'tipo':tipo},
            success: function(resp){
                $('#lista_pagos').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var activos = document.getElementById('activos');
        var matriculas_cuotas = document.getElementById('matriculas_cuotas');
        var todos = document.getElementById('todos');
        if(tipo==1){
            activos.style.color = '#ffffff';
            matriculas_cuotas.style.color = '#000000';
            todos.style.color = '#000000';
        }else if(tipo==2){
            activos.style.color = '#000000';
            matriculas_cuotas.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            matriculas_cuotas.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Excel_Pagos() {
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Pagos/"+tipo_excel;
    }

    function Excel_Grafico_Pagos(id_especialidad) {
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Grafico_Pagos/"+id_especialidad; 
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>