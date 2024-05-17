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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Mailing (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Actualizar_Lista_Mailing();" style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/actualizar_lista.png">
                        </a>

                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('AppIFV/Modal_Mailing') ?>" 
                        style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_Mailing') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="row">
            <div id="lista_mailing" class="col-lg-12"> 
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
        $("#hconfiguraciones").attr('aria-expanded','true');
        $("#mailings").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";

        Lista_Mailing();
    });

    function Lista_Mailing(){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Lista_Mailing";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_mailing').html(resp);
            }
        });
    }

    function Actualizar_Lista_Mailing(id){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Actualizar_Lista_Mailing";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                Lista_Mailing();
            }
        });
    }

    function Delete_Mailing(id){
        Cargando();
        
        var url="<?php echo site_url(); ?>AppIFV/Delete_Mailing";

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
                    data: {'id_mailing':id},
                    success:function () {
                        Lista_Mailing();
                    }
                });
            }
        })
    }

    function Descargar_Mailing(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Mailing/"+id); 
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>