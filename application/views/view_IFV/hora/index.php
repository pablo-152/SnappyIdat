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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Horarios (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_C_Hora') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_C_Hora') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" id="busqueda">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
        $("#hconfiguraciones").attr('aria-expanded', 'true');
        $("#c_hora").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";

        Lista_C_Hora();
    });
</script>

<script>
    function Lista_C_Hora(){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Lista_C_Hora";
        
        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                $('#busqueda').html(data);
            }
        });
    }

    function Delete_C_Hora(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_C_Hora";
        
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
                    data: {'id_hora':id},
                    success:function () {
                        Lista_C_Hora();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>