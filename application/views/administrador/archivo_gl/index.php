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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Archivo (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Archivo();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Archivo(1);" id="btn_alumnos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Alumnos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Archivo(2);" id="btn_colaboradores" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Colaboradores</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Archivo_Postulante(3);" id="btn_postulantes" style="color: #000000; background-color: #76b5c5;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Postulantes</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
            <input type="hidden" id="tipo_lista" name="tipo_lista">
        </div>

        <div class="row">
            <div id="lista_archivo" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#archivos").addClass('active');
        $("#harchivos").attr('aria-expanded', 'true');
        $("#archivos_lista").addClass('active');
        document.getElementById("rarchivos").style.display = "block";

        Lista_Archivo(1);
    });

    function Lista_Archivo(tipo) {
        Cargando();

        var url = "<?php echo site_url(); ?>Administrador/Lista_Archivo";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'tipo': tipo
            },
            success: function(resp) {
                $('#lista_archivo').html(resp);
                $("#tipo_excel").val(tipo);
                $("#tipo_lista").val(tipo);
            }
        });

        var alumnos = document.getElementById('btn_alumnos');
        var colaboradores = document.getElementById('btn_colaboradores');
        var postulantes = document.getElementById('btn_postulantes');
        if (tipo == 1) {
            alumnos.style.color = '#ffffff';
            colaboradores.style.color = '#000000';
            postulantes.style.color = '#000000';
        } else if (tipo == 2) {
            alumnos.style.color = '#000000';
            colaboradores.style.color = '#ffffff';
            postulantes.style.color = '#000000';
        } else if (tipo == 3) {
            alumnos.style.color = '#000000';
            colaboradores.style.color = '#000000';
            postulantes.style.color = '#ffffff';
        }
    }

    function Lista_Archivo_Postulante(tipo) {
        Cargando();

        var url = "<?php echo site_url(); ?>Administrador/Lista_Archivo_Postulante";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'tipo': tipo
            },
            success: function(resp) {
                $('#lista_archivo').html(resp);
                $("#tipo_excel").val(tipo);
                $("#tipo_lista").val(tipo);
            }
        });

        var alumnos = document.getElementById('btn_alumnos');
        var colaboradores = document.getElementById('btn_colaboradores');
        var postulantes = document.getElementById('btn_postulantes');
        if (tipo == 1) {
            alumnos.style.color = '#ffffff';
            colaboradores.style.color = '#000000';
            postulantes.style.color = '#000000';
        } else if (tipo == 2) {
            alumnos.style.color = '#000000';
            colaboradores.style.color = '#ffffff';
            postulantes.style.color = '#000000';
        } else {
            alumnos.style.color = '#000000';
            colaboradores.style.color = '#000000';
            postulantes.style.color = '#ffffff';
        }
    }

    function Validar_Archivo(id, archivo) {
        Cargando();

        var url = "<?php echo site_url(); ?>Administrador/Validar_Archivo";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_detalle': id,
                'archivo': archivo
            },
            success: function() {
                Lista_Archivo($("#tipo_lista").val());
            }
        });
    }

    function Validar_Archivo_Postulante(id, id_detalle, archivo) {
        Cargando();

        var url = "<?php echo site_url(); ?>Administrador/Validar_Archivo_Postulante";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_postulante': id,
                'id_detalle': id_detalle,
                'archivo': archivo
            },
            success: function(data) {
                Lista_Archivo_Postulante($("#tipo_lista").val());
            }
        });
    }

    function Excel_Archivo() {
        var tipo = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Archivo/" + tipo;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>