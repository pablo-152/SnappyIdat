<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LS/header'); ?>
<?php $this->load->view('view_LS/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Registro Ingreso (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Registro_Ingreso();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!--aca   --> 
    <div class="form-group col-md-2">
        <label class="text-bold">Fecha Inicio:</label>
        <div class="col">
            <!--<input type="date" class="form-control" id="fec_in" name="fec_in" value="<?php echo date('Y-m-01'); ?>">-->
            <input type="date" class="form-control" id="fec_in" name="fec_in" value="<?php echo date('Y-m-d'); ?>"> 
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Fecha Fin:</label>
        <div class="col">
            <input type="date" class="form-control" id="fec_fi" name="fec_fi" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold" style="color: transparent;">Fecha Inicio:</label>
        <div class="col">
            <button type="button" class="btn btn-primary"  id="busqueda_lista_asistencia" onclick="Lista_Asistencia_Registro_Ingreso();">Buscar</button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div id="lista_registro_ingreso" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#asistencias").addClass('active');
        $("#hasistencias").attr('aria-expanded', 'true');
        $("#listas_asistencias").addClass('active');
        $("#busqueda_lista_asistencia").trigger("click");
		document.getElementById("rasistencias").style.display = "block";

        Lista_Asistencia_Registro_Ingreso();
    });

    function Lista_Asistencia_Registro_Ingreso(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#0074C8" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/intranetlogolsc.png"></div>',
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
                message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#0074C8" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/intranetlogolsc.png"></div>',
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

        var fec_in = $("#fec_in").val();
        var fec_fi = $("#fec_fi").val();
        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Asistencia_Registro_Ingreso";

        $.ajax({
            type:"POST",
            url:url,
            data:{'fec_in':fec_in,'fec_fi':fec_fi},
            success:function (resp) {
                $('#lista_registro_ingreso').html(resp);
            }
        });
    }

    function Excel_Registro_Ingreso(){
        var fec_in=$('#fec_in').val().split("-");
        var fec_in = fec_in[0]+fec_in[1]+fec_in[2]
        var fec_fi=$('#fec_fi').val().split("-");
        var fec_fi = fec_fi[0]+fec_fi[1]+fec_fi[2]
        window.location = "<?php echo site_url(); ?>LeadershipSchool/Excel_Registro_Ingreso/"+fec_in+"/"+fec_fi;
    }

    function Delete_Registro_Ingreso(id){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#0074C8" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/intranetlogolsc.png"></div>',
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
                message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#0074C8" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/intranetlogolsc.png"></div>',
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

        var url="<?php echo site_url(); ?>LeadershipSchool/Delete_Registro_Ingreso_Lista";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
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
                    data: {'id_registro_ingreso':id},
                    success:function () {
                        Lista_Asistencia_Registro_Ingreso();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('view_LS/footer'); ?>

