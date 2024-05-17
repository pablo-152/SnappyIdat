<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<style>
    .tamanio{
        height: 20px;
        width: 20px;
    }

    .estilo_boton{
        font-weight:bold;
        height:32px;
        width:100px;
        padding:5px;
    }

    .verde{
        color:#FFF;
        background-color:#92D050;
    }

    .rojo{
        color:#FFF;
        background-color:#C00000;
    }

    .verde:hover, .verde:focus{
        color:#FFF;
    }

    .rojo:hover, .rojo:focus{
        color:#FFF;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Matrícula (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('BabyLeaders/Matricula') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="v_datos_alumno" value="<?php echo count($datos_alumno); ?>">
    <?php if(count($datos_alumno)>0){ ?>
        <?php if($datos_alumno[0]['n_doc_prin']!=""){ ?>
            <input type="hidden" id="v_datos_tutor" value="1">
        <?php }else{ ?>
            <input type="hidden" id="v_datos_tutor" value="0">
        <?php } ?>
    <?php }else{ ?>
        <input type="hidden" id="v_datos_tutor" value="0">
    <?php } ?>
    <?php if(count($datos_alumno)>0){ ?>
        <?php if($datos_alumno[0]['donde_conocio']>0){ ?>
            <input type="hidden" id="v_datos_informacion" value="1">
        <?php }else{ ?>
            <input type="hidden" id="v_datos_informacion" value="0">
        <?php } ?>
    <?php }else{ ?>
        <input type="hidden" id="v_datos_informacion" value="0">
    <?php } ?>
    <input type="hidden" id="v_datos_documento" value="<?php echo count($datos_documento); ?>">
    <input type="hidden" id="v_datos_matricula" value="<?php echo count($datos_matricula); ?>">
</div>

<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Datos del Alumno</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div id="div_datos_personales" class="content-group-lg">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Tipo de Doc.:</label>
                        <div class="col">
                            <select class="form-control" id="id_tipo_documento_alum" name="id_tipo_documento_alum">
                                <option value="0">Seleccione</option>
                                <option value="1" selected>DNI</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Nr. Doc.:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="n_doc_alum" name="n_doc_alum" maxlength="8" placeholder="Ingresar Nr. Doc.">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Fecha Nac.:</label>
                        <div class="col">
                            <input type="date" class="form-control" id="fec_nac_alum" name="fec_nac_alum" onblur="Edad();">
                        </div>
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Edad:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="edad_alum" placeholder="Ingresar Edad" readonly>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Sexo:</label>
                        <div class="col">
                            <select class="form-control" id="id_sexo_alum" name="id_sexo_alum">
                                <option value="0">Seleccione</option>
                                <option value="1">Femenino</option>
                                <option value="2">Masculino</option>
                            </select>
                        </div>
                    </div>
                </div>
                    
                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Pat.:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="apater_alum" name="apater_alum" placeholder="Ingresar Apellido(s) Pat.">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Mat.:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="amater_alum" name="amater_alum" placeholder="Ingresar Apellido(s) Mat.">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="text-bold">Nombre(s):</label>
                        <div class="col">
                            <input type="text" class="form-control" id="nombres_alum" name="nombres_alum" placeholder="Ingresar Nombre(s)">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Dirección:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="direccion_alum" name="direccion_alum" placeholder="Ingresar Dirección">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Departamento:</label>
                        <div class="col">
                            <select class="form-control" id="id_departamento_alum" name="id_departamento_alum" onchange="Provincia_Alum();">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_departamento as $list){ ?>
                                    <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Provincia:</label>
                        <div id="mprovincia" class="col">
                            <select class="form-control" id="id_provincia_alum" name="id_provincia_alum" onchange="Distrito_Alum();">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Distrito:</label>
                        <div id="mdistrito" class="col">
                            <select class="form-control" id="id_distrito_alum" name="id_distrito_alum">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="text-bold">Correo Corporativo:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="correo_corporativo_alum" name="correo_corporativo_alum" placeholder="Ingresar Correo Corporativo">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Datos_Alumno();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title">Datos del Tutor</h5>
            <?php if(count($datos_alumno)>0){ if($datos_alumno[0]['n_doc_alum']!=""){ ?>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            <?php } } ?>
        </div>

        <div class="panel-body">
            <div id="div_datos_tutor" class="content-group-lg">
                <div class="col-md-12" style="margin-bottom:10px;">
                    <label class="control-label text-bold">TUTOR (Principal)</label>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Tipo de Doc.:</label>
                        <div class="col">
                            <select class="form-control" id="id_tipo_documento_prin" name="id_tipo_documento_prin">
                                <option value="0">Seleccione</option>
                                <option value="1" selected>DNI</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Nr. Doc.:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="n_doc_prin" name="n_doc_prin" maxlength="8" placeholder="Ingresar Nr. Doc.">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Fecha Nac.:</label>
                        <div class="col">
                            <input type="date" class="form-control" id="fec_nac_prin" name="fec_nac_prin">
                        </div>
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Parentesco:</label>
                        <div class="col">
                            <select class="form-control" id="parentesco_prin" name="parentesco_prin">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_parentesco as $list){ ?>
                                    <option value="<?php echo $list['id_parentesco']; ?>"><?php echo $list['nom_parentesco']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Pat.:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="apater_prin" name="apater_prin" placeholder="Ingresar Apellido(s) Pat.">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Mat.:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="amater_prin" name="amater_prin" placeholder="Ingresar Apellido(s) Mat.">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="text-bold">Nombre(s):</label>
                        <div class="col">
                            <input type="text" class="form-control" id="nombres_prin" name="nombres_prin" placeholder="Ingresar Nombre(s)">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Vive Alumno(a):</label>
                        <div class="col">
                            <input type="checkbox" class="tamanio" id="vive_alumno_prin" name="vive_alumno_prin" value="1" onclick="Vive_Alumno_Prin();">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Dirección:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="direccion_prin" name="direccion_prin" placeholder="Ingresar Dirección">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Departamento:</label>
                        <div class="col">
                            <select class="form-control" id="id_departamento_prin" name="id_departamento_prin" onchange="Provincia_Prin();">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_departamento as $list){ ?>
                                    <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Provincia:</label>
                        <div id="mprinprovincia" class="col">
                            <select class="form-control" id="id_provincia_prin" name="id_provincia_prin" onchange="Distrito_Prin();">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Distrito:</label>
                        <div id="mprindistrito" class="col">
                            <select class="form-control" id="id_distrito_prin" name="id_distrito_prin">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Celular:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="celular_prin" name="celular_prin" maxlength="9" placeholder="Ingresar Celular">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Teléfono Casa:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="telf_casa_prin" name="telf_casa_prin" maxlength="9" placeholder="Ingresar Teléfono Casa">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Correo Personal:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="correo_personal_prin" name="correo_personal_prin" placeholder="Ingresar Correo Personal">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Ocupación:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="ocupacion_prin" name="ocupacion_prin" placeholder="Ingresar Ocupación">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Centro de Empleo:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="centro_empleo_prin" name="centro_empleo_prin" placeholder="Ingresar Centro de Empleo">
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
                    <label class="control-label text-bold">TUTOR (Secundario)</label>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Tipo de Doc.:</label>
                        <div class="col">
                            <select class="form-control" id="id_tipo_documento_secu" name="id_tipo_documento_secu">
                                <option value="0">Seleccione</option>
                                <option value="1" selected>DNI</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Nr. Doc.:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="n_doc_secu" name="n_doc_secu" maxlength="8" placeholder="Ingresar Nr. Doc.">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Fecha Nac.:</label>
                        <div class="col">
                            <input type="date" class="form-control" id="fec_nac_secu" name="fec_nac_secu">
                        </div>
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Parentesco:</label>
                        <div class="col">
                            <select class="form-control" id="parentesco_secu" name="parentesco_secu">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_parentesco as $list){ ?>
                                    <option value="<?php echo $list['id_parentesco']; ?>"><?php echo $list['nom_parentesco']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Pat.:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="apater_secu" name="apater_secu" placeholder="Ingresar Apellido(s) Pat.">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Mat.:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="amater_secu" name="amater_secu" placeholder="Ingresar Apellido(s) Mat.">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="text-bold">Nombre(s):</label>
                        <div class="col">
                            <input type="text" class="form-control" id="nombres_secu" name="nombres_secu" placeholder="Ingresar Nombre(s)">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Vive Alumno(a):</label>
                        <div class="col">
                            <input type="checkbox" class="tamanio" id="vive_alumno_secu" name="vive_alumno_secu" value="1" onclick="Vive_Alumno_Secu();">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Dirección:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="direccion_secu" name="direccion_secu" placeholder="Ingresar Dirección">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Departamento:</label>
                        <div class="col">
                            <select class="form-control" id="id_departamento_secu" name="id_departamento_secu" onchange="Provincia_Secu();">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_departamento as $list){ ?>
                                    <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Provincia:</label>
                        <div id="msecuprovincia" class="col">
                            <select class="form-control" id="id_provincia_secu" name="id_provincia_secu" onchange="Distrito_Secu();">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="text-bold">Distrito:</label>
                        <div id="msecudistrito" class="col">
                            <select class="form-control" id="id_distrito_secu" name="id_distrito_secu">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Celular:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="celular_secu" name="celular_secu" maxlength="9" placeholder="Ingresar Celular">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Teléfono Casa:</label>
                        <div class="col">
                            <input type="text" class="form-control solo_numeros" id="telf_casa_secu" name="telf_casa_secu" maxlength="9" placeholder="Ingresar Teléfono Casa">
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Correo Personal:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="correo_personal_secu" name="correo_personal_secu" placeholder="Ingresar Correo Personal">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Ocupación:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="ocupacion_secu" name="ocupacion_secu" placeholder="Ingresar Ocupación">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Centro de Empleo:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="centro_empleo_secu" name="centro_empleo_secu" placeholder="Ingresar Centro de Empleo">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Datos_Tutor();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title">Información</h5>
            <?php if(count($datos_alumno)>0){ if($datos_alumno[0]['n_doc_prin']!=""){ ?>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            <?php } } ?>
        </div>

        <div class="panel-body">
            <div id="div_datos_informacion" class="content-group-lg">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Donde nos conocio:</label>
                        <div class="col">
                            <select class="form-control" id="donde_conocio" name="donde_conocio">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_medio as $list){ ?>
                                    <option value="<?php echo $list['id_medios']; ?>"><?php echo $list['nom_medio']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Datos_Informacion();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title">Documentos</h5>
            <?php if(count($datos_alumno)>0){ if($datos_alumno[0]['donde_conocio']>0){ ?>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            <?php } } ?>
        </div>

        <div class="panel-body">
            <div id="div_datos_documento" class="content-group-lg">
                <div class="col-md-12 row">
                    <?php foreach($list_documento as $list){ ?>
                        <div class="form-group col-md-3">
                            <label class="control-label text-bold"><?php echo $list['nom_documento']; ?>:</label>
                            <div class="col">
                                <input type="file" id="documento_<?php echo $list['id_documento']; ?>" name="documento_<?php echo $list['id_documento']; ?>" onchange="Validar_Extension_Documento('<?php echo $list['id_documento']; ?>');">
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Datos_Documento();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div> 

    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title">Matrícula</h5>
            <?php if(count($datos_documento)>0){ ?>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <div class="panel-body">
            <div id="div_datos_matricula" class="content-group-lg">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Grado:</label>
                        <div class="col">
                            <select class="form-control" id="id_grado" name="id_grado" onchange="Traer_Producto();">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_grado as $list){ ?>
                                    <option value="<?php echo $list['id_grado']; ?>"><?php echo $list['nom_grado']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Producto:</label>
                        <div id="mproducto" class="col">
                            <select class="form-control" id="id_producto" name="id_producto">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Fecha:</label>
                        <div class="col">
                            <input type="date" class="form-control" id="fec_matricula" name="fec_matricula">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-8">
                        <label class="control-label text-bold">Observaciones:</label>
                        <div class="col">
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Datos_Matricula();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title">Confirmación</h5>
            <?php if(count($datos_matricula)>0){ if($datos_matricula[0]['id_grado']>0){ ?>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            <?php } } ?>
        </div>

        <div class="panel-body">
            <div id="div_datos_confirmacion" class="content-group-lg">
                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Confirmar celular Tutor Principal:</label>
                        <div class="col">
                            <button type="button" class="btn rojo estilo_boton" onclick="Enviar_Sms();">Enviar SMS</button>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Código:</label>
                        <div class="col">
                            <input type="text" class="form-control" id="codigo_confirmacion" name="codigo_confirmacion" maxlength="4" placeholder="Código">
                        </div>
                    </div>

                    <div class="form-group col-md-2 text-center">
                        <button class="btn verde estilo_boton">Confirmado</button>
                    </div>
                </div>   

                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Hoja de Matrícula:</label>
                        <div class="col">
                            <button type="button" class="btn rojo estilo_boton" onclick="Pdf_Hoja_Matricula();">Descargar</button>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <input type="file" id="hoja_matricula" name="hoja_matricula" onchange="Validar_Extension_Hoja_Matricula();">
                    </div>

                    <div class="form-group col-md-2 text-center">
                        <button class="btn verde estilo_boton">Confirmado</button>
                    </div>
                </div>   

                <div class="col-md-12 row">
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Contrato:</label>
                    </div>

                    <div class="form-group col-md-3">
                        <input type="file" id="contrato" name="contrato" onchange="Validar_Extension_Contrato();">
                    </div>

                    <div class="form-group col-md-2 text-center">
                        <button class="btn verde estilo_boton">Confirmado</button>
                    </div>
                </div>  
                
                <div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
                    <label class="control-label text-bold">Informado al Apoderado</label>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Reg. Interno:</label>
                        <div class="col">
                            <select class="form-control" id="reglamento_interno" name="reglamento_interno">
                                <option value="0">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2" selected>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Forma de Pago:</label>
                        <div class="col">
                            <select class="form-control" id="forma_pago" name="forma_pago">
                                <option value="0">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2" selected>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Cero Efectivo:</label>
                        <div class="col">
                            <select class="form-control" id="cero_efectivo" name="cero_efectivo">
                                <option value="0">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2" selected>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Contactos:</label>
                        <div class="col">
                            <select class="form-control" id="contacto" name="contacto">
                                <option value="0">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="2" selected>No</option>
                            </select>
                        </div>
                    </div>
                </div>   

                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Datos_Confirmacion();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="Insert_Matricula();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#alumnos").addClass('active');
        $("#halumnos").attr('aria-expanded', 'true');
        $("#matriculas").addClass('active');
		document.getElementById("ralumnos").style.display = "block";

        if($("#v_datos_alumno").val()>0){
            Traer_Datos_Alumno();
        }

        if($("#v_datos_tutor").val()>0){
            Traer_Datos_Tutor();
        }

        if($("#v_datos_informacion").val()>0){
            Traer_Datos_Informacion();
        }

        if($("#v_datos_documento").val()>0){
            Traer_Datos_Documento();
        }

        if($("#v_datos_matricula").val()>0){
            Traer_Datos_Matricula();
            Traer_Datos_Confirmacion();
        }
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Edad(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var fec_nac = $('#fec_nac_alum').val().split('-');
        var currentTime = new Date();
        var anio_actual = currentTime.getFullYear();

        var edad = anio_actual-Number(fec_nac[0]);
        $('#edad_alum').val(edad);
    }

    function Provincia_Alum(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Busca_Provincia";
        var id_departamento = $('#id_departamento_alum').val();
        var tipo = 1;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'tipo':tipo},
            success: function(data){
                $('#mprovincia').html(data);
                $('#mdistrito').html('<select class="form-control" id="id_distrito_alum" name="id_distrito_alum"><option value="0">Seleccione</option></select>');
            }
        });
    }

    function Distrito_Alum(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Busca_Distrito";
        var id_departamento = $('#id_departamento_alum').val();
        var id_provincia = $('#id_provincia_alum').val();
        var tipo = 1;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'tipo':tipo},
            success: function(data){
                $('#mdistrito').html(data);
            }
        });
    }

    function Vive_Alumno_Prin(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });  
        
        if($('#vive_alumno_prin').is(':checked')) {
            var direccion = $('#direccion_alum').val();
            var id_departamento = $('#id_departamento_alum').val();
            var id_provincia = $('#id_provincia_alum').val();
            var id_distrito = $('#id_distrito_alum').val();

            $('#direccion_prin').val(direccion);
            $('#id_departamento_prin').val(id_departamento);
            Traer_Provincia_Prin();
            Traer_Distrito_Prin();
        }else{
            $('#direccion_prin').val('');
            $('#id_departamento_prin').val(0);
            $('#mprinprovincia').html('<select class="form-control" id="id_provincia_prin" name="id_provincia_prin"><option value="0">Seleccione</option></select>');
            $('#mprindistrito').html('<select class="form-control" id="id_distrito_prin" name="id_distrito_prin"><option value="0">Seleccione</option></select>');
        }
    }

    function Traer_Provincia_Prin(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Provincia";
        var id_departamento = $('#id_departamento_alum').val();
        var id_provincia = $('#id_provincia_alum').val();
        var tipo = 1;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'tipo':tipo},
            success: function(data){
                $('#mprinprovincia').html(data);
            }
        });
    }

    function Traer_Distrito_Prin(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Distrito";
        var id_departamento = $('#id_departamento_alum').val();
        var id_provincia = $('#id_provincia_alum').val();
        var id_distrito = $('#id_distrito_alum').val();
        var tipo = 1;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'id_distrito':id_distrito,'tipo':tipo},
            success: function(data){
                $('#mprindistrito').html(data);
            }
        });
    }
    
    function Provincia_Prin(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Busca_Provincia";
        var id_departamento = $('#id_departamento_prin').val();
        var tipo = 3;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'tipo':tipo},
            success: function(data){
                $('#mprinprovincia').html(data);
                $('#mprindistrito').html('<select class="form-control" id="id_distrito_prin" name="id_distrito_prin"><option value="0">Seleccione</option></select>');
            }
        });
    }

    function Distrito_Prin(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Busca_Distrito";
        var id_departamento = $('#id_departamento_prin').val();
        var id_provincia = $('#id_provincia_prin').val();
        var tipo = 3;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'tipo':tipo},
            success: function(data){
                $('#mprindistrito').html(data);
            }
        });
    }

    function Vive_Alumno_Secu(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });  
        
        if($('#vive_alumno_secu').is(':checked')) {
            var direccion = $('#direccion_alum').val();
            var id_departamento = $('#id_departamento_alum').val();
            var id_provincia = $('#id_provincia_alum').val();
            var id_distrito = $('#id_distrito_alum').val();

            $('#direccion_secu').val(direccion);
            $('#id_departamento_secu').val(id_departamento);
            Traer_Provincia_Secu();
            Traer_Distrito_Secu();
        }else{
            $('#direccion_secu').val('');
            $('#id_departamento_secu').val(0);
            $('#msecuprovincia').html('<select class="form-control" id="id_provincia_secu" name="id_provincia_secu"><option value="0">Seleccione</option></select>');
            $('#msecudistrito').html('<select class="form-control" id="id_distrito_secu" name="id_distrito_secu"><option value="0">Seleccione</option></select>');
        }
    }

    function Traer_Provincia_Secu(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Provincia";
        var id_departamento = $('#id_departamento_alum').val();
        var id_provincia = $('#id_provincia_alum').val();
        var tipo = 2;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'tipo':tipo},
            success: function(data){
                $('#msecuprovincia').html(data);
            }
        });
    }

    function Traer_Distrito_Secu(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Distrito";
        var id_departamento = $('#id_departamento_alum').val();
        var id_provincia = $('#id_provincia_alum').val();
        var id_distrito = $('#id_distrito_alum').val();
        var tipo = 2;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'id_distrito':id_distrito,'tipo':tipo},
            success: function(data){
                $('#msecudistrito').html(data);
            }
        });
    }

    function Provincia_Secu(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Busca_Provincia";
        var id_departamento = $('#id_departamento_secu').val();
        var tipo = 4;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'tipo':tipo},
            success: function(data){
                $('#msecuprovincia').html(data);
                $('#msecudistrito').html('<select class="form-control" id="id_distrito_secu" name="id_distrito_secu"><option value="0">Seleccione</option></select>');
            }
        });
    }

    function Distrito_Secu(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Busca_Distrito";
        var id_departamento = $('#id_departamento_secu').val();
        var id_provincia = $('#id_provincia_secu').val();
        var tipo = 4;

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia,'tipo':tipo},
            success: function(data){
                $('#msecudistrito').html(data);
            }
        });
    }

    function Traer_Producto(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Producto";
        var id_grado = $('#id_grado').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_grado':id_grado},
            success: function(data){
                $('#mproducto').html(data);
            }
        });
    }

    function Validar_Extension_Documento(id){
        var archivoInput = document.getElementById('documento_'+id);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpeg|.png|.jpg|.pdf)$/i;
  
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivos con extensiones .jpeg, .png, .jpg y .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            return true;            
        }
    }

    function Validar_Extension_Hoja_Matricula(){
        var archivoInput = document.getElementById('hoja_matricula');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpeg|.png|.jpg|.pdf)$/i;
  
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivos con extensiones .jpeg, .png, .jpg y .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            return true;            
        }
    }

    function Validar_Extension_Contrato(){
        var archivoInput = document.getElementById('contrato');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpeg|.png|.jpg|.pdf)$/i;
  
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivos con extensiones .jpeg, .png, .jpg y .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            return true;            
        }
    }

    function Insert_Datos_Alumno(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Datos_Alumno";

        if (Valida_Datos_Alumno()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Alumno();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }

    function Update_Datos_Alumno(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Datos_Alumno";

        if (Valida_Datos_Alumno()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Alumno();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }

    function Valida_Datos_Alumno() {
        if($('#id_tipo_documento_alum').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Documento de Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#n_doc_alum').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nr. Doc. de Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Traer_Datos_Alumno(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Datos_Alumno";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#div_datos_personales').html(resp);
            }
        });
    }

    function Insert_Datos_Tutor(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Datos_Tutor";

        if (Valida_Datos_Tutor()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Tutor();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });     
        }  
    }

    function Update_Datos_Tutor(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Datos_Tutor";

        if (Valida_Datos_Tutor()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Tutor();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }
    
    function Valida_Datos_Tutor() {
        if($('#id_tipo_documento_prin').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Documento de Tutor Principal.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#n_doc_prin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nr. Doc. de Tutor Principal.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Traer_Datos_Tutor(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Datos_Tutor";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#div_datos_tutor').html(resp);
            }
        });
    }

    function Insert_Datos_Informacion(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Datos_Informacion";

        if (Valida_Datos_Informacion()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Informacion();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }

    function Update_Datos_Informacion(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Datos_Informacion";

        if (Valida_Datos_Informacion()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Informacion();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }

    function Valida_Datos_Informacion() {
        if($('#donde_conocio').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Donde nos conocio.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Traer_Datos_Informacion(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Datos_Informacion";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#div_datos_informacion').html(resp);
            }
        });
    }

    function Insert_Datos_Documento(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Datos_Documento";

        if (Valida_Datos_Documento()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Documento();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }

    function Update_Datos_Documento(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Datos_Documento";

        if (Valida_Datos_Documento()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Documento();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });       
        }
    }

    function Valida_Datos_Documento() {
        return true;
    }

    function Traer_Datos_Documento(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Datos_Documento";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#div_datos_documento').html(resp);
            }
        });
    }

    function Descargar_Archivo_Documento(id_documento){
        window.location.replace("<?php echo site_url(); ?>BabyLeaders/Descargar_Archivo_Documento/"+id_documento);
    }

    function Insert_Datos_Matricula(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Datos_Matricula";

        if (Valida_Datos_Matricula()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Matricula();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            }); 
        }      
    }

    function Update_Datos_Matricula(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Datos_Matricula";

        if (Valida_Datos_Matricula()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        //Traer_Datos_Matricula();
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Modal_Matricula";
                    });
                }
            });      
        } 
    }

    function Valida_Datos_Matricula() {
        if($('#id_grado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_producto').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Producto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Traer_Datos_Matricula(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Datos_Matricula";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#div_datos_matricula').html(resp);
            }
        });
    }

    function Insert_Datos_Confirmacion(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Datos_Confirmacion";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    'Registro Exitoso!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Traer_Datos_Confirmacion();
                });
            }
        });       
    }

    function Update_Datos_Confirmacion(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Datos_Confirmacion";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Traer_Datos_Confirmacion();
                });
            }
        });       
    }

    function Traer_Datos_Confirmacion(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Traer_Datos_Confirmacion";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                $('#div_datos_confirmacion').html(resp);
            }
        });
    }

    function Descargar_Archivo_Matricula(orden){
        window.location.replace("<?php echo site_url(); ?>BabyLeaders/Descargar_Archivo_Matricula/"+orden);
    }

    function Enviar_Sms(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Enviar_Sms";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                if(resp=="error"){
                    Swal({
                        title: 'Envío Denegado',
                        text: "¡Debe registrar Datos del Tutor!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(resp=="numero"){
                    Swal({
                        title: 'Envío Denegado',
                        text: "¡Debe ingresar Celular de Tutor Principal!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Swal({
                        title: 'Envío Exitoso',
                        text: 'Haga clic en el botón!',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }
            }
        });
    }

    function Pdf_Hoja_Matricula(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "<?php echo site_url(); ?>BabyLeaders/Valida_Pdf_Hoja_Matricula";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(resp){
                if(resp=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Debe registrar Datos del Alumno y Matrícula!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    window.open('<?php echo site_url(); ?>BabyLeaders/Pdf_Hoja_Matricula', '_blank');
                }
            }
        });
    }

    function Insert_Matricula(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Matricula";

        if(Validar_Insert_Matricula()){
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="alumno"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Debe ingresar Datos de Alumno!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="matricula"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Debe ingresar Datos de Matrícula!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Debe ingresar Datos de Alumno y Matrícula!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>BabyLeaders/Matricula";
                        });
                    }
                }
            });       
        }
    }

    function Validar_Insert_Matricula() {
        return true;
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>