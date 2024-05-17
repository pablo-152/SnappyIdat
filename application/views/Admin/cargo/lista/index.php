<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cargos (Lista)</b></span></h4>
                </div>
 
                <div class="heading-elements"> 
                    <div class="heading-btn-group">
                        <a title="Nuevo Usuario" style="cursor:pointer;margin-right:5px;" href="<?= site_url('Snappy/Agregar_Cargo') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a onclick="Excel_Cargo();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Cargo(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Cargo(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_cargo" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded', 'true');
        $("#slista").addClass('active');
        document.getElementById("rcargo").style.display = "block";

        Lista_Cargo(1);
    });

    function Lista_Cargo(tipo){
        Cargando();

        var url = "<?php echo site_url(); ?>Snappy/Lista_Cargo";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'tipo':tipo},
            success: function(resp){
                $('#lista_cargo').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Delete_Cargo(id){ 
        Cargando();

        var url="<?php echo site_url(); ?>Snappy/Delete_Cargo";
        
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
                    data: {'id_cargo':id},
                    success:function () {
                        Lista_Cargo(1);
                    }
                });
            }
        })
    }

    function Excel_Cargo() {
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>Snappy/Excel_Cargo/"+tipo_excel;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>