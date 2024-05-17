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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Examenes de Prácticas EFSRT (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Examen_Efsrt_Ifv') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo">
                        </a>
                        <a style="cursor:pointer;margin-right:5px;" onclick="Duplicar_Examen_Efsrt();">
                            <img  src="<?= base_url() ?>template/img/copy.png" alt="Duplicar Examen">
                        </a>
                        <a href="javascript:void(0)" onclick="Excel_Examen_Efsrt()">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form  method="post" id="formulario_excel" enctype="multipart/form-data">
        <div class="container-fluid" style="margin-bottom: 15px;">
            <div class="row col-md-12 col-sm-12 col-xs-12">
                <a onclick="Lista_Examen_Efsrt(1);" id="activos_btn" style="background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i> </a>
                <a onclick="Lista_Examen_Efsrt(2);" id="todos_btn" style="background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                <input type="hidden" id="tipo_excel"> 
            </div>
        </div>
    </form>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="lista_postulante">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
		$("#hconfiguraciones").attr('aria-expanded', 'true');
		document.getElementById("rconfiguraciones").style.display = "block";
		$("#configuraciones_ifvonline").addClass('active');
		$("#hconfiguraciones_ifvonline").attr('aria-expanded', 'true');
		document.getElementById("rconfiguraciones_ifvonline").style.display = "block";
		$("#conf_ifv_examen").addClass('active');
        Lista_Examen_Efsrt(1);
    });

    function Duplicar_Examen_Efsrt(){
        var contador=0;
        var contadorf=0;
        var dataString = $("#formulario_examen_efsrt").serialize();
        var url = "<?php echo site_url(); ?>AppIFV/Duplicar_Examen_Efsrt";

        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
                contador++;
        });

        if(contador==1){
            Swal({
                title: 'Duplicar Examen',
                text: "¿Esta seguro de duplicar este examen?",
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
                        data:dataString,
                        success:function (data) {
                            swal.fire(
                                'Duplicado Exitoso!',
                                'Haga clic en el botón!',
                                'success'
                            ).then(function() {
                                //window.location = "<?php echo site_url(); ?>AppIFV/Examen_Efsrt";
                                Lista_Examen_Efsrt($('#tipo_excel').val())
                            });
                        }
                    }); 
                }
            })
        }else if(contador>1){
            Swal({
                title: 'Ups!',
                text: 'Debe seleccionar solo un Examen.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        }else{
            Swal({
                title: 'Ups!',
                text: 'Debe seleccionar Examen.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        }
    }

    function Lista_Examen_Efsrt(tipo) {
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Examen_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':tipo},
            success:function (data) {
                $('#lista_postulante').html(data);
                $("#tipo_excel").val(tipo);
            }
        });

        var activos = document.getElementById('activos_btn');
        var todos = document.getElementById('todos_btn');

        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }


    function Excel_Examen_Efsrt() {
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Examen_Efsrt/"+tipo_excel;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>
