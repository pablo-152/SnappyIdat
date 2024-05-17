<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style type="text/css">
    .boton {
        color: #fff;
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .boton:hover{
        color: #fff;
    }

    #activos{
        background: #C00000;
    }

    #terminados{
        background: #0070C0;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Gastos SUNAT (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" onclick="Excel_Gastos_Sunat();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-bottom: 15px;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="text-bold" for="id_status" >Año:</label>
                <div class="col">
                    <select name="anio_combo" id="anio_combo" class="form-control" onchange="Lista_Gastos_Sunat(1)">
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['nom_anio'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="heading-btn-group">
            <a onclick="Lista_Gastos_Sunat(1);" id="pendientes" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Gastos_Sunat(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_gastos" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#gastossunat").addClass('active');
        $("#hgastossunat").attr('aria-expanded', 'true');
        $("#gastos_sunat").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";
        document.getElementById("rgastossunat").style.display = "block";

        Lista_Gastos_Sunat(1);
    });

    function Lista_Gastos_Sunat(tipo){
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

        var url = "<?php echo site_url(); ?>Administrador/Lista_Gastos_Sunat"; 
        var anio = $('#anio_combo').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'tipo':tipo,'anio':anio},
            success: function(resp){
                $('#lista_gastos').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var pendientes = document.getElementById('pendientes');
        var todos = document.getElementById('todos');
        if(tipo==1){
            pendientes.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            pendientes.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Excel_Gastos_Sunat() {
        var tipo_excel=$('#tipo_excel').val();
        var anio = $('#anio_combo').val();
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Gastos_Sunat/"+tipo_excel+"/"+anio;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>