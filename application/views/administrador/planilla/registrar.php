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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Planilla <?= $get_sede[0]['cod_sede']; ?> (Nueva)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" href="<?= site_url('Administrador/Planilla') ?>/<?= $get_sede[0]['id_sede']; ?>" style="cursor:pointer;margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container-fluid">
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-lg-12 row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Mes: </label>
                    <select class="form-control" name="mes" id="mes" onchange="Lista_Colaborador();">
                        <?php foreach($list_mes as $list){ ?>
                            <option value="<?= $list['cod_mes']; ?>" <?php if($list['cod_mes']==date('m')){ echo "selected"; } ?>>
                                <?= $list['nom_mes']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Año: </label>
                    <select class="form-control" id="anio" name="anio" onchange="Lista_Colaborador();">
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?= $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>>
                                <?= $list['nom_anio']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div id="lista_colaborador" class="col-lg-12" style="overflow-x:auto;">
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="id_sede" name="id_sede" value="<?= $get_sede[0]['id_sede']; ?>">
                <!--<button type="button" class="btn btn-primary" onclick="Insert_Planilla();">
                    <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                </button>-->
                <a type="button" class="btn btn-default" href="<?= site_url('Administrador/Planilla') ?>/<?= $get_sede[0]['id_sede']; ?>">
                    <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                </a>
            </div>
        </form>
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

        Lista_Colaborador();
    });

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

    function solo_Numeros_Punto(e) {
        var key = event.which || event.keyCode;
        if ((key >= 48 && key <= 57) || key == 46) {
            if (key == 46 && event.target.value.indexOf('.') !== -1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function Lista_Colaborador(){
        Cargando();

        var id_sede = $("#id_sede").val();
        var mes = $("#mes").val();
        var anio = $("#anio").val();
        var url="<?php echo site_url(); ?>Administrador/Lista_Colaborador_Planilla";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_sede':id_sede,'mes':mes,'anio':anio},
            success:function (resp) {
                $('#lista_colaborador').html(resp);
            }
        });
    }

    function Insert_Planilla(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Administrador/Insert_Planilla";

        var id_sede = $('#id_sede').val();
        dataString.append('id_sede', id_sede);

        if (Valida_Insert_Planilla()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
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
                        Lista_Planilla();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Insert_Planilla() {
        if($('#mes').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Mes.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#anio').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>