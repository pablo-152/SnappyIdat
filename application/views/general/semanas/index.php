<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Semanas (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" 
                            app_crear_per="<?= site_url('General/Modal_Semanas') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="javascript:void(0)" onclick="Excel_Semana();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Semanas(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Semanas(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            
        </div>
        <div class="row">
            <div id="lista_semanas" class="col-lg-12">
                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#semanas").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        Lista_Semanas(1);
    });

    function Lista_Semanas(t){
        Cargando();

        var url="<?php echo site_url(); ?>General/Lista_Semanas/"+t;
        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_semanas').html(resp);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        if(t==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }
    
    function Insert_Semana(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_semana'));
        var url="<?php echo site_url(); ?>General/Insert_Semana";

        if (Valida_Semana('')) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso',
                            '',
                            'success'
                        ).then(function() {
                            Lista_Semanas();
                            $("#acceso_modal .close").click()
                        }); 
                    }
                }
            });
        }
    }

    function Valida_Semana(v) {
        if($('#anio'+v).val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_semana'+v).val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Semana.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_inicio'+v).val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_fin'+v).val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha de fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Update_Semana(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_semanae'));
        var url="<?php echo site_url(); ?>General/Update_Semana";

        if (Valida_Semana('e')) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa',
                            '',
                            'success'
                        ).then(function() {
                            Lista_Semanas();
                            $("#acceso_modal_mod .close").click()
                        });
                }
                }
            });
        }
    }

    function Delete_Semana(id){
        Cargando();

        var url="<?php echo site_url(); ?>General/Delete_Semana";

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
                    data: {'id_semanas':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Semanas();
                        });
                    }
                });
            }
        })
    }

    function Excel_Semana(){
        var t = $('#tipo_excel').val();
        window.location = "<?php echo site_url(); ?>General/Excel_Semana/"+t;
    }
</script>

<?php $this->load->view('general/footer'); ?>