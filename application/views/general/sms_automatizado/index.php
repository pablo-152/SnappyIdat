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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
                    <span class="text-semibold"><b>SMS Automatizado (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('General/Modal_Sms_Automatizado') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>
                        <a href="<?= site_url('General/Excel_Sms_Automatizado') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="row">
            <div id="lista_sms_automatizado" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#sms_automatizados").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        Lista_Sms_Automatizado();
    });

    function Lista_Sms_Automatizado(){
        Cargando();

        var url="<?php echo site_url(); ?>General/Lista_Sms_Automatizado";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_sms_automatizado').html(resp);
            }
        });
    }

    function Delete_Sms_Automatizado(id){
        Cargando();

        var url="<?php echo site_url(); ?>General/Delete_Sms_Automatizado";
        
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
                    data: {'id_sms':id},
                    success:function () {
                        Lista_Producto_Interes();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('general/footer'); ?>