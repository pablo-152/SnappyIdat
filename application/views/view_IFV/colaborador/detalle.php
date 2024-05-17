<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

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

    .oculto {
        display: none!important;
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
                        app_crear_per="<?= site_url('AppIFV/Modal_Contrato_Colaborador') ?>/<?php echo $get_id[0]['id_colaborador']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/boton_nuevo_contrato.png" alt="Exportar Excel">
                        </a>

                        <a title="Nuevo Pago" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('AppIFV/Modal_Pago_Colaborador') ?>/<?php echo $get_id[0]['id_colaborador']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/boton_nuevo_pago.png" alt="Exportar Excel">
                        </a>

                        <a title="Horario" data-toggle="modal" data-target="#modal_form_vertical" 
                        modal_form_vertical="<?= site_url('AppIFV/Modal_Horario_Colaborador') ?>/<?php echo $get_id[0]['id_colaborador']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/horario_btn.png" alt="Exportar Excel">
                        </a>

                        <a title="Editar" href="<?= site_url('AppIFV/Editar_Colaborador') ?>/<?php echo $get_id[0]['id_colaborador']; ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/editar_grande.png" alt="Editar">
                        </a>

                        <a type="button" href="<?= site_url('AppIFV/Colaborador') ?>">
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

                <?php if($id_usuario==1 || $id_usuario==3 || $id_usuario==7 || $id_usuario==9 || $id_usuario==10 ||
                        $id_nivel==6){ ?>
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" onclick="Lista_Contrato()">
                    <label for="tab2">Contrato</label>

                    <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Pago()">
                    <label for="tab3">Pagos</label>
                <?php }else{ ?>
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" disabled>
                    <label for="tab2">Contrato</label>   

                    <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" disabled>
                    <label for="tab3">Pagos</label>   
                <?php } ?>

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" onclick="List_Horario_Colaborador_V2()">
                <label  for="tab4">Horario</label>

                <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="Lista_Meses()">
                <label for="tab5">Asistencia</label>

                <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6">
                <label for="tab6">Compras</label>

                <?php if($id_usuario==1 || $id_usuario==7 || $id_usuario==24 || $id_usuario==9 || 
                        $id_usuario==10 || $id_nivel==6){ ?>
                    <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8" onclick="Lista_Observacion()">
                    <label for="tab8">Observaciones</label>
                <?php } ?>

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
                                            <div class="form-group col-lg-1">
                                                <label class="control-label text-bold">DNI:</label>
                                            </div>
                                            <div class="form-group col-lg-11">
                                                <button type="button" onclick="Abrir('archivo_dni')">Seleccionar archivo</button>
                                                <input type="file" id="archivo_dni" name="archivo_dni" onchange="Nombre_Archivo(this,'span_dni')" style="display: none">
                                                <span id="span_dni"><?php if($get_id[0]['archivo_dni']!=""){ echo $get_id[0]['nom_dni']; }else{ echo "No se eligió archivo"; } ?></span>
                                                <?php if($get_id[0]['archivo_dni']!=""){ ?>
                                                    <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_colaborador']; ?>',1)">
                                                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                                    </a> 
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-lg-1">
                                                <label class="control-label text-bold">CV:</label>
                                            </div>
                                            <div class="form-group col-lg-11">
                                                <button type="button" onclick="Abrir('cv')">Seleccionar archivo</button>
                                                <input type="file" id="cv" name="cv" onchange="Nombre_Archivo(this,'span_cv')" style="display: none">
                                                <span id="span_cv"><?php if($get_id[0]['cv']!=""){ echo $get_id[0]['nom_cv']; }else{ echo "No se eligió archivo"; } ?></span>
                                                <?php if($get_id[0]['cv']!=""){ ?>
                                                    <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_colaborador']; ?>',2)">
                                                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $get_id[0]['id_colaborador']; ?>">
                                            <input type="hidden" id="dni_actual" name="dni_actual" value="<?php echo $get_id[0]['archivo_dni']; ?>">
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
                            <!--<div class="row">
                                <input type="hidden" name="id_horario_upd" id="id_horario_upd">
                                <div class="col-lg-1" style="margin: 0px 0px 2px 0px;">
                                    <label class="control-label text-bold margintop">De</label>
                                </div>
                                <div class="col-lg-2">
                                    <input type="date" id="desde_horario" name="desde_horario" class="form-control">
                                </div>
                                <div class="col-lg-1">
                                    <label class="control-label text-bold margintop">A</label>
                                </div>
                                <div class="col-lg-2">
                                    <input type="date" id="hasta_horario" name="hasta_horario" class="form-control">
                                </div>
                                <div class="col-lg-1" id="div_estado_horario2" style="display:none">
                                    <label class="control-label text-bold margintop" >Estado</label>
                                </div>
                                <div class="col-lg-2" id="div_estado_horario" style="display:none">
                                    <select name="estado_registro_horario" id="estado_registro_horario" class="form-control">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-3 my-custom-row" >
                                    <label for="ch_m">Mañana <input type="checkbox" checked name="ch_m" id="ch_m" value="1" onclick="Habilitar_Rango('m')"></label>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <label for="">Ingreso</label>
                                            <div>
                                                <input type="time" name="ingreso_m" id="ingreso_m" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <label for="">Salida</label>
                                            <div>
                                                <input type="time" name="salida_m" id="salida_m" class="form-control">
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                                
                                <div class="col-lg-3" >
                                    <label for="ch_alm">Almuerzo <input type="checkbox" checked name="ch_alm" id="ch_alm" value="1" onclick="Habilitar_Rango('alm')"></label>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <label for="">Ingreso</label>
                                            <div>
                                                <input type="time" name="ingreso_alm" id="ingreso_alm" class="form-control">
                                            </div>
                                        </div>   
                                        <div class="col-lg-5">
                                            <label for="">Salida</label>
                                            <div>
                                                <input type="time" name="salida_alm" id="salida_alm" class="form-control">
                                            </div>
                                        </div> 
                                    </div>
                                </div>

                                <div class="col-lg-3" >
                                    <label for="ch_t">Tarde <input type="checkbox" checked name="ch_t" id="ch_t" value="1" onclick="Habilitar_Rango('t')"></label>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <label for="">Ingreso</label>
                                            <div>
                                                <input type="time" name="ingreso_t" id="ingreso_t" class="form-control">
                                            </div>
                                        </div>   
                                        <div class="col-lg-5">
                                            <label for="">Salida</label>
                                            <div>
                                                <input type="time" name="salida_t" id="salida_t" class="form-control">
                                            </div>
                                        </div> 
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-6" >
                                    <label for="ch_c">Cena <input type="checkbox" checked name="ch_c" id="ch_c" value="1" onclick="Habilitar_Rango('c')"></label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Ingreso</label>
                                            <div>
                                                <input type="time" name="ingreso_c" id="ingreso_c" class="form-control">
                                            </div>
                                        </div>   
                                        <div class="col-lg-6">
                                            <label for="">Salida</label>
                                            <div>
                                                <input type="time" name="salida_c" id="salida_c" class="form-control">
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="ch_n">Noche <input type="checkbox" checked name="ch_n" id="ch_n" value="1" onclick="Habilitar_Rango('n')"></label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Ingreso</label>
                                            <div>
                                                <input type="time" name="ingreso_n" id="ingreso_n" class="form-control">
                                            </div>
                                        </div>   
                                        <div class="col-lg-6">
                                            <label for="">Salida</label>
                                            <div>
                                                <input type="time" name="salida_n" id="salida_n" class="form-control">
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <label for="">&nbsp;</label>
                                    <div id="btn_reg">
                                        <button type="button"  class="btn btn-primary " onclick="Insert_Horario_Colaborador_V2()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                                    </div>
                                    <div id="btn_edit" style="display:none">
                                        <button type="button" class="btn btn-primary" onclick="Update_Horario_Colaborador_V2()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                                        <button type="button" class="btn btn-default" onclick="Limpiar_Form_Horario()"><i class=""></i>Cancelar</button>
                                    </div>
                                </div>
                            </div>-->
                            <div id="lista_horario">

                            </div>
                        </div>
                    </section>

                    <!-- ASISTENCIAS -->
                    <section id="rauchbier5" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Ingresos();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                            </a>
                        </div>

                        <div class="modal-content">
                            <div id="div_doc">
                                <div class="tabset">
                                    <div class="form-group col-md-1">
                                        <select class="form-control" name="id_anio" id="id_anio" onchange="Lista_Meses()">
                                            <?php foreach($list_anios_ingreso as $list){ ?>
                                                <option value="<?php echo $list['orden']; ?>"><?php echo $list['orden']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div id="lista_meses" class="tabset">
                                    </div>
                                </div>
                                <div id="lista_ingresos" class="tabset">
                                
                                </div>
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

        //Lista_Contrato();  
        //Lista_Pago();
        //Lista_Horario();
        //Lista_Asistencia();  
        //Lista_Observacion();
        //Lista_Meses();
        //Lista_Ingresos();
    });

    function Descargar_Foto_Colaborador(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Colaborador/"+id);
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
                    text: "Asegurese de ingresar archivo con extensión .pdf.",
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Cv_Colaborador";

        if (Valida_Update_Cv_Colaborador()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Colaborador/"+id_colaborador;
                }
            });
        }
    }

    function Valida_Update_Cv_Colaborador() { 
        if($('#cv_actual').val().trim() === '') {
            if($('#cv').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar CV.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }

    function Descargar_Archivo(id,orden){
        Cargando();
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Archivo_Colaborador/"+id+"/"+orden);
    }

    function Lista_Contrato(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Contrato_Colaborador";

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
        Cargando();
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Contrato_Colaborador/"+id);
    }

    function Delete_Contrato_Colaborador(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Contrato_Colaborador";
        
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
        var url="<?php echo site_url(); ?>AppIFV/Lista_Pago_Colaborador";

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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Pago_Colaborador";
        
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

    function Lista_Horario(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Horario_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador},
            success:function (data) {
                $('#lista_horario').html(data);
            }
        });
    }

    function Lista_Asistencia(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Asistencia_Colaborador";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador},
            success:function (data) {
                $('#lista_asistencia').html(data);
            }
        });
    }

    function Lista_Observacion(){ 
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Observacion_Colaborador";

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
        $('#span_observacion_archivo').val('');
    }

    function Insert_Observacion_Colaborador(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Observacion_Colaborador";
        
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
            if($('#id_tipo_o').val() === "0"){
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

            if($('#usuario_o').val() === "0"){
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Observacion_Colaborador";
        
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

    function Lista_Ingresos(){
      Cargando();

      var id_colaborador = $("#id_colaborador").val();
      var id_anio = $("#id_anio").val();
      var meses = $("#id_meses").val();
      var url="<?php echo site_url(); ?>AppIFV/Lista_Ingresos";

      $.ajax({
          type:"POST",
          url:url,
          data: {'id_colaborador':id_colaborador, 'id_anio':id_anio , 'meses':meses},
          success:function (data) {
            
              $('#lista_ingresos').html(data);
              
          }
      });
    }

    function Excel_Ingresos(){
        var id_colaborador = $("#id_colaborador").val();
        var id_anio = $("#id_anio").val();
        var meses = $("#id_meses").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Ingresos_Colaborador/"+id_colaborador+"/"+id_anio+"/"+meses;
    }

    function Lista_Meses(){
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var id_anio = $("#id_anio").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Meses";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_colaborador':id_colaborador, 'id_anio':id_anio},
            success:function (data) {
                $('#lista_meses').html(data);
            }
        });
    }

    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        //letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
        letras = "0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
        }
    }

    function Insert_Horario_Colaborador_V2(){
        Cargando();
        var url="<?php echo site_url(); ?>AppIFV/Insert_Horario_Colaborador_V2";
        var id_colaborador=$('#id_colaborador').val();
        var de= $('#desde_horario').val();
        var a= $('#hasta_horario').val();
        
        var ch_lun = $('#ch_lun').is(':checked') ? 1 : 0;
        var ch_mar = $('#ch_mar').is(':checked') ? 1 : 0;
        var ch_mier = $('#ch_mier').is(':checked') ? 1 : 0;
        var ch_jue = $('#ch_jue').is(':checked') ? 1 : 0;
        var ch_vie = $('#ch_vie').is(':checked') ? 1 : 0;
        var ch_sab = $('#ch_sab').is(':checked') ? 1 : 0;
        var ch_dom = $('#ch_dom').is(':checked') ? 1 : 0;

        var ch_m_lun = $('#ch_m_lun').is(':checked') ? 1 : 0;
            var ch_alm_lun= $('#ch_alm_lun').is(':checked') ? 1 : 0;
            var ch_t_lun= $('#ch_t_lun').is(':checked') ? 1 : 0;
            var ch_c_lun= $('#ch_c_lun').is(':checked') ? 1 : 0;
            var ch_n_lun = $('#ch_n_lun').is(':checked') ? 1 : 0;

            var ch_m_mar = $('#ch_m_mar').is(':checked') ? 1 : 0;
            var ch_alm_mar= $('#ch_alm_mar').is(':checked') ? 1 : 0;
            var ch_t_mar= $('#ch_t_mar').is(':checked') ? 1 : 0;
            var ch_c_mar= $('#ch_c_mar').is(':checked') ? 1 : 0;
            var ch_n_mar = $('#ch_n_mar').is(':checked') ? 1 : 0;

            var ch_m_mier = $('#ch_m_mier').is(':checked') ? 1 : 0;
            var ch_alm_mier= $('#ch_alm_mier').is(':checked') ? 1 : 0;
            var ch_t_mier= $('#ch_t_mier').is(':checked') ? 1 : 0;
            var ch_c_mier= $('#ch_c_mier').is(':checked') ? 1 : 0;
            var ch_n_mier = $('#ch_n_mier').is(':checked') ? 1 : 0;

            var ch_m_jue = $('#ch_m_jue').is(':checked') ? 1 : 0;
            var ch_alm_jue= $('#ch_alm_jue').is(':checked') ? 1 : 0;
            var ch_t_jue= $('#ch_t_jue').is(':checked') ? 1 : 0;
            var ch_c_jue= $('#ch_c_jue').is(':checked') ? 1 : 0;
            var ch_n_jue = $('#ch_n_jue').is(':checked') ? 1 : 0;

            var ch_m_vie = $('#ch_m_vie').is(':checked') ? 1 : 0;
            var ch_alm_vie= $('#ch_alm_vie').is(':checked') ? 1 : 0;
            var ch_t_vie= $('#ch_t_vie').is(':checked') ? 1 : 0;
            var ch_c_vie= $('#ch_c_vie').is(':checked') ? 1 : 0;
            var ch_n_vie = $('#ch_n_vie').is(':checked') ? 1 : 0;

            var ch_m_sab = $('#ch_m_sab').is(':checked') ? 1 : 0;
            var ch_alm_sab= $('#ch_alm_sab').is(':checked') ? 1 : 0;
            var ch_t_sab= $('#ch_t_sab').is(':checked') ? 1 : 0;
            var ch_c_sab= $('#ch_c_sab').is(':checked') ? 1 : 0;
            var ch_n_sab = $('#ch_n_sab').is(':checked') ? 1 : 0;

            var ch_m_dom = $('#ch_m_dom').is(':checked') ? 1 : 0;
            var ch_alm_dom= $('#ch_alm_dom').is(':checked') ? 1 : 0;
            var ch_t_dom= $('#ch_t_dom').is(':checked') ? 1 : 0;
            var ch_c_dom= $('#ch_c_dom').is(':checked') ? 1 : 0;
            var ch_n_dom = $('#ch_n_dom').is(':checked') ? 1 : 0;

            var ingreso_m_lun=$('#ingreso_m_lun').val();
            var salida_m_lun=$('#salida_m_lun').val();
            var ingreso_alm_lun=$('#ingreso_alm_lun').val();
            var salida_alm_lun=$('#salida_alm_lun').val();
            var ingreso_t_lun=$('#ingreso_t_lun').val();
            var salida_t_lun=$('#salida_t_lun').val();
            var ingreso_c_lun=$('#ingreso_c_lun').val();
            var salida_c_lun=$('#salida_c_lun').val();
            var ingreso_n_lun=$('#ingreso_n_lun').val();
            var salida_n_lun=$('#salida_n_lun').val();

            var ingreso_m_mar=$('#ingreso_m_mar').val();
            var salida_m_mar=$('#salida_m_mar').val();
            var ingreso_alm_mar=$('#ingreso_alm_mar').val();
            var salida_alm_mar=$('#salida_alm_mar').val();
            var ingreso_t_mar=$('#ingreso_t_mar').val();
            var salida_t_mar=$('#salida_t_mar').val();
            var ingreso_c_mar=$('#ingreso_c_mar').val();
            var salida_c_mar=$('#salida_c_mar').val();
            var ingreso_n_mar=$('#ingreso_n_mar').val();
            var salida_n_mar=$('#salida_n_mar').val();

            var ingreso_m_mier=$('#ingreso_m_mier').val();
            var salida_m_mier=$('#salida_m_mier').val();
            var ingreso_alm_mier=$('#ingreso_alm_mier').val();
            var salida_alm_mier=$('#salida_alm_mier').val();
            var ingreso_t_mier=$('#ingreso_t_mier').val();
            var salida_t_mier=$('#salida_t_mier').val();
            var ingreso_c_mier=$('#ingreso_c_mier').val();
            var salida_c_mier=$('#salida_c_mier').val();
            var ingreso_n_mier=$('#ingreso_n_mier').val();
            var salida_n_mier=$('#salida_n_mier').val();

            var ingreso_m_jue=$('#ingreso_m_jue').val();
            var salida_m_jue=$('#salida_m_jue').val();
            var ingreso_alm_jue=$('#ingreso_alm_jue').val();
            var salida_alm_jue=$('#salida_alm_jue').val();
            var ingreso_t_jue=$('#ingreso_t_jue').val();
            var salida_t_jue=$('#salida_t_jue').val();
            var ingreso_c_jue=$('#ingreso_c_jue').val();
            var salida_c_jue=$('#salida_c_jue').val();
            var ingreso_n_jue=$('#ingreso_n_jue').val();
            var salida_n_jue=$('#salida_n_jue').val();

            var ingreso_m_vie=$('#ingreso_m_vie').val();
            var salida_m_vie=$('#salida_m_vie').val();
            var ingreso_alm_vie=$('#ingreso_alm_vie').val();
            var salida_alm_vie=$('#salida_alm_vie').val();
            var ingreso_t_vie=$('#ingreso_t_vie').val();
            var salida_t_vie=$('#salida_t_vie').val();
            var ingreso_c_vie=$('#ingreso_c_vie').val();
            var salida_c_vie=$('#salida_c_vie').val();
            var ingreso_n_vie=$('#ingreso_n_vie').val();
            var salida_n_vie=$('#salida_n_vie').val();

            var ingreso_m_sab=$('#ingreso_m_sab').val();
            var salida_m_sab=$('#salida_m_sab').val();
            var ingreso_alm_sab=$('#ingreso_alm_sab').val();
            var salida_alm_sab=$('#salida_alm_sab').val();
            var ingreso_t_sab=$('#ingreso_t_sab').val();
            var salida_t_sab=$('#salida_t_sab').val();
            var ingreso_c_sab=$('#ingreso_c_sab').val();
            var salida_c_sab=$('#salida_c_sab').val();
            var ingreso_n_sab=$('#ingreso_n_sab').val();
            var salida_n_sab=$('#salida_n_sab').val();

            var ingreso_m_dom=$('#ingreso_m_dom').val();
            var salida_m_dom=$('#salida_m_dom').val();
            var ingreso_alm_dom=$('#ingreso_alm_dom').val();
            var salida_alm_dom=$('#salida_alm_dom').val();
            var ingreso_t_dom=$('#ingreso_t_dom').val();
            var salida_t_dom=$('#salida_t_dom').val();
            var ingreso_c_dom=$('#ingreso_c_dom').val();
            var salida_c_dom=$('#salida_c_dom').val();
            var ingreso_n_dom=$('#ingreso_n_dom').val();
        var salida_n_dom=$('#salida_n_dom').val();
        
        if (Valida_Horario_V2('')) {
            $.ajax({
                url: url,
                data:{
                    'de':de,'a':a,
                    'ch_lun':ch_lun,'ch_mar':ch_mar,'ch_mier':ch_mier,'ch_jue':ch_jue,'ch_vie':ch_vie,'ch_sab':ch_sab,'ch_dom':ch_dom,
                    'ch_m_lun':ch_m_lun,'ch_alm_lun':ch_alm_lun,'ch_t_lun':ch_t_lun,'ch_c_lun':ch_c_lun,'ch_n_lun':ch_n_lun,
                    'ch_m_mar':ch_m_mar,'ch_alm_mar':ch_alm_mar,'ch_t_mar':ch_t_mar,'ch_c_mar':ch_c_mar,'ch_n_mar':ch_n_mar,
                    'ch_m_mier':ch_m_mier,'ch_alm_mier':ch_alm_mier,'ch_t_mier':ch_t_mier,'ch_c_mier':ch_c_mier,'ch_n_mier':ch_n_mier,
                    'ch_m_jue':ch_m_jue,'ch_alm_jue':ch_alm_jue,'ch_t_jue':ch_t_jue,'ch_c_jue':ch_c_jue,'ch_n_jue':ch_n_jue,
                    'ch_m_vie':ch_m_vie,'ch_alm_vie':ch_alm_vie,'ch_t_vie':ch_t_vie,'ch_c_vie':ch_c_vie,'ch_n_vie':ch_n_vie,
                    'ch_m_sab':ch_m_sab,'ch_alm_sab':ch_alm_sab,'ch_t_sab':ch_t_sab,'ch_c_sab':ch_c_sab,'ch_n_sab':ch_n_sab,
                    'ch_m_dom':ch_m_dom,'ch_alm_dom':ch_alm_dom,'ch_t_dom':ch_t_dom,'ch_c_dom':ch_c_dom,'ch_n_dom':ch_n_dom,
                    'ingreso_m_lun':ingreso_m_lun,'salida_m_lun':salida_m_lun,'ingreso_alm_lun':ingreso_alm_lun,'salida_alm_lun':salida_alm_lun,
                    'ingreso_t_lun':ingreso_t_lun,'salida_t_lun':salida_t_lun,'ingreso_c_lun':ingreso_c_lun,'salida_c_lun':salida_c_lun,
                    'ingreso_n_lun':ingreso_n_lun,'salida_n_lun':salida_n_lun,

                    'ingreso_m_mar':ingreso_m_mar,'salida_m_mar':salida_m_mar,'ingreso_alm_mar':ingreso_alm_mar,'salida_alm_mar':salida_alm_mar,
                    'ingreso_t_mar':ingreso_t_mar,'salida_t_mar':salida_t_mar,'ingreso_c_mar':ingreso_c_mar,'salida_c_mar':salida_c_mar,
                    'ingreso_n_mar':ingreso_n_mar,'salida_n_mar':salida_n_mar,

                    'ingreso_m_mier':ingreso_m_mier,'salida_m_mier':salida_m_mier,'ingreso_alm_mier':ingreso_alm_mier,'salida_alm_mier':salida_alm_mier,
                    'ingreso_t_mier':ingreso_t_mier,'salida_t_mier':salida_t_mier,'ingreso_c_mier':ingreso_c_mier,'salida_c_mier':salida_c_mier,
                    'ingreso_n_mier':ingreso_n_mier,'salida_n_mier':salida_n_mier,

                    'ingreso_m_jue':ingreso_m_jue,'salida_m_jue':salida_m_jue,'ingreso_alm_jue':ingreso_alm_jue,'salida_alm_jue':salida_alm_jue,
                    'ingreso_t_jue':ingreso_t_jue,'salida_t_jue':salida_t_jue,'ingreso_c_jue':ingreso_c_jue,'salida_c_jue':salida_c_jue,
                    'ingreso_n_jue':ingreso_n_jue,'salida_n_jue':salida_n_jue,

                    'ingreso_m_vie':ingreso_m_vie,'salida_m_vie':salida_m_vie,'ingreso_alm_vie':ingreso_alm_vie,'salida_alm_vie':salida_alm_vie,
                    'ingreso_t_vie':ingreso_t_vie,'salida_t_vie':salida_t_vie,'ingreso_c_vie':ingreso_c_vie,'salida_c_vie':salida_c_vie,
                    'ingreso_n_vie':ingreso_n_vie,'salida_n_vie':salida_n_vie,

                    'ingreso_m_sab':ingreso_m_sab,'salida_m_sab':salida_m_sab,'ingreso_alm_sab':ingreso_alm_sab,'salida_alm_sab':salida_alm_sab,
                    'ingreso_t_sab':ingreso_t_sab,'salida_t_sab':salida_t_sab,'ingreso_c_sab':ingreso_c_sab,'salida_c_sab':salida_c_sab,
                    'ingreso_n_sab':ingreso_n_sab,'salida_n_sab':salida_n_sab,

                    'ingreso_m_dom':ingreso_m_dom,'salida_m_dom':salida_m_dom,'ingreso_alm_dom':ingreso_alm_dom,'salida_alm_dom':salida_alm_dom,
                    'ingreso_t_dom':ingreso_t_dom,'salida_t_dom':salida_t_dom,'ingreso_c_dom':ingreso_c_dom,'salida_c_dom':salida_c_dom,
                    'ingreso_n_dom':ingreso_n_dom,'salida_n_dom':salida_n_dom,
                    'id_colaborador':id_colaborador,
                },
                type:"POST",
                success:function (data) {
                    var cadena = data;
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);
                    if (validacion == 1) {
                        Swal(
                            'Registro Denegado!',
                            mensaje,
                            'error'
                        ).then(function() { });
                    }else{
                        Swal(
                            'Registro Exitoso!',
                            '',
                            'success'
                        ).then(function() {
                            //$("#modal_form_vertical .close").click()
                            //Limpiar_Form_Horario();
                            List_Horario_Colaborador_V2();
                         });
                    }
                }
            });
        }
    }

    function Update_Horario_Colaborador_V2(){ 
        Cargando();
        var url="<?php echo site_url(); ?>AppIFV/Update_Horario_Colaborador_V2";
        var id_horario=$('#id_horario_upd').val();
        var id_colaborador=$('#id_colaborador').val();
        var de= $('#desde_horarioe').val();
        var a= $('#hasta_horarioe').val();
        var ch_lun = $('#ch_lune').is(':checked') ? 1 : 0;
        var ch_mar = $('#ch_mare').is(':checked') ? 1 : 0;
        var ch_mier = $('#ch_miere').is(':checked') ? 1 : 0;
        var ch_jue = $('#ch_juee').is(':checked') ? 1 : 0;
        var ch_vie = $('#ch_viee').is(':checked') ? 1 : 0;
        var ch_sab = $('#ch_sabe').is(':checked') ? 1 : 0;
        var ch_dom = $('#ch_dome').is(':checked') ? 1 : 0;

        var ch_m_lun = $('#ch_m_lune').is(':checked') ? 1 : 0;
            var ch_alm_lun= $('#ch_alm_lune').is(':checked') ? 1 : 0;
            var ch_t_lun= $('#ch_t_lune').is(':checked') ? 1 : 0;
            var ch_c_lun= $('#ch_c_lune').is(':checked') ? 1 : 0;
            var ch_n_lun = $('#ch_n_lune').is(':checked') ? 1 : 0;

            var ch_m_mar = $('#ch_m_mare').is(':checked') ? 1 : 0;
            var ch_alm_mar= $('#ch_alm_mare').is(':checked') ? 1 : 0;
            var ch_t_mar= $('#ch_t_mare').is(':checked') ? 1 : 0;
            var ch_c_mar= $('#ch_c_mare').is(':checked') ? 1 : 0;
            var ch_n_mar = $('#ch_n_mare').is(':checked') ? 1 : 0;

            var ch_m_mier = $('#ch_m_miere').is(':checked') ? 1 : 0;
            var ch_alm_mier= $('#ch_alm_miere').is(':checked') ? 1 : 0;
            var ch_t_mier= $('#ch_t_miere').is(':checked') ? 1 : 0;
            var ch_c_mier= $('#ch_c_miere').is(':checked') ? 1 : 0;
            var ch_n_mier = $('#ch_n_miere').is(':checked') ? 1 : 0;

            var ch_m_jue = $('#ch_m_juee').is(':checked') ? 1 : 0;
            var ch_alm_jue= $('#ch_alm_juee').is(':checked') ? 1 : 0;
            var ch_t_jue= $('#ch_t_juee').is(':checked') ? 1 : 0;
            var ch_c_jue= $('#ch_c_juee').is(':checked') ? 1 : 0;
            var ch_n_jue = $('#ch_n_juee').is(':checked') ? 1 : 0;

            var ch_m_vie = $('#ch_m_viee').is(':checked') ? 1 : 0;
            var ch_alm_vie= $('#ch_alm_viee').is(':checked') ? 1 : 0;
            var ch_t_vie= $('#ch_t_viee').is(':checked') ? 1 : 0;
            var ch_c_vie= $('#ch_c_viee').is(':checked') ? 1 : 0;
            var ch_n_vie = $('#ch_n_viee').is(':checked') ? 1 : 0;

            var ch_m_sab = $('#ch_m_sabe').is(':checked') ? 1 : 0;
            var ch_alm_sab= $('#ch_alm_sabe').is(':checked') ? 1 : 0;
            var ch_t_sab= $('#ch_t_sabe').is(':checked') ? 1 : 0;
            var ch_c_sab= $('#ch_c_sabe').is(':checked') ? 1 : 0;
            var ch_n_sab = $('#ch_n_sabe').is(':checked') ? 1 : 0;

            var ch_m_dom = $('#ch_m_dome').is(':checked') ? 1 : 0;
            var ch_alm_dom= $('#ch_alm_dome').is(':checked') ? 1 : 0;
            var ch_t_dom= $('#ch_t_dome').is(':checked') ? 1 : 0;
            var ch_c_dom= $('#ch_c_dome').is(':checked') ? 1 : 0;
            var ch_n_dom = $('#ch_n_dome').is(':checked') ? 1 : 0;

            var ingreso_m_lun=$('#ingreso_m_lune').val();
            var salida_m_lun=$('#salida_m_lune').val();
            var ingreso_alm_lun=$('#ingreso_alm_lune').val();
            var salida_alm_lun=$('#salida_alm_lune').val();
            var ingreso_t_lun=$('#ingreso_t_lune').val();
            var salida_t_lun=$('#salida_t_lune').val();
            var ingreso_c_lun=$('#ingreso_c_lune').val();
            var salida_c_lun=$('#salida_c_lune').val();
            var ingreso_n_lun=$('#ingreso_n_lune').val();
            var salida_n_lun=$('#salida_n_lune').val();

            var ingreso_m_mar=$('#ingreso_m_mare').val();
            var salida_m_mar=$('#salida_m_mare').val();
            var ingreso_alm_mar=$('#ingreso_alm_mare').val();
            var salida_alm_mar=$('#salida_alm_mare').val();
            var ingreso_t_mar=$('#ingreso_t_mare').val();
            var salida_t_mar=$('#salida_t_mare').val();
            var ingreso_c_mar=$('#ingreso_c_mare').val();
            var salida_c_mar=$('#salida_c_mare').val();
            var ingreso_n_mar=$('#ingreso_n_mare').val();
            var salida_n_mar=$('#salida_n_mare').val();

            var ingreso_m_mier=$('#ingreso_m_miere').val();
            var salida_m_mier=$('#salida_m_miere').val();
            var ingreso_alm_mier=$('#ingreso_alm_miere').val();
            var salida_alm_mier=$('#salida_alm_miere').val();
            var ingreso_t_mier=$('#ingreso_t_miere').val();
            var salida_t_mier=$('#salida_t_miere').val();
            var ingreso_c_mier=$('#ingreso_c_miere').val();
            var salida_c_mier=$('#salida_c_miere').val();
            var ingreso_n_mier=$('#ingreso_n_miere').val();
            var salida_n_mier=$('#salida_n_miere').val();

            var ingreso_m_jue=$('#ingreso_m_juee').val();
            var salida_m_jue=$('#salida_m_juee').val();
            var ingreso_alm_jue=$('#ingreso_alm_juee').val();
            var salida_alm_jue=$('#salida_alm_juee').val();
            var ingreso_t_jue=$('#ingreso_t_juee').val();
            var salida_t_jue=$('#salida_t_juee').val();
            var ingreso_c_jue=$('#ingreso_c_juee').val();
            var salida_c_jue=$('#salida_c_juee').val();
            var ingreso_n_jue=$('#ingreso_n_juee').val();
            var salida_n_jue=$('#salida_n_juee').val();

            var ingreso_m_vie=$('#ingreso_m_viee').val();
            var salida_m_vie=$('#salida_m_viee').val();
            var ingreso_alm_vie=$('#ingreso_alm_viee').val();
            var salida_alm_vie=$('#salida_alm_viee').val();
            var ingreso_t_vie=$('#ingreso_t_viee').val();
            var salida_t_vie=$('#salida_t_viee').val();
            var ingreso_c_vie=$('#ingreso_c_viee').val();
            var salida_c_vie=$('#salida_c_viee').val();
            var ingreso_n_vie=$('#ingreso_n_viee').val();
            var salida_n_vie=$('#salida_n_viee').val();

            var ingreso_m_sab=$('#ingreso_m_sabe').val();
            var salida_m_sab=$('#salida_m_sabe').val();
            var ingreso_alm_sab=$('#ingreso_alm_sabe').val();
            var salida_alm_sab=$('#salida_alm_sabe').val();
            var ingreso_t_sab=$('#ingreso_t_sabe').val();
            var salida_t_sab=$('#salida_t_sabe').val();
            var ingreso_c_sab=$('#ingreso_c_sabe').val();
            var salida_c_sab=$('#salida_c_sabe').val();
            var ingreso_n_sab=$('#ingreso_n_sabe').val();
            var salida_n_sab=$('#salida_n_sabe').val();

            var ingreso_m_dom=$('#ingreso_m_dome').val();
            var salida_m_dom=$('#salida_m_dome').val();
            var ingreso_alm_dom=$('#ingreso_alm_dome').val();
            var salida_alm_dom=$('#salida_alm_dome').val();
            var ingreso_t_dom=$('#ingreso_t_dome').val();
            var salida_t_dom=$('#salida_t_dome').val();
            var ingreso_c_dom=$('#ingreso_c_dome').val();
            var salida_c_dom=$('#salida_c_dome').val();
            var ingreso_n_dom=$('#ingreso_n_dome').val();
        var salida_n_dom=$('#salida_n_dome').val();

        var id_horario_detalle_lun=$('#id_horario_detalle_lun').val();
        var id_horario_detalle_mar=$('#id_horario_detalle_mar').val();
        var id_horario_detalle_mier=$('#id_horario_detalle_mier').val();
        var id_horario_detalle_jue=$('#id_horario_detalle_jue').val();
        var id_horario_detalle_vie=$('#id_horario_detalle_vie').val();
        var id_horario_detalle_sab=$('#id_horario_detalle_sab').val();
        var id_horario_detalle_dom=$('#id_horario_detalle_dom').val();

        var estado_registro_horario=$('#estado_registro_horarioe').val();
        if (Valida_Horario_V2('e')) {
            $.ajax({
                url: url,
                data:{
                    'de':de,'a':a,
                    'ch_lun':ch_lun,'ch_mar':ch_mar,'ch_mier':ch_mier,'ch_jue':ch_jue,'ch_vie':ch_vie,'ch_sab':ch_sab,'ch_dom':ch_dom,
                    'ch_m_lun':ch_m_lun,'ch_alm_lun':ch_alm_lun,'ch_t_lun':ch_t_lun,'ch_c_lun':ch_c_lun,'ch_n_lun':ch_n_lun,
                    'ch_m_mar':ch_m_mar,'ch_alm_mar':ch_alm_mar,'ch_t_mar':ch_t_mar,'ch_c_mar':ch_c_mar,'ch_n_mar':ch_n_mar,
                    'ch_m_mier':ch_m_mier,'ch_alm_mier':ch_alm_mier,'ch_t_mier':ch_t_mier,'ch_c_mier':ch_c_mier,'ch_n_mier':ch_n_mier,
                    'ch_m_jue':ch_m_jue,'ch_alm_jue':ch_alm_jue,'ch_t_jue':ch_t_jue,'ch_c_jue':ch_c_jue,'ch_n_jue':ch_n_jue,
                    'ch_m_vie':ch_m_vie,'ch_alm_vie':ch_alm_vie,'ch_t_vie':ch_t_vie,'ch_c_vie':ch_c_vie,'ch_n_vie':ch_n_vie,
                    'ch_m_sab':ch_m_sab,'ch_alm_sab':ch_alm_sab,'ch_t_sab':ch_t_sab,'ch_c_sab':ch_c_sab,'ch_n_sab':ch_n_sab,
                    'ch_m_dom':ch_m_dom,'ch_alm_dom':ch_alm_dom,'ch_t_dom':ch_t_dom,'ch_c_dom':ch_c_dom,'ch_n_dom':ch_n_dom,
                    'ingreso_m_lun':ingreso_m_lun,'salida_m_lun':salida_m_lun,'ingreso_alm_lun':ingreso_alm_lun,'salida_alm_lun':salida_alm_lun,
                    'ingreso_t_lun':ingreso_t_lun,'salida_t_lun':salida_t_lun,'ingreso_c_lun':ingreso_c_lun,'salida_c_lun':salida_c_lun,
                    'ingreso_n_lun':ingreso_n_lun,'salida_n_lun':salida_n_lun,

                    'ingreso_m_mar':ingreso_m_mar,'salida_m_mar':salida_m_mar,'ingreso_alm_mar':ingreso_alm_mar,'salida_alm_mar':salida_alm_mar,
                    'ingreso_t_mar':ingreso_t_mar,'salida_t_mar':salida_t_mar,'ingreso_c_mar':ingreso_c_mar,'salida_c_mar':salida_c_mar,
                    'ingreso_n_mar':ingreso_n_mar,'salida_n_mar':salida_n_mar,

                    'ingreso_m_mier':ingreso_m_mier,'salida_m_mier':salida_m_mier,'ingreso_alm_mier':ingreso_alm_mier,'salida_alm_mier':salida_alm_mier,
                    'ingreso_t_mier':ingreso_t_mier,'salida_t_mier':salida_t_mier,'ingreso_c_mier':ingreso_c_mier,'salida_c_mier':salida_c_mier,
                    'ingreso_n_mier':ingreso_n_mier,'salida_n_mier':salida_n_mier,

                    'ingreso_m_jue':ingreso_m_jue,'salida_m_jue':salida_m_jue,'ingreso_alm_jue':ingreso_alm_jue,'salida_alm_jue':salida_alm_jue,
                    'ingreso_t_jue':ingreso_t_jue,'salida_t_jue':salida_t_jue,'ingreso_c_jue':ingreso_c_jue,'salida_c_jue':salida_c_jue,
                    'ingreso_n_jue':ingreso_n_jue,'salida_n_jue':salida_n_jue,

                    'ingreso_m_vie':ingreso_m_vie,'salida_m_vie':salida_m_vie,'ingreso_alm_vie':ingreso_alm_vie,'salida_alm_vie':salida_alm_vie,
                    'ingreso_t_vie':ingreso_t_vie,'salida_t_vie':salida_t_vie,'ingreso_c_vie':ingreso_c_vie,'salida_c_vie':salida_c_vie,
                    'ingreso_n_vie':ingreso_n_vie,'salida_n_vie':salida_n_vie,

                    'ingreso_m_sab':ingreso_m_sab,'salida_m_sab':salida_m_sab,'ingreso_alm_sab':ingreso_alm_sab,'salida_alm_sab':salida_alm_sab,
                    'ingreso_t_sab':ingreso_t_sab,'salida_t_sab':salida_t_sab,'ingreso_c_sab':ingreso_c_sab,'salida_c_sab':salida_c_sab,
                    'ingreso_n_sab':ingreso_n_sab,'salida_n_sab':salida_n_sab,

                    'ingreso_m_dom':ingreso_m_dom,'salida_m_dom':salida_m_dom,'ingreso_alm_dom':ingreso_alm_dom,'salida_alm_dom':salida_alm_dom,
                    'ingreso_t_dom':ingreso_t_dom,'salida_t_dom':salida_t_dom,'ingreso_c_dom':ingreso_c_dom,'salida_c_dom':salida_c_dom,
                    'ingreso_n_dom':ingreso_n_dom,'salida_n_dom':salida_n_dom,
                    'id_colaborador':id_colaborador,'id_horario':id_horario,'estado_registro':estado_registro_horario,
                    'id_horario_detalle_lun':id_horario_detalle_lun,'id_horario_detalle_mar':id_horario_detalle_mar,
                    'id_horario_detalle_mier':id_horario_detalle_mier,'id_horario_detalle_jue':id_horario_detalle_jue,
                    'id_horario_detalle_vie':id_horario_detalle_vie,'id_horario_detalle_sab':id_horario_detalle_sab,
                    'id_horario_detalle_dom':id_horario_detalle_dom
                },
                type:"POST",
                success:function (data) {
                    var cadena = data;
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);
                    if (validacion == 1) {
                        Swal(
                            'Actualización Denegada!',
                            mensaje,
                            'error'
                        ).then(function() { });
                    }else{
                        Swal(
                            'Actualización Exitosa!',
                            '',
                            'success'
                        ).then(function() {
                            //Limpiar_Form_Horario();
                            $("#modal_form_vertical .close").click()
                            List_Horario_Colaborador_V2();
                         });
                    }
                }
            });
        }
    }

    function Valida_Horario_V2(t) { 
        
        if($('#desde_horario'+t).val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Inicio de Horario.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_horario'+t).val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Fin de Horario.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_horario'+t).val()<$('#desde_horario'+t).val()){
            Swal(
                'Ups!',
                'Fecha de Fin de Horario no debe ser antes que la fecha de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if(!$('#ch_lun'+t).is(":checked") && !$('#ch_mar'+t).is(":checked") && !$('#ch_mier'+t).is(":checked") &&
        !$('#ch_jue'+t).is(":checked") && !$('#ch_vie'+t).is(":checked") && !$('#ch_sab'+t).is(":checked") && !$('#ch_dom'+t).is(":checked")) {
            Swal(
                'Ups!',
                'Debe seleccionar al menos un dia de semana para continuar.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if(t=='e'){
            if($('#estado_registro_horario'+t).val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar estado de Horario.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_lun'+t).is(":checked")){
            if (!$('#ch_m_lun'+t).is(":checked") && !$('#ch_alm_lun'+t).is(":checked") && !$('#ch_t_lun'+t).is(":checked")
            && !$('#ch_c_lun'+t).is(":checked") && !$('#ch_n_lun'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Lunes para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_lun'+t).is(":checked")){
                if($('#ingreso_m_lun'+t).val() === '' || $('#ingreso_m_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_lun'+t).is(":checked")){
                if($('#ingreso_alm_lun'+t).val() === '' || $('#ingreso_alm_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_lun'+t).val() === '' || $('#salida_alm_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_lun'+t).is(":checked")){
                if($('#ingreso_t_lun'+t).val() === '' || $('#ingreso_t_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_lun'+t).val() === '' || $('#salida_t_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_lun'+t).is(":checked")){
                if($('#ingreso_c_lun'+t).val() === '' || $('#ingreso_c_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_lun'+t).val() === '' || $('#salida_c_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_lun'+t).is(":checked")){
                if($('#ingreso_n_lun'+t).val() === '' || $('#ingreso_n_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_lun'+t).val() === '' || $('#salida_n_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }

        if($('#ch_mar'+t).is(":checked")){
            if (!$('#ch_m_mar'+t).is(":checked") && !$('#ch_alm_mar'+t).is(":checked") && !$('#ch_t_mar'+t).is(":checked")
            && !$('#ch_c_mar'+t).is(":checked") && !$('#ch_n_mar'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Martes para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_mar'+t).is(":checked")){
                if($('#ingreso_m_mar'+t).val() === '' || $('#ingreso_m_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_mar'+t).is(":checked")){
                if($('#ingreso_alm_mar'+t).val() === '' || $('#ingreso_alm_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_mar'+t).val() === '' || $('#salida_alm_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_mar'+t).is(":checked")){
                if($('#ingreso_t_mar'+t).val() === '' || $('#ingreso_t_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_mar'+t).val() === '' || $('#salida_t_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_mar'+t).is(":checked")){
                if($('#ingreso_c_mar'+t).val() === '' || $('#ingreso_c_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_mar'+t).val() === '' || $('#salida_c_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_mar'+t).is(":checked")){
                if($('#ingreso_n_mar'+t).val() === '' || $('#ingreso_n_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_mar'+t).val() === '' || $('#salida_n_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }

        if($('#ch_mier'+t).is(":checked")){
            if (!$('#ch_m_mier'+t).is(":checked") && !$('#ch_alm_mier'+t).is(":checked") && !$('#ch_t_mier'+t).is(":checked")
            && !$('#ch_c_mier'+t).is(":checked") && !$('#ch_n_mier'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Miércoles para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_mier'+t).is(":checked")){
                if($('#ingreso_m_mier'+t).val() === '' || $('#ingreso_m_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_mier'+t).is(":checked")){
                if($('#ingreso_alm_mier'+t).val() === '' || $('#ingreso_alm_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_mier'+t).val() === '' || $('#salida_alm_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_mier'+t).is(":checked")){
                if($('#ingreso_t_mier'+t).val() === '' || $('#ingreso_t_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_mier'+t).val() === '' || $('#salida_t_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_mier'+t).is(":checked")){
                if($('#ingreso_c_mier'+t).val() === '' || $('#ingreso_c_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_mier'+t).val() === '' || $('#salida_c_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_mier'+t).is(":checked")){
                if($('#ingreso_n_mier'+t).val() === '' || $('#ingreso_n_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_mier'+t).val() === '' || $('#salida_n_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }

        if($('#ch_jue'+t).is(":checked")){
            if (!$('#ch_m_jue'+t).is(":checked") && !$('#ch_alm_jue'+t).is(":checked") && !$('#ch_t_jue'+t).is(":checked")
            && !$('#ch_c_jue'+t).is(":checked") && !$('#ch_n_jue'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Jueves para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_jue'+t).is(":checked")){
                if($('#ingreso_m_jue'+t).val() === '' || $('#ingreso_m_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_jue'+t).is(":checked")){
                if($('#ingreso_alm_jue'+t).val() === '' || $('#ingreso_alm_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_jue'+t).val() === '' || $('#salida_alm_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_jue'+t).is(":checked")){
                if($('#ingreso_t_jue'+t).val() === '' || $('#ingreso_t_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_jue'+t).val() === '' || $('#salida_t_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_jue'+t).is(":checked")){
                if($('#ingreso_c_jue'+t).val() === '' || $('#ingreso_c_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_jue'+t).val() === '' || $('#salida_c_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_jue'+t).is(":checked")){
                if($('#ingreso_n_jue'+t).val() === '' || $('#ingreso_n_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_jue'+t).val() === '' || $('#salida_n_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }

        if($('#ch_vie'+t).is(":checked")){
            if (!$('#ch_m_vie'+t).is(":checked") && !$('#ch_alm_vie'+t).is(":checked") && !$('#ch_t_vie'+t).is(":checked")
            && !$('#ch_c_vie'+t).is(":checked") && !$('#ch_n_vie'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Viernes para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_vie'+t).is(":checked")){
                if($('#ingreso_m_vie'+t).val() === '' || $('#ingreso_m_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_vie'+t).is(":checked")){
                if($('#ingreso_alm_vie'+t).val() === '' || $('#ingreso_alm_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_vie'+t).val() === '' || $('#salida_alm_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_vie'+t).is(":checked")){
                if($('#ingreso_t_vie'+t).val() === '' || $('#ingreso_t_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_vie'+t).val() === '' || $('#salida_t_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_vie'+t).is(":checked")){
                if($('#ingreso_c_vie'+t).val() === '' || $('#ingreso_c_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_vie'+t).val() === '' || $('#salida_c_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_vie'+t).is(":checked")){
                if($('#ingreso_n_vie'+t).val() === '' || $('#ingreso_n_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_vie'+t).val() === '' || $('#salida_n_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }

        if($('#ch_sab'+t).is(":checked")){
            if (!$('#ch_m_sab'+t).is(":checked") && !$('#ch_alm_sab'+t).is(":checked") && !$('#ch_t_sab'+t).is(":checked")
            && !$('#ch_c_sab'+t).is(":checked") && !$('#ch_n_sab'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Sábado para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_sab'+t).is(":checked")){
                if($('#ingreso_m_sab'+t).val() === '' || $('#ingreso_m_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_sab'+t).is(":checked")){
                if($('#ingreso_alm_sab'+t).val() === '' || $('#ingreso_alm_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_sab'+t).val() === '' || $('#salida_alm_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_sab'+t).is(":checked")){
                if($('#ingreso_t_sab'+t).val() === '' || $('#ingreso_t_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_sab'+t).val() === '' || $('#salida_t_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_sab'+t).is(":checked")){
                if($('#ingreso_c_sab'+t).val() === '' || $('#ingreso_c_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_sab'+t).val() === '' || $('#salida_c_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_sab'+t).is(":checked")){
                if($('#ingreso_n_sab'+t).val() === '' || $('#ingreso_n_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_sab'+t).val() === '' || $('#salida_n_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }

        if($('#ch_dom'+t).is(":checked")){
            if (!$('#ch_m_dom'+t).is(":checked") && !$('#ch_alm_dom'+t).is(":checked") && !$('#ch_t_dom'+t).is(":checked")
            && !$('#ch_c_dom'+t).is(":checked") && !$('#ch_n_dom'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Domingo para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_dom'+t).is(":checked")){
                if($('#ingreso_m_dom'+t).val() === '' || $('#ingreso_m_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_dom'+t).is(":checked")){
                if($('#ingreso_alm_dom'+t).val() === '' || $('#ingreso_alm_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_dom'+t).val() === '' || $('#salida_alm_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_dom'+t).is(":checked")){
                if($('#ingreso_t_dom'+t).val() === '' || $('#ingreso_t_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_dom'+t).val() === '' || $('#salida_t_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_dom'+t).is(":checked")){
                if($('#ingreso_c_dom'+t).val() === '' || $('#ingreso_c_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_dom'+t).val() === '' || $('#salida_c_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_dom'+t).is(":checked")){
                if($('#ingreso_n_dom'+t).val() === '' || $('#ingreso_n_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_dom'+t).val() === '' || $('#salida_n_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        
        return true;
    }

    function Habilitar_Dia(v){
        $("#ingreso_m_"+v).val('');
        $("#salida_m_"+v).val('');
        $("#ingreso_alm_"+v).val('');
        $("#salida_alm_"+v).val('');
        $("#ingreso_t_"+v).val('');
        $("#salida_t_"+v).val('');
        $("#ingreso_c_"+v).val('');
        $("#salida_c_"+v).val('');
        $("#ingreso_n_"+v).val('');
        $("#salida_n_"+v).val('');

        $('#ch_m_'+v).prop('checked', false);
        $('#ch_alm_'+v).prop('checked', false);
        $('#ch_t_'+v).prop('checked', false);
        $('#ch_c_'+v).prop('checked', false);
        $('#ch_n_'+v).prop('checked', false);

        $("#ingreso_m_"+v).prop('disabled', true);
        $("#salida_m_"+v).prop('disabled', true);
        $("#ingreso_alm_"+v).prop('disabled', true);
        $("#salida_alm_"+v).prop('disabled', true);
        $("#ingreso_t_"+v).prop('disabled', true);
        $("#salida_t_"+v).prop('disabled', true);
        $("#ingreso_c_"+v).prop('disabled', true);
        $("#salida_c_"+v).prop('disabled', true);
        $("#ingreso_n_"+v).prop('disabled', true);
        $("#salida_n_"+v).prop('disabled', true);
        if($('#ch_'+v).is(":checked")){
            var div1 = document.getElementById("li_"+v);
            var div2 = document.getElementById("div_"+v);
            div1.classList.remove("oculto");
            div2.style.display = "block";
        }else{
            var div1 = document.getElementById("li_"+v);
            var div2 = document.getElementById("div_"+v);
            div1.classList.add("oculto");
            div2.style.display = "none";
        }
    }

    function Habilitar_Rango(v){
        $("#ingreso_"+v).val('');
        $("#salida_"+v).val('');
        if($('#ch_'+v).is(":checked")){
            $("#ingreso_"+v).prop('disabled', false);
            $("#salida_"+v).prop('disabled', false);
        }else{
            $("#ingreso_"+v).prop('disabled', true);
            $("#salida_"+v).prop('disabled', true);
        }
    }

    function List_Horario_Colaborador_V2(){
        var id_colaborador=$('#id_colaborador').val();
        Cargando();
        var url="<?php echo site_url(); ?>AppIFV/List_Horario_Colaborador_V2/"+id_colaborador;
        
        $.ajax({
            url: url,
            type:"POST",
            success:function (data) {
                $('#lista_horario').html(data);
            }
        });
    }
    function Delete_Horario_Colabordor_V2(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Horario_Colabordor_V2";
        
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
                    data: {'id_horario':id},
                    success:function () {
                        List_Horario_Colaborador_V2();
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>