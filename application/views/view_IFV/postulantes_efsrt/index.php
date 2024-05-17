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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Examen Básico (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <!--<a title="Invitar" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Invitar_Efsrt') ?>">
                            <img src="<?= base_url() ?>template/img/invitar.png" alt="Invitar Postulante">
                        </a>-->
                        
                        <a onclick="Excel_Postulante_Efsrt();" style="cursor:pointer">
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
                <a onclick="Lista_Postulantes_Efsrt(1);" id="invitados_btn" style="background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Invitados</span><i class="icon-arrow-down52"></i></a>
                <a onclick="Lista_Postulantes_Efsrt(2);" id="concluidos_btn" style="background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Concluidos</span><i class="icon-arrow-down52"></i> </a>
                <a onclick="Lista_Postulantes_Efsrt(3);" id="todos_btn" style="background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                <input type="hidden" id="tipo_excel"> 
                <div>
                    <label for="" class="col-md-2" id="total_enviado"></label>
                    <label for="" class="col-md-2" id="total_concluidos"></label>
                    <label for="" class="col-md-2" id="total_pendientes"></label>    
                </div>
                

                <!--<a class="form-group btn">
                    <input class="form-group" name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]'  size="100" required >
                </a>

                <a class="form-group btn" href="<?= site_url('AppIFV/Excel_Vacio_Postulantes_Efsrt') ?>" title="Estructura de Excel" style="margin-right:10px;">
                    <img height="40px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel" />
                </a>

                <a class="btn btn-primary form-group" type="button" onclick="Insert_Postulantes_Efsrt();">Importar</a>
                <span role="alert" id="resultado" style="color:red;"></span>-->
            </div>
        </div>
    </form>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="lista_postulante" style="max-height:100%; overflow:auto;">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true');
        document.getElementById("rpracticas").style.display = "block";
        $("#informes_efsrt").addClass('active');
        $("#hinformes_efsrt").attr('aria-expanded', 'true');
        document.getElementById("rinformes_efsrt").style.display = "block";
        $("#postulantes_efsrt").addClass('active');

        Lista_Postulantes_Efsrt(1);
    });

    function Lista_Postulantes_Efsrt(tipo) {
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Lista_Postulantes_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':tipo},
            success:function (data) {
                $('#lista_postulante').html(data);
                $("#tipo_excel").val(tipo);
            }
        });

        var invitados = document.getElementById('invitados_btn');
        var concluidos = document.getElementById('concluidos_btn');
        var todos = document.getElementById('todos_btn');

        if(tipo==1){
            invitados.style.color = '#ffffff';
            concluidos.style.color = '#000000';
            todos.style.color = '#000000';
        }else if(tipo==2){
            invitados.style.color = '#000000';
            concluidos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else if(tipo==3){
            invitados.style.color = '#000000';
            concluidos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }


    function Excel_Postulante_Efsrt() {
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Postulante_Efsrt/"+tipo_excel;
    }

    function Reenviar_Envitacion(id_postulante){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Reenviar_Invitar_Postulantes_Efsrt"; 
        Swal({
            title: '¿Realmente desea reenviar invitación?',
            text: "",
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
                    data: {'id_postulante':id_postulante},
                    success:function (data) {
                        var cadena = data;
                        validacion = cadena.substr(0, 1);
                        mensaje = cadena.substr(1);
                        if (validacion == 1) {
                            swal.fire(
                                'Invitación Denegada',
                                mensaje,
                                'error'
                            ).then(function() {
                            });
                        }else if(validacion==2){
                            swal.fire(
                                'Invitación parcial!',
                                mensaje,
                                'warning'
                            ).then(function() {
                                $("#acceso_modal .close").click()
                                Lista_Postulantes_Efsrt(1);
                            });
                        }else if(validacion==3){
                            swal.fire(
                                'Invitación exitosa!',
                                mensaje,
                                'success'
                            ).then(function() {
                                $("#acceso_modal .close").click()
                                Lista_Postulantes_Efsrt(1);
                            });
                        }
                    }
                });
            }
        }) 
    }

    function Eliminar_Postulante_Efsrt(id_postulante){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Postulante_Efsrt"; 

        Swal({
            title: '¿Realmente desea eliminar postulante??',
            text: "",
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
                    data: {'id_postulante':id_postulante},
                    success:function (data) {
                        swal.fire(
                            'Eliminado!',
                            '',
                            'success'
                        ).then(function() {
                            Lista_Postulantes_Efsrt(1);
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

