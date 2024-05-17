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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Soporte Doc's (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" 
                            app_crear_per="<?= site_url('General/Modal_Soporte_Doc') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a onclick="Excel_Soporte_Doc();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Soporte_Doc(1);" id="btn_activos" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Soporte_Doc(2);" id="btn_todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_soporte_doc" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#soporte_docs").addClass('active');
        $("#hsoporte_docs").attr('aria-expanded','true');
        $("#soporte_docs_listas").addClass('active');
		document.getElementById("rsoporte_docs").style.display = "block";

        Lista_Soporte_Doc(1);
    });

    function Lista_Soporte_Doc(tipo){
        Cargando();

        var url="<?php echo site_url(); ?>General/Lista_Soporte_Doc";

        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo},
            success:function (resp) {
                $('#lista_soporte_doc').html(resp);
                $('#tipo_excel').val(tipo);
            }
        });

        var activos = document.getElementById('btn_activos');
        var todos = document.getElementById('btn_todos');
        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }
    
    function Delete_Soporte_Doc(id){
        Cargando();

        var url="<?php echo site_url(); ?>General/Delete_Soporte_Doc";

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
                    data: {'id_soporte_doc':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Soporte_Doc();
                        });
                    }
                });
            }
        })
    }

    function Excel_Soporte_Doc(){ 
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>General/Excel_Soporte_Doc/"+tipo_excel;
    }
</script>

<?php $this->load->view('general/footer'); ?>