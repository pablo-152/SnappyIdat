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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Planilla <?= $get_sede[0]['cod_sede']; ?> (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" href="<?= site_url('Administrador/Registrar_Planilla') ?>/<?php echo $get_sede[0]['id_sede']; ?>" style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo" />
                        </a>

                        <a onclick="Excel_Planilla();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container-fluid">
        <div class="row">
            <input type="hidden" id="id_sede" value="<?= $get_sede[0]['id_sede']; ?>">
            <div id="lista_planilla" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#planilla_empresa").addClass('active');
        $("#hplanilla_empresa").attr('aria-expanded', 'true');
        $("#planillas_<?= strtolower($get_sede[0]['cod_sede']); ?>").addClass('active');
        document.getElementById("rplanilla_empresa").style.display = "block";
        document.getElementById("rcolaboradores").style.display = "block";

        Lista_Planilla();
    });

    function Lista_Planilla(){
        Cargando();

        var id_sede = $("#id_sede").val();
        var url="<?php echo site_url(); ?>Administrador/Lista_Planilla";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_sede':id_sede},
            success:function (resp) {
                $('#lista_planilla').html(resp);
            }
        });
    }

    function Delete_Planilla(id){
        Cargando();

        var url="<?php echo site_url(); ?>Administrador/Delete_Planilla";
        
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
                    data: {'id':id},
                    success:function () {
                        Lista_Planilla();
                    }
                });
            }
        })
    }

    function Excel_Planilla(){ 
        var id_sede = $("#id_sede").val();
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Planilla/"+id_sede;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>