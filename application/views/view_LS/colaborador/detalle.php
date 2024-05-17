<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<?php $this->load->view('view_LS/header'); ?>
<?php $this->load->view('view_LS/nav'); ?>

<style>
    .tabset > input[type="radio"] {
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
    .tabset > input:nth-child(13):checked ~ .tab-panels > .tab-panel:nth-child(7){
        display: block;
    }

    .tabset > label {
        position: relative;
        display: inline-block;
        padding: 15px 15px 25px;
        border: 1px solid transparent;
        border-bottom: 0;
        cursor: pointer;
        font-weight: 600;
        background: #799dfd5c;
    }

    .tabset > label::after {
        content: "";
        position: absolute;
        left: 15px;
        bottom: 10px;
        width: 22px;
        height: 4px;
        background: #8d8d8d;
    }

    .tabset > label:hover,
    .tabset > input:focus + label {
        color: #06c;
    }

    .tabset > label:hover::after,
    .tabset > input:focus + label::after,
    .tabset > input:checked + label::after {
        background: #06c;
    }

    .tabset > input:checked + label {
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

    .margintop{
        margin-top:5px ;
    }

    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
    }

    .img_class{ 
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }

    .boton_exportable{
        margin: 0 0 10px 0;
    }

    .cabecera_pagos{
        margin: 5px 0 0 5px;
    }
</style> 

<div class="panel panel-flat">
    <div class="panel-heading"> 
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;"> 
                    <?php if($get_id[0]['foto']!=""){ ?>
                        <a onclick="Descargar_Foto_Colaborador('<?php echo $get_id[0]['id_colaborador']; ?>');">
                            <img class="img_class" src="<?php echo base_url().$get_id[0]['foto']; ?>">
                        </a>
                    <?php } ?>
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group"> 
                        <a title="Nuevo Contrato" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('LeadershipSchool/Modal_Contrato_Colaborador') ?>/<?php echo $get_id[0]['id_colaborador']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/boton_nuevo_contrato.png" alt="Exportar Excel">
                        </a>

                        <a title="Nuevo Pago" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('LeadershipSchool/Modal_Pago_Colaborador') ?>/<?php echo $get_id[0]['id_colaborador']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/boton_nuevo_pago.png" alt="Exportar Excel">
                        </a>

                        <a type="button" href="<?= site_url('LeadershipSchool/Colaborador') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 row">
                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Código:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['codigo_gll']; ?>">
                </div>

                <div class="form-group col-lg-1">
                </div>

                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Nickname:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nickname']; ?>">
                </div>
            </div> 

            <div class="col-lg-12 row">
                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Ap.&nbsp;Paterno:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['apellido_paterno']; ?>">
                </div>

                <div class="form-group col-lg-1">
                </div>

                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Ap.&nbsp;Materno:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['apellido_materno']; ?>">
                </div>

                <div class="form-group col-lg-1">
                </div>

                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Nombre(s): </label>
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nombres']; ?>">
                </div>
            </div> 

            <div class="col-lg-12 row">
                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">DNI:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['dni']; ?>">
                </div>

                <div class="form-group col-lg-1">
                </div>

                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Celular:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['celular']; ?>">
                </div>

                <div class="form-group col-lg-1">
                </div>

                <div class="form-group col-lg-1">
                    <label class="control-label text-bold margintop">Correo: </label>
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['correo_personal']; ?>">
                </div>
            </div> 
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked>
                <label for="tab1">Datos</label>

                <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==3 || $_SESSION['usuario'][0]['id_usuario']==7 || 
                $_SESSION['usuario'][0]['id_usuario']==9 || $_SESSION['usuario'][0]['id_usuario']==10 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" onclick="Lista_Contrato(); ">
                    <label for="tab2">Contrato</label>   

                    <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Pago();">
                    <label for="tab3">Pagos</label>
                <?php }else{ ?>
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" disabled>
                    <label for="tab2">Contrato</label>   

                    <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" disabled>
                    <label for="tab3">Pagos</label>
                <?php } ?>

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4">
                <label  for="tab4">Horario</label>

                <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="Lista_Asistencia();">
                <label for="tab5">Asistencia</label>

                <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6">
                <label for="tab6">Compras</label>

                <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8" onclick="Lista_Observacion();">
                <label for="tab8">Observaciones</label>

                <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $get_id[0]['id_colaborador']; ?>">   
            
                <div class="tab-panels">
                    <!-- DATOS -->
                    <section id="rauchbier1" class="tab-panel">
                        <div class="box-body table-responsive">
                            <div class="panel panel-flat content-group-lg">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><b>Datos</b></h5>
                                    <div class="heading-elements">
                                        <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                            <li><a data-action="reload"></a></li>
                                            <li><a data-action="close"></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="row">
                                        <div class="form-group col-lg-1">
                                            <label class="control-label text-bold margintop">Perfil:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_perfil']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Correo&nbsp;Corporativo:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['correo_corporativo']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Dirección:</label>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['direccion']; ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Departamento:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nombre_departamento']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Provincia:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nombre_provincia']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Distrito:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nombre_distrito']; ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Inicio&nbsp;Funciones:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['i_funciones']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Fin&nbsp;Funciones:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['f_funciones']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Usuario:</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['usuario']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label class="control-label text-bold">Cuenta bancaria:</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Banco:</label>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['banco']; ?>">
                                        </div>

                                        <div class="form-group col-lg-2 margintop">
                                            <label class="control-label text-bold">Cuenta:</label>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cuenta']; ?>">
                                        </div>
                                    </div>

                                    <form id="formulario_cv" method="POST" enctype="multipart/form-data" class="formulario">
                                        <div class="row">
                                            <div class="form-group col-lg-1 margintop">
                                                <label class="control-label text-bold">CV:</label>
                                            </div>
                                            <div class="form-group col-lg-10">
                                                <button type="button" onclick="Abrir('cv')">Seleccionar archivo</button>
                                                <input type="file" id="cv" name="cv" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
                                                <span id="span_documento"><?php if($get_id[0]['cv']!=""){ echo $get_id[0]['nom_cv']; }else{ echo "No se eligió archivo"; } ?></span>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $get_id[0]['id_colaborador']; ?>">
                                            <input type="hidden" id="cv_actual" name="cv_actual" value="<?php echo $get_id[0]['cv']; ?>">
                                            <button type="button" class="btn btn-primary" onclick="Update_Cv_Colaborador();">
                                                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> 
                    </section>

                    <!-- CONTRATOS -->
                    <section id="rauchbier2" class="tab-panel">
                        <div class="modal-content">
                            <div id="lista_contrato">
                            </div>
                        </div>
                    </section>

                    <!-- PAGOS -->
                    <section id="rauchbier3" class="tab-panel">
                        <div class="modal-content">
                            <div id="lista_pago">
                            </div>
                        </div>
                    </section>

                    <!-- HORARIOS -->
                    <section id="rauchbier4" class="tab-panel">
                        <div class="modal-content">
                            <div id="lista_horario">
                            </div>
                        </div>
                    </section>

                    <!-- ASISTENCIAS -->
                    <section id="rauchbier5" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Asistencia();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                            </a>
                        </div>

                        <div class="modal-content">
                            <div id="lista_asistencia">
                            </div>
                        </div>
                    </section>

                    <!-- COMPRAS -->
                    <section id="rauchbier6" class="tab-panel">
                        <div class="modal-content">
                            <div id="lista_compra">
                            </div>
                        </div>
                    </section>

                    <!-- OBSERVACIONES -->
                    <section id="rauchbier8" class="tab-panel">
                        <form id="formulario_obs" method="POST" enctype="multipart/form-data" class="formulario">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Tipo:</label>
                                    <select class="form-control" id="id_tipo_o" name="id_tipo_o">
                                        <option  value="0">Seleccione</option>
                                        <?php foreach($list_tipo_obs as $list){ ?>
                                            <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
                                        <?php } ?>
                                    </select> 
                                </div>

                                <?php if($id_nivel==1 || $id_nivel==6){ ?>
                                    <div class="form-group col-md-2">
                                        <label class="control-label text-bold">Fecha:</label>
                                        <input class="form-control" type="date" id="fecha_o" name="fecha_o" value="<?php echo date('Y-m-d'); ?>"> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="control-label text-bold">Usuario:</label>
                                        <select class="form-control" id="usuario_o" name="usuario_o">
                                            <option value="0">Seleccione</option>
                                            <?php foreach($list_usuario as $list){?> 
                                                <option value="<?php echo $list['id_usuario'] ?>" <?php if($list['id_usuario']==$id_usuario){ echo "selected"; } ?>>
                                                    <?php echo $list['usuario_codigo']; ?>
                                                </option>    
                                            <?php }?>
                                        </select>
                                    </div>
                                <?php }else{?>
                                    <div class="form-group col-md-2">
                                        <label class="control-label text-bold">Fecha:</label>
                                        <input class="form-control" readonly="yes" type="date" id="fecha_o" name="fecha_o" value="<?php echo date('Y-m-d'); ?>"> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label text-bold">Usuario:</label>
                                        <p><?php echo $_SESSION['usuario'][0]['usuario_codigo'] ?></p>
                                        <input type="hidden" id="usuario_o" name="usuario_o" value="<?php echo $id_usuario; ?>">
                                    </div>
                                <?php } ?>

                                <div class="form-group col-md-4">
                                    <label class="control-label text-bold">Comentario:</label>
                                    <div class="">
                                        <input class="form-control" type="text" id="observacion_o" name="observacion_o" maxlength="150" placeholder="Comentario">
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Archivo:</label>
                                    <button type="button" onclick="Abrir('observacion_archivo')">Seleccionar archivo</button>
                                    <input type="file" id="observacion_archivo" name="observacion_archivo" onchange="Nombre_Archivo2(this,'span_observacion_archivo')" style="display: none">
                                    <span id="span_observacion_archivo"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="">
                                        <input class="form-control" type="text" id="comentariog_o" name="comentariog_o" maxlength="45" value="<?php echo $get_id[0]['comentariog']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $get_id[0]['id_colaborador']; ?>">
                                <button type="button" class="btn btn-default" onclick="Limpiar_Observacion_Colaborador();">
                                    <i class="glyphicon glyphicon-remove-sign"></i>Limpiar
                                </button>
                                <button type="button" class="btn btn-primary" onclick="Insert_Observacion_Colaborador();">
                                    <i class="glyphicon glyphicon-ok-sign"></i>Guardar
                                </button>
                            </div>
                        </form>

                        <div class="modal-content">
                            <div id="lista_observacion">
                            </div>
                        </div>
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#colaboradores_lista").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";
    });

    function Descargar_Foto_Colaborador(id){
        window.location.replace("<?php echo site_url(); ?>LeadershipSchool/Descargar_Foto_Colaborador/"+id);
    }

    function Abrir(id) {
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
    }

    function Nombre_Archivo(element,glosa) { 
        var glosa = document.getElementById(glosa);

        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            if(element.files[0].name.substr(-3)=='pdf'){
                glosa.innerText = element.files[0].name;
            }else{
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar CV con extensiones .pdf.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }
        }
    }

    function Nombre_Archivo2(element,glosa) { 
        var glosa = document.getElementById(glosa);

        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        }
        else {
            if(element.files[0].name.substr(-3)=='pdf' || element.files[0].name.substr(-3)=='png' ||
            element.files[0].name.substr(-3)=='PDF' || element.files[0].name.substr(-3)=='PNG' ||
            element.files[0].name.substr(-3)=='jpg' || element.files[0].name.substr(-4)=='jpeg' ||
            element.files[0].name.substr(-3)=='JPG' || element.files[0].name.substr(-4)=='JPEG' ||
            element.files[0].name.substr(-3)=='mp4'){
                glosa.innerText = element.files[0].name;
            }else{
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .pdf, .jpg, .png ó .mp4.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }
        }
    }

    function Update_Cv_Colaborador(){
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var dataString = new FormData(document.getElementById('formulario_cv'));
        var url="<?php echo site_url(); ?>LeadershipSchool/Update_Cv_Colaborador";

        if (Valida_Update_Cv_Colaborador()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>LeadershipSchool/Detalle_Colaborador/"+id_colaborador;
                }
            });
        }
    }

    function Valida_Update_Cv_Colaborador() {
        if($('#cv').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar CV.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Lista_Contrato(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Contrato_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador},
            success:function (data) {
                $('#lista_contrato').html(data);
            }
        });
    }

    function Descargar_Contrato_Colaborador(id){
        window.location.replace("<?php echo site_url(); ?>LeadershipSchool/Descargar_Contrato_Colaborador/"+id);
    }

    function Delete_Contrato_Colaborador(id){
        Cargando();

        var url="<?php echo site_url(); ?>LeadershipSchool/Delete_Contrato_Colaborador";
        
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
                    data: {'id_contrato':id},
                    success:function () {
                        Lista_Contrato();  
                    }
                });
            }
        })
    }

    function Lista_Pago(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Pago_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador},
            success:function (data) {
                $('#lista_pago').html(data);
            }
        });
    }

    function Delete_Pago_Colaborador(id){
        Cargando();

        var url="<?php echo site_url(); ?>LeadershipSchool/Delete_Pago_Colaborador";
        
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
                    data: {'id_pago':id},
                    success:function () {
                        Lista_Pago();  
                    }
                });
            }
        })
    }

    function Lista_Asistencia(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Asistencia_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador},
            success:function (data) {
                $('#lista_asistencia').html(data);
            }
        });
    }

    function Excel_Asistencia(){
        var id_colaborador = $("#id_colaborador").val();
        window.location ="<?php echo site_url(); ?>LeadershipSchool/Excel_Ingresos_Colaborador/"+id_colaborador;
    }

    function Lista_Observacion(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Observacion_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador},
            success:function (data) {
                $('#lista_observacion').html(data);
            }
        });
    }

    function Limpiar_Observacion_Colaborador(){
        $('#id_tipo_o').val('0');
        $('#usuario_o').val('0');
        $('#observacion_o').val('');
        $('#span_observacion_archivo').html('');
    }

    function Insert_Observacion_Colaborador(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>LeadershipSchool/Insert_Observacion_Colaborador";
        
        if(Valida_Insert_Observacion_Colaborador()){
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
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
                        Limpiar_Observacion_Colaborador();
                        Lista_Observacion();
                    }
                }
            });
        }
    }

    function Valida_Insert_Observacion_Colaborador(){
        if($('#id_tipo_o').val()!=="0" || $('#observacion_o').val()!==""){
            if($('#id_tipo_o').val() === 0){
                Swal(
                    'Ups!',
                    'Debe seleccionar Tipo',
                    'warning'
                ).then(function() {
                });
                return false;
            }
            
            if($('#fecha_o').val().trim() === ""){
                Swal(
                    'Ups!',
                    'Debe ingresar Fecha',
                    'warning'
                ).then(function() {
                });
                return false;
            }
            
            if($('#usuario_o').val() === 0){
                Swal(
                    'Ups!',
                    'Debe seleccionar Usuario',
                    'warning'
                ).then(function() {
                });
                return false;
            }
            
            if($('#observacion_o').val().trim() === ""){
                Swal(
                    'Ups!',
                    'Debe ingresar Comentario',
                    'warning'
                ).then(function() {
                });
                return false;
            }
        }
        return true;
    }

    function Delete_Observacion_Colaborador(id){
        Cargando();

        var url="<?php echo site_url(); ?>LeadershipSchool/Delete_Observacion_Colaborador";
        
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
                    data: {'id_observacion':id},
                    success:function () {
                        Lista_Observacion();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('view_LS/footer'); ?>