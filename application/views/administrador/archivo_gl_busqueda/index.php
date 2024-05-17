<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Búsqueda (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Archivo_Busqueda();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="text-bold" for="id_status">Año:</label>
                        <div class="col">
                            <select name="anio" id="anio" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach ($list_anio as $list) { ?>
                                    <option value="<?php echo $list['nom_anio']; ?>" <?php if ($list['nom_anio'] == date('Y')) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $list['nom_anio']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold" for="id_status">Empresa:</label>
                        <div class="col">
                            <select name="id_empresa" id="id_empresa" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach ($list_empresas as $list) { ?>
                                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="text-bold" for="id_status">Tipo:</label>
                        <div class="col">
                            <select name="tipo" id="tipo" class="form-control" onchange="Cambiar_Anio()">
                                <option value="1">Alumnos</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Postulantes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12" id="busqueda_archivo">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>
<div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>
<div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#archivos").addClass('active');
        $("#harchivos").attr('aria-expanded', 'true');
        $("#archivos_busqueda").addClass('active');
        document.getElementById("rarchivos").style.display = "block";

        Cambiar_Anio();
    });

    function Cambiar_Anio() {
        Cargando();
        var anio = $('#anio').val();
        var id_empresa = $('#id_empresa').val();
        var tipo = $('#tipo').val();

        var url = "<?php echo site_url(); ?>Administrador/Buscador_Archivo";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'anio': anio,
                'id_empresa': id_empresa,
                    'tipo': tipo
            },
            success: function(data) {
                $('#busqueda_archivo').html(data);
            }
        });
    }

    function Excel_Archivo_Busqueda() {
    var ano = $("#anio").val();
    var id_empresa = $("#id_empresa").val();
    var tipo = $("#tipo").val();
    window.location = "<?php echo site_url(); ?>Administrador/Excel_Archivo_Busqueda/" + ano + "/" + id_empresa + "/" + tipo;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>