<?php
$sesion =  $_SESSION['usuario'][0];
$id_usuario = $sesion['id_usuario'];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('view_LL/header'); ?>
<?php $this->load->view('view_LL/nav'); ?>

<style>
    .tabset>input[type="radio"] {
        position: absolute;
        left: -200vw;
    }

    .tabset .tab-panel {
        display: none;
    }

    .tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
    .tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
    .tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
    .tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
    .tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6),
    .tabset > input:nth-child(13):checked ~ .tab-panels > .tab-panel:nth-child(7),
    .tabset > input:nth-child(15):checked ~ .tab-panels > .tab-panel:nth-child(8),
    .tabset > input:nth-child(17):checked ~ .tab-panels > .tab-panel:nth-child(9),
    .tabset > input:nth-child(19):checked ~ .tab-panels > .tab-panel:nth-child(10),
    .tabset > input:nth-child(21):checked ~ .tab-panels > .tab-panel:nth-child(11){
        display: block;
    }

    .tabset>label {
        position: relative;
        display: inline-block;
        padding: 15px 15px 25px;
        border: 1px solid transparent;
        border-bottom: 0;
        cursor: pointer;
        font-weight: 600;
        background: #799dfd5c;
        width: 6.3%;
        max-width: 110px;
    }

    .tabset>label::after {
        content: "";
        position: absolute;
        left: 15px;
        bottom: 10px;
        width: 22px;
        height: 4px;
        background: #8d8d8d;
    }

    .tabset>label:hover,
    .tabset>input:focus+label {
        color: #06c;
    }

    .tabset>label:hover::after,
    .tabset>input:focus+label::after,
    .tabset>input:checked+label::after {
        background: #06c;
    }

    .tabset>input:checked+label {
        border-color: #ccc;
        border-bottom: 1px solid #fff;
        margin-bottom: -1px;
    }

    .tab-panel {
        padding: 30px 0;
        border-top: 1px solid #ccc;
    }

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    .tabset {
        margin: 8px 15px;
    }

    .contenedor1 {
        position: relative;
        height: 80px;
        width: 80px;
        float: left;
    }

    .contenedor1 img {
        position: absolute;
        left: 0;
        transition: opacity 0.3s ease-in-out;
        height: 80px;
        width: 80px;
    }

    .contenedor1 img.top:hover {
        opacity: 0;
        height: 80px;
        width: 80px;
    }

    table th {
        text-align: center;
    }

    .margintop {
        margin-top: 5px;
    }

    .clase_boton {
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .color_casilla {
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
        text-align: center;
    }

    .img_class {
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }

    .boton_exportable {
        margin: 0 0 10px 0;
    }

    .cabecera_pagos {
        margin: 5px 0 0 5px;
    }

    .color_casilla2 {
        border-color: #3db732 !important;
        color: #fff;
        background-color: #3db732 !important;
    }

    .color_casilla3 {
        border-color: #fe0001 !important;
        color: #fff;
        background-color: #fe0001 !important;
    }

    .color_casilla4 {
        border-color: #0170c1 !important;
        color: #fff;
        background-color: #0170c1 !important;
    }
</style>

<?php
$foto = "";
if (count($get_foto) > 0) {
    if ($get_foto[0]['archivo'] != "") {
        $foto = $get_foto[0]['archivo'];
        $array_foto = explode("/", $foto);
        $nombre_foto = $array_foto[3];
    }
}
?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <?php if ($foto != "") { ?>
                        <a onclick="Descargar_Foto_Matriculados('<?php echo $get_foto[0]['id_detalle']; ?>');"><img class="img_class" src="<?php echo base_url() . $get_foto[0]['archivo']; ?>"></a>
                    <?php } ?>
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('LittleLeaders/Modal_Update_Sexo') ?>/<?php echo $get_id[0]['Id']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/editar_grande.png">
                        </a>

                        <a title="Adicionar Tutor" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('LittleLeaders/Modal_Tutor') ?>/<?php echo $get_id[0]['Id']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/adicionar_tutor.png">
                        </a>

                        <a type="button" href="<?= site_url('LittleLeaders/Matriculados') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $fec_de = new DateTime($get_id[0]['Fecha_Cumpleanos']);
    $fec_hasta = new DateTime(date('Y-m-d'));
    $diff = $fec_de->diff($fec_hasta);
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Código&nbsp;Arpay:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Codigo']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Estado:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Alumno']; ?>">
                </div>

                <div class="form-group col-md-3">
                </div>

                <div class="form-group col-md-1">
                    <input type="text" class="form-control color_casilla <?php if ($get_id[0]['Matricula'] == 'Asistiendo') {
                                                                                echo 'color_casilla2';
                                                                            }elseif ($get_id[0]['Matricula'] == 'Retirado(a)') {
                                                                                echo 'color_casilla3';
                                                                            }if ($get_id[0]['Matricula'] == 'Sin Matricular') {
                                                                                echo 'color_casilla4';
                                                                            }; ?>" disabled value="<?php echo $get_id[0]['Matricula']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Año&nbsp;Matrícula:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Anio']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Celular:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Celular']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Ap.&nbsp;Paterno: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" style="background:#fbe5d6; border: 0px solid transparent;" disabled value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Ap.&nbsp;Materno: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" style="background:#fbe5d6; border: 0px solid transparent;" disabled value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Nombres: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" style="background:#fbe5d6; border: 0px solid transparent;" disabled value="<?php echo $get_id[0]['Nombre']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Grado: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grado']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Sección: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Seccion']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Turno: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['descripcion_grado']; 
                                                                            ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">DNI:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Dni']; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked>
                <label for="tab1">Detalles</label>

                <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" onclick="Lista_Ingreso()">
                <label for="tab2">Ingresos</label>

                <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Documentos()">
                <label for="tab3">Doc.</label>

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" onclick="Lista_Contratos()">
                <label for="tab4">Contratos</label>

                <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="Lista_Pagos(2)">
                <label for="tab5">Pagos</label>

                <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6" onclick="Lista_Mensajes()">
                <label for="tab6">Mensajes</label>

                <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7" onclick="Lista_Sms()">
                <label for="tab7">SMS</label>

                <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8" onclick="Lista_Observacion()">
                <label for="tab8">Obs.</label>

                <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $get_id[0]['Id']; ?>">
                <input type="hidden" id="grado_actual" name="grado_actual" value="<?php echo $get_id[0]['Grado']; ?>">

                <div class="tab-panels">
                    <!-- DETALLE -->
                    <section id="rauchbier1" class="tab-panel">
                        <div class="box-body table-responsive">
                            <div class="panel panel-flat content-group-lg">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><b>Detalles</b></h5>
                                    <div class="heading-elements">
                                        <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                            <li><a data-action="reload"></a></li>
                                            <li><a data-action="close"></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1">
                                            <label class="control-label text-bold">Fecha Nac.:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Cumpleanos']; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class="control-label text-bold">Edad:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $diff->y; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class=" control-label text-bold">Sexo:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_sexo']; ?>" <?php if ($get_id[0]['nom_sexo'] == "") {
                                                                                                                                                echo "style='border-color:#FBE5D6;background-color: #FBE5D6 !important;'";
                                                                                                                                            } ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php $i = 1;
                            foreach ($list_tutor as $list) { ?>
                                <div class="panel panel-flat content-group-lg">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <b>Tutor <?php echo $i; ?></b>
                                            <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('LittleLeaders/Modal_Update_Tutor') ?>/<?php echo $list['id_tutor']; ?>">
                                                <img src="<?= base_url() ?>template/img/editar.png">
                                            </a>
                                            <a title="Eliminar" onclick="Delete_Tutor('<?php echo $list['id_tutor']; ?>')">
                                                <img src="<?= base_url() ?>template/img/eliminar.png">
                                            </a>
                                        </h5>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                                <li><a data-action="reload"></a></li>
                                                <li><a data-action="close"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body" style="padding-bottom:0px;">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-2">
                                                <input type="text" class="form-control" disabled value="<?php echo $list['nom_parentesco']; ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" disabled value="<?php echo $list['nom_tutor']; ?>">
                                            </div>

                                            <div class="form-group col-md-1">
                                                <label class="control-label text-bold">Celular:</label>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" class="form-control" disabled value="<?php echo $list['celular']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-1">
                                                <label class="control-label text-bold">Correo:</label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" class="form-control" disabled value="<?php echo $list['email']; ?>">
                                            </div>

                                            <div class="form-group col-md-1">
                                                <label class="control-label text-bold">No&nbsp;mailing:</label>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <input type="checkbox" disabled <?php if ($list['no_mailing'] == 1) {
                                                                                    echo "checked";
                                                                                } ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++;
                            } ?>
                        </div>
                    </section>

                    <!-- INGRESOS -->
                    <section id="rauchbier2" class="tab-panel">
                        <div class="tabset">
                            <?php foreach ($list_modulo as $list) { ?>
                                <input type="radio" name="modulo" id="modulo<?php echo $list['modulo'] ?>" style="max-height: 50px !important;" value="<?php echo $list['modulo'] ?>" onclick="Lista_Ingreso()" checked>
                                <label class="label2" for="modulo<?php echo $list['modulo'] ?>"><?php echo $list['modulo'] ?></label>
                            <?php  } ?>
                            <div class="boton_exportable" style="display: inline-block !important;">
                                <a title="Excel" onclick="Excel_Modulo();">
                                    <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                                </a>
                            </div>
                            <div style="display: inline-block !important;float: right;">
                                <label for="" id="rango_fec_modulo"></label>
                            </div>

                            <div style=" display: inline-flex; float: right; padding-right: 50px; padding-top: 2px;">
                                <label for="" id="dias_clases_modulo"></label>
                            </div>
                            
                        </div>
                        <div class="modal-content">
                            <div id="lista_ingreso" class="tabset">
                            </div>
                        </div>
                    </section>

                    <!-- DOCUMENTOS -->
                    <section id="rauchbier3" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" href="<?= site_url('LittleLeaders/Excel_Documento_Alumno') ?>/<?php echo $get_id[0]['Id']; ?>">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div class="modal-content">
                            <div id="lista_documentos">
                            </div>
                        </div>
                    </section>

                    
                    <!-- CONTRATOS -->
                    <section id="rauchbier4" class="tab-panel">
                        <div class="modal-content">
                            <div id="lista_contratos">
                            </div>
                        </div>
                    </section>

                    <!-- PAGOS -->
                    <section id="rauchbier5" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Pago_Matriculados();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div class="modal-content">
                            <div class="heading-btn-group cabecera_pagos">
                                <a onclick="Lista_Pagos(2);" id="pendientes" style="color:#ffffff;background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
                                <a onclick="Lista_Pagos(1);" id="todos" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                                <input type="hidden" id="tipo_excel" value="2">
                            </div>

                            <div id="lista_pagos">
                            </div>
                        </div>
                    </section>

                    <!-- MENSAJES -->
                    <section id="rauchbier6" class="tab-panel">
                        <div class="modal-content">
                            <div id="lista_mensajes">
                            </div>
                        </div>
                    </section>

                    <!-- SMS -->
                    <section id="rauchbier7" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" href="<?= site_url('LittleLeaders/Excel_Sms_Alumno') ?>/<?php echo $get_id[0]['Id']; ?>">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div class="modal-content">
                            <div id="lista_sms">
                            </div>
                        </div>
                    </section>

                    <!-- OBSERVACIONES -->
                    <section id="rauchbier8" class="tab-panel">
                        <form id="formulario_obs" method="POST" enctype="multipart/form-data" class="formulario">
                            <div id="div_accion_obs">
                            </div>
                        </form>

                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Observacion();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div id="lista_observacion">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        Cargando();
        $("#alumnos").addClass('active');
        $("#halumnos").attr('aria-expanded', 'true');
        $("#matriculados").addClass('active');
        document.getElementById("ralumnos").style.display = "block";
    });

    function Descargar_Foto_Matriculados(id) {
        Cargando();
        window.location.replace("<?php echo site_url(); ?>LittleLeaders/Descargar_Foto_Matriculados/" + id);
    }

    function Delete_Tutor(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>LittleLeaders/Delete_Tutor";

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El regitro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'id_tutor': id
                    },
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        })
    }

    function Lista_Documentos() {
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Lista_Documento_Matriculados";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno
            },
            success: function(data) {
                $('#lista_documentos').html(data);
            }
        });
    }

    function Delete_Documento_Alumno(id_detalle) {
        Cargando();

        var url = "<?php echo site_url(); ?>LittleLeaders/Delete_Documento_Alumno";

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
                    type: "POST",
                    url: url,
                    data: {
                        'id_detalle': id_detalle
                    },
                    success: function(data) {
                        Lista_Documentos();
                    }
                });
            }
        })
    }

    function Lista_Pagos(estado) {
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Lista_Pago_Matriculados";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno,
                'estado': estado
            },
            success: function(data) {
                $('#lista_pagos').html(data);
                $('#tipo_excel').val(estado);
            }
        });

        var pendientes = document.getElementById('pendientes');
        var todos = document.getElementById('todos');

        if (estado == 1) {
            pendientes.style.color = '#000000';
            todos.style.color = '#FFFFFF';
        } else {
            pendientes.style.color = '#FFFFFF';
            todos.style.color = '#000000';
        }
    }

    function Excel_Pago_Matriculados() {
        Cargando();
        var id_alumno = $('#id_alumno').val();
        var tipo_excel = $('#tipo_excel').val();
        window.location = "<?php echo site_url(); ?>LittleLeaders/Excel_Pago_Matriculados/" + id_alumno + "/" + tipo_excel;
    }

    function Lista_Contratos() {
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Lista_Contrato_Matriculados";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno
            },
            success: function(data) {
                $('#lista_contratos').html(data);
            }
        });
    }

    function Lista_Mensajes() {
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Lista_Mensaje_Matriculados";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno
            },
            success: function(data) {
                $('#lista_mensajes').html(data);
            }
        });
    }

    function Lista_Sms() {
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Lista_Sms_Matriculados";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno
            },
            success: function(data) {
                $('#lista_sms').html(data);
            }
        });
    }

    function Lista_Observacion() {
        Cargando();
        var id_alumno = $("#id_alumno").val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Registrar_Observacion_Alumno";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno
            },
            success: function(data) {
                $('#div_accion_obs').html(data);
                Registrar_Observacion_Alumno(id_alumno);
            }
        });
    }

    function Registrar_Observacion_Alumno(id_alumno) {
        Cargando();

        var id_alumno = $("#id_alumno").val();
        var url = "<?php echo site_url(); ?>LittleLeaders/Lista_Observacion_Alumno";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_alumno': id_alumno
            },
            success: function(data) {
                $('#lista_observacion').html(data);
            }
        });
    }

    function Lista_Ingreso(){ 
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var modulo = document.querySelector('input[name=modulo]:checked').value;
        var url="<?php echo site_url(); ?>LittleLeaders/Lista_Ingreso_Matriculados";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_alumno':id_alumno,'modulo':modulo},
            success:function (data) {
                $('#lista_ingreso').html(data);
            }
        });
    }

    function Excel_Modulo(){
        Cargando();

        var id_alumno = $('#id_alumno').val();
        var modulo = document.querySelector('input[name=modulo]:checked').value;
        //console.log('valor', modulo);
        alert(id_alumno);
        alert(modulo);
        window.location ="<?php echo site_url(); ?>LittleLeaders/Excel_Modulo/"+id_alumno+"/"+modulo;
    }

    function Insert_Observacion_Alumno() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url = "<?php echo site_url(); ?>LittleLeaders/Insert_Observacion_Alumno";

        var id_alumno = $('#id_alumno').val();
        dataString.append('id_alumno', id_alumno);

        if (Valida_Observacion_Alumno()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        Registrar_Observacion_Alumno(id_alumno);
                        Lista_Observacion();
                    }
                }
            });
        }
    }

    function Valida_Observacion_Alumno() {
        if ($('#id_tipo_o').val() !== "0" || $('#observacion_o').val() !== "") {
            if ($('#id_tipo_o').val() == "0") {
                Swal(
                    'Ups!',
                    'Debe seleccionar Tipo',
                    'warning'
                ).then(function() {});
                return false;
            }

            if ($('#fecha_o').val().trim() == "") {
                Swal(
                    'Ups!',
                    'Debe ingresar Fecha',
                    'warning'
                ).then(function() {});
                return false;
            }

            if ($('#usuario_o').val() == "0") {
                Swal(
                    'Ups!',
                    'Debe seleccionar Usuario',
                    'warning'
                ).then(function() {});
                return false;
            }

            if ($('#observacion_o').val().trim() == "") {
                Swal(
                    'Ups!',
                    'Debe ingresar Comentario',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        return true;
    }

    function Editar_Observacion_Alumno(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>LittleLeaders/Editar_Observacion_Alumno";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_observacion': id
            },
            success: function(data) {
                $('#div_accion_obs').html(data);
            }
        });
    }

    function Update_Observacion_Alumno() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url = "<?php echo site_url(); ?>LittleLeaders/Update_Observacion_Alumno";

        var id_alumno = $('#id_alumno').val();
        dataString.append('id_alumno', id_alumno);

        if (Valida_Observacion_Alumno()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    Registrar_Observacion_Alumno(id_alumno);
                    Lista_Observacion();
                }
            });
        }
    }

    function Delete_Observacion_Alumno(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>LittleLeaders/Delete_Observacion_Alumno";

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El regitro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'id_observacion': id
                    },
                    success: function(data) {
                        Lista_Observacion();
                    }
                });
            }
        })
    }

    function Excel_Observacion() {
        var id_alumno = $('#id_alumno').val();
        window.location = "<?php echo site_url(); ?>LittleLeaders/Excel_Observacion_Alumno/" + id_alumno;
    }
</script>

<?php $this->load->view('view_LL/footer'); ?>