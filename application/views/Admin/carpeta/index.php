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
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Carpetas (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('Snappy/Modal_Insert_Carpeta')?>" 
                        style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a onclick="Excel_Carpeta();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="row">
            <div id="lista_carpeta" class="col-lg-12"> 
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#configcomunicacion").addClass('active');
        $("#hconfigsoporteti").attr('aria-expanded', 'true');
        $("#carpeta").addClass('active');
		document.getElementById("rcomunicacion").style.display = "block";
        document.getElementById("rconfigcomunicacion").style.display = "block";

        Lista_Carpetas();
    });

    function Lista_Carpetas(){
        Cargando();
        var url="<?php echo site_url(); ?>Snappy/Lista_Carpetas";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_carpeta').html(resp);
            }
        });
    }

    function Delete_Carpeta(id){
        Cargando();
        
        var url="<?php echo site_url(); ?>Snappy/Delete_Carpeta";

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
                    data: {'id_carpeta':id},
                    success:function () {
                        Lista_Carpetas();
                    }
                });
            }
        })
    }

    function Excel_Carpeta(){ 
        window.location = "<?php echo site_url(); ?>Snappy/Excel_Carpeta/";
    }

    function permitirSoloNumeros(event) {
      // Obtén el código de la tecla presionada
      var charCode = (event.which) ? event.which : event.keyCode;

      // Permite solo dígitos (0-9)
      if (charCode < 48 || charCode > 57) {
        event.preventDefault();
      }
    }
</script>

<?php $this->load->view('Admin/footer'); ?>