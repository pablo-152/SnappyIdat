<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LL/header'); ?>
<?php $this->load->view('view_LL/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Pensiones Canceladas / Por Cancelar (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('LittleLeaders/Informe_Lista') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>

                        <a onclick="Excel_Lista_Informe();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="tipo_excel" value="1">

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Informe(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Informe(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
        </div>

        <div class="row">
            <div id="lista_informe" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informe").addClass('active');
        $("#hinforme").attr('aria-expanded','true');
        $("#listas").addClass('active');
		document.getElementById("rinforme").style.display = "block";

        Lista_Informe(1);
    });

    function Lista_Informe(tipo){
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var url="<?php echo site_url(); ?>LittleLeaders/Lista_Informe";
        
        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (data) {
                $('#lista_informe').html(data);   
                $('#tipo_excel').val(tipo);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        if(tipo==1){
            todos.style.color = '#000000';
            activos.style.color = '#ffffff';
        }else{
            todos.style.color = '#ffffff';
            activos.style.color = '#000000';
        }
    }

    function Excel_Lista_Informe(){
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>LittleLeaders/Excel_Lista_Informe/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_LL/footer'); ?>