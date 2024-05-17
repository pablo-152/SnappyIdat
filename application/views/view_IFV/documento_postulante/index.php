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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Documentos Postulantes (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo Documento" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Documento_Postulante') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_Documento_Post') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="row">
            <div id="lista_documento_postulante" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#configuraciones").addClass('active');
        $("#hconfiguraciones").attr('aria-expanded', 'true');
        $("#documentos_postulantes").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";

        Lista_Documento_Postulante();
    });

    function Lista_Documento_Postulante(){
        Cargando();


        
        var url="<?php echo site_url(); ?>AppIFV/Lista_Documento_Postulantes";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_documento_postulante').html(resp);
            }
        });
    }

    function Delete_Documento_Postulante(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Documento_Postulante";

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
                    data: {'id_documento':id},
                    success:function () {
                        Lista_Documento_Postulante();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>