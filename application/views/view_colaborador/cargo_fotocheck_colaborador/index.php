<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view($vista.'/header'); ?>
<?php $this->load->view($vista.'/nav'); ?>

<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cargo Fotocheck (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('Colaborador/Modal_Insert_Cargo_Fotocheck_Colaborador')?>/<?= $get_id[0]['id_sede']; ?>" 
                        style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a onclick="Excel_Cargos_Fotocheck_Colaborador();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <div class="row">
            <div id="lista_cargo_fotocheck_colaborador" class="col-lg-12"> 
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded','true');
        $("#cargos_fotocheck").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";

        Lista_Cargo_Fotocheck_Colaborador();
    });

    function Lista_Cargo_Fotocheck_Colaborador(){
        Cargando();
        var id_sede = <?= $get_id[0]['id_sede']; ?>;
        var url="<?php echo site_url(); ?>Colaborador/Lista_Cargo_Fotocheck_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_sede':id_sede},
            success:function (resp) {
                $('#lista_cargo_fotocheck_colaborador').html(resp);
            }
        });
    }

    function Delete_Cargo_Fotocheck_Colaborador(id){
        Cargando();
        
        var url="<?php echo site_url(); ?>Colaborador/Delete_Cargo_Fotocheck_Colaborador";

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
                    data: {'id_cf':id},
                    success:function () {
                        Lista_Cargo_Fotocheck_Colaborador();
                    }
                });
            }
        })
    }

    function Excel_Cargos_Fotocheck_Colaborador(){ 
        var id_sede = <?= $get_id[0]['id_sede']; ?>;
        window.location = "<?php echo site_url(); ?>Colaborador/Excel_Cargos_Fotocheck_Colaborador/"+id_sede;
    }
</script>

<?php $this->load->view($vista.'/footer'); ?>