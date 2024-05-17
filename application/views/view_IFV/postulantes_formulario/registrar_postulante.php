<?php
$sesion = $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') or exit('No direct script access allowed');
?>

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
        .tabset > input:nth-child(13):checked ~ .tab-panels > .tab-panel:nth-child(7),
        .tabset > input:nth-child(15):checked ~ .tab-panels > .tab-panel:nth-child(8),
        .tabset > input:nth-child(17):checked ~ .tab-panels > .tab-panel:nth-child(9),
        .tabset > input:nth-child(19):checked ~ .tab-panels > .tab-panel:nth-child(10),
        .tabset > input:nth-child(21):checked ~ .tab-panels > .tab-panel:nth-child(11) {
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
            width: 6.3%;
            max-width: 110px;
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
            border-color: #32b732 !important;
            color: #fff;
            background-color: #32b732 !important;
        }

        .label2 {
            padding: 15px 25px !important;
        }

        .nuevaetiqueta {
            display: flex;
            align-items: center; /* Centra verticalmente */
            justify-content: center; /* Centra horizontalmente */
            background-color: orange;
            color: white;
            border-radius: 10px;
            padding: 5px 50px; /* Ajusta el padding vertical para controlar la altura */
            width: fit-content;
            height: 35px; /* Ajusta la altura según necesites */
        }

        .etiqueta {
            display: flex;
            align-items: center; /* Centra verticalmente */
            justify-content: center;
            font-weight: bold !important;
            text-align: left;
            width: fit-content;
            margin: 18px 0px 10px 0px;
            border-radius: 5px;
            padding: 5px 30px;
            background: #ef8903;
            color: white;
            height: 35px;
        }
        .panel-acordeon {
            padding: 0px 20px 0px;
            /*display: none;*/
            background-color: #f0ecec;
            /*overflow: hidden;*/
            margin: 0px 0px 20px 0;
            border-radius: 0px 0px 15px 15px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            /*max-height: 300px;*/
            /*overflow: hidden;*/
        }

        .panel-acordeon-seccion {
            display: flex;

        }

        .border,
        select {
            border-radius: 5px !important;
        }

        input[type='text'],
        input[type='date'],
        select {
            /* border: 1px solid #b3b3b3 !important;*/
        }

        input:focus,
        input[type='text']:focus,
        select:focus,
        select:hover {
            box-shadow: 0 0 0 0 #b3b3b3, inset 0 0 0 0 #b3b3b3 !important;
            border: 1px solid #b3b3b3 !important;
        }

        .swal2-header{
            align-self: center !important;
        }

        .swal2-modal .swal2-content {
            color:  #4d4d4d !important;
        }
        .container-input > label{
            text-align: center;
        }

        .container-input {
            /*text-align: center;
            background: #282828;*/
            /*border-top: 5px solid #c39f77;*/
            /*padding: 50px 0;*/
            border-radius: 15px;
            /*width: 100%;*/
            margin: 0 auto;
            /*margin-bottom: 20px;*/
        }

        .nombre_archivo{
            display: block;
            margin-top: -18px;
            text-align: right;
            margin-left: -75px;
        }


        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile + label {
            width: 115px;
            font-size: 1.25rem;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;
            padding: 1px 2px;
            border-radius: 4px;
        }

        .inputfile + label svg {
            width: 1em;
            height: 1em;
            vertical-align: middle;
            fill: currentColor;
            margin-top: -0.25em;
            margin-right: 0.25em;
        }

        .iborrainputfile {
            font-size:20px;
            font-weight:normal;
            font-family: 'Lato';
        }

        .inputfile-1 + label {
            color: #fff;
            background-color: #969696;
        }

        .inputfile-1:focus + label,
        .inputfile-1.has-focus + label,
        .inputfile-1 + label:hover {
            background-color: #606060;
        }
        .responsive{
            display: flex !important;
        }

        .container {
            cursor: pointer;
            margin-left: -30% !important;
            margin-right: -120px !important;
            min-width: 30px;
        }

        .adicional {
            cursor: pointer;
            margin-left: 0 !important;
            margin-right: 0  !important;
        }

        .container input {
            display: none;
        }

        .container svg {
            overflow: visible;
        }
        .hidden {
            display: none;
        }

        .text-right {
            text-align: right !important;
        }

        .col-md-1{
            min-height: 1px;
            padding-left: 10px;
        }
    </style>

    <form id="formulario_registrar" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b>Registrar Postulante</b></h4>
        </div>

        <div class="container-fluid">
            <div class="panel-body">
                <div class="col-md-12 row">
                    <div class="form-group col-md-4 ">
                        <h4 class="panel-title"><b>Datos del Postulante</b></h4>
                    </div>
                </div>

                <div class="col-md-12 row etiqueta">
                    <h4 title="Contactos"><b>Contactos</b></h4>
                </div>
                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Correo" class="control-label text-bold">Correo:</label>
                    </div>
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control border" id="cont_email_admision" name="cont_email_admision">
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Tipo Documento Alumno" class="control-label text-bold">T.&nbsp;Doc.:</label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="tipo_doc_e" name="tipo_doc_e">
                            <option value="5">Seleccione</option>
                            <?php foreach ($list_tipo_doc as $list) { ?>
                                <option value="<?php echo $list['id_confgen']; ?>" <?php /*if ($get_id[0]['cont_tipo_doc_admision'] == $list['id_confgen']) {
                                    echo('Selected');
                                }*/ ?>><?php echo $list['nom_confgen']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Nro Documento Alumno" class="control-label text-bold">DNI :</label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" id="dni_postulante" name=" dni_postulante" class="form-control border">
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Celular" class="control-label text-bold">Celular:</label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control border" id="cont_celular_admision" name="cont_celular_admision">
                    </div>
                </div>

                <div class="col-md-12 row etiqueta">
                    <h4 title="Contactos"><b>Datos del Alumno(a):</b></h4>
                </div>
                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Apellido Paterno Alumno"
                               class="control-label text-bold">Ap.&nbsp;Pat.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control border" id="alum_apepat_admision" name="alum_apepat_admision">
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Apellido Materno Alumno"
                               class="control-label text-bold">Ap.&nbsp;Mat.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control border" id="alum_apemat_admision" name="alum_apemat_admision">
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Nombres Alumno" class="control-label text-bold">Nomb.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control border" id="alum_nombre_admision" name="alum_nombre_admision">
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Sexo" class="control-label text-bold">Sexo:</label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="sexo_e" name="sexo_e">
                            <option value="5">Seleccione</option>
                            <?php foreach ($list_sexo as $list) { ?>
                                <option value="<?php echo $list['id_confgen']; ?>" <?php /*if ($get_id[0]['alum_sexo_admision'] == $list['id_confgen']) {
                                    echo('Selected');
                                }*/ ?>><?php echo $list['nom_confgen']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Fecha Nacimiento" class="control-label text-bold">Fec.&nbsp;Na.:</label>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="date"
                               max="<?php echo (new DateTime())->sub(new DateInterval('P16Y'))->format('Y-m-d'); ?>"
                               class="form-control border" id="fechaNacimiento" name="fechaNacimiento" onchange="Verificar_Edad(this.value)"
                               placeholder="Fecha de Nacimiento:">
                    </div>
                </div>

                <div class="col-md-12 row etiqueta">
                    <h4 class="panel-title"><b>Domicilio</b></h4>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-sm-1 text-right">
                        <label title="Domicilio Postulante:" class="control-label text-bold">Dom.: </label>
                    </div>
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control border" id="domi_dir_admision" name="domi_dir_admision">
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Departamento Domicilio"
                               class="control-label text-bold">Depa.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="admi_departamento_admision" name="admi_departamento_admision"
                                onchange="Listar_Provincia();">
                            <option value="0">Seleccione</option>
                            <?php foreach ($list_departamento as $list) { ?>
                                <option value="<?php echo $list['id_departamento']; ?>" <?php /*if ($get_id[0]['id_departamento_dom'] == $list['id_departamento']) {
                                    echo "selected";
                                }*/ ?>><?php echo $list['nombre_departamento']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Provincia Domicilio" class="control-label text-bold">Prov.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="cod_provincia" name="cod_provincia"
                                onchange="Listar_Distrito();">
                            <!--<option value="<?php echo $get_id[0]['id_provincia_dom']; ?>"><?php echo $get_id[0]['domi_prov_admision']; ?></option>-->
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Distrito Domicilio" class="control-label text-bold">Dist: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="cod_distrito" name="cod_distrito">
                            <!--<option value="<?php echo $get_id[0]['id_distrito_dom']; ?>"><?php echo $get_id[0]['domi_dist_admision']; ?></option>-->
                        </select>
                    </div>
                </div>


                <div class="col-md-12 row etiqueta">
                    <h4 class="panel-title"><b>Colegio de Procedencia</b></h4>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Institución Proveniencia" class="control-label text-bold">Inst.&nbsp;P.: </label>
                    </div>
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control border" id="colegio_post" name="colegio_post">
                    </div>
                </div>
                <div class="col-md-12 row">

                    <div class="form-group col-md-1 text-right">
                        <label title="Departamento Colegio" class="control-label text-bold">Depa.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="col_departamento_admision" name="col_departamento_admision"
                                onchange="Listar_Provincia_Col();">
                            <option value="0">Seleccione</option>
                            <?php foreach ($list_departamento as $list) { ?>
                                <option value="<?php echo $list['id_departamento']; ?>"<?php /*if ($get_id[0]['id_departamento_col'] == $list['id_departamento']) {
                                    echo "selected";
                                }*/ ?>><?php echo $list['nombre_departamento']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Provincia Colegio" class="control-label text-bold">Prov.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="cod_provincia_col" name="cod_provincia_col"
                                onchange="Listar_Distrito_Col();">
                            <!--<option value="<?php echo $get_id[0]['id_provincia_col']; ?>"><?php echo $get_id[0]['col_prov_admision']; ?></option>-->
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Distrito Domicilio" class="control-label text-bold">Dist.: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="cod_distrito_col" name="cod_distrito_col">
                            <!--<option value="<?php echo $get_id[0]['id_distrito_col']; ?>"><?php echo $get_id[0]['col_dist_admision']; ?></option>-->
                        </select>
                    </div>
                </div>

                <hr>
                <div class="col-md-12 row etiqueta">
                    <h4 class="panel-title"><b>Admisión</b></h4>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Especialidad" class="control-label text-bold">Esp.:</label>
                    </div>
                    <div class="form-group col-md-5">
                        <select class="form-control border" id="admi_programa_admision" name="admi_programa_admision"
                                onchange="Listar_Modalidad();">
                            <option value="5">Seleccione</option>
                            <?php foreach ($list_programa_interes as $list) { ?>
                                <option value="<?php echo $list['id_especialidad']; ?>" <?php /*if ($get_id[0]['admi_programa_admision'] == $list['id_especialidad']) {
                                    echo('Selected');
                                }*/ ?>><?php echo $list['nom_especialidad']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2 text-right">
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="Modalidad" class="control-label text-bold">Modali.: </label>
                    </div>
                    <div class="form-group col-md-3" id="div_modalidad">
                        <select class="form-control border" id="admi_modalidad_admision" name="admi_modalidad_admision"
                                onchange="Listar_Turno();">
                            <option value="5">Seleccione</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="form-group col-md-1 text-right">
                        <label title="Turno" class="control-label text-bold">Turno: </label>
                    </div>
                    <div class="form-group col-md-3" id="div_turno">
                        <select class="form-control border" id="admi_turno_admision" name="admi_turno_admision">
                            <option value="5">Seleccione</option>
                            <?php foreach ($list_turno as $list) { ?>
                                <option value="<?php echo $list['id_confgen']; ?>" <?php /*if ($get_id[0]['admi_programa_admision'] == $list['id_especialidad']) {
                                    echo('Selected');
                                }*/ ?>><?php echo $list['nom_confgen']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label title="¿Cómo se entero de nosotros?"
                               class="control-label text-bold">CEN: </label>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control border" id="cen_e" name="cen_e">
                            <option value="5">Seleccione</option>
                            <?php foreach ($list_cen as $list) { ?>
                                <option value="<?php echo $list['id_confgen']; ?>" <?php /*if ($get_id[0]['admi_nosotros_admision'] == $list['id_confgen']) {
                                    echo('Selected');
                                }*/ ?>><?php echo $list['nom_confgen']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- div tutor -->
                <div id="datosTutor" style="display:none;">
                    <div class="col-md-12 row etiqueta">
                        <h4 class="panel-title"><b>Datos del Tutor</b></h4>
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-1 text-right">
                            <label class="control-label text-bold">Parent.:</label>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control border" id="parentesco_tut_e" name="parentesco_tut_e">
                                <option value="5">Seleccione</option>
                                <?php foreach ($list_parentesco as $list) { ?>
                                    <option value="<?php echo $list['id_confgen']; ?>" <?php /*if ($get_id[0]['admi_nosotros_admision'] == $list['id_confgen']) {
                                echo('Selected');
                            }*/ ?>><?php echo $list['nom_confgen']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1 text-right">
                            <label class="control-label text-bold">T.&nbsp;Doc.:</label>
                        </div>
                        <div class="form-group col-md-3">
                            <select class="form-control border" id="tipo_doc_tutor" name="tipo_doc_tutor">
                                <option value="5">Seleccione</option>
                                <?php foreach ($list_tipo_doc as $list) { ?>
                                    <option value="<?php echo $list['id_confgen']; ?>" <?php /*if ($get_id[0]['tutor_tip_doc_admision'] == $list['id_confgen']) {
                                        echo('Selected');
                                    }*/ ?>><?php echo $list['nom_confgen']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1 text-right">
                            <label class="control-label text-bold">DNI :</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control border" id="num_doc_tutor" name="num_doc_tutor">
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-1 text-right">
                            <label class="control-label text-bold">Ap.&nbsp;Pat.:</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control border" id="apepat_admision_tutor"
                                   name="apepat_admision_tutor">
                        </div>
                        <div class="form-group col-md-1 text-right">
                            <label class="control-label text-bold">Ap.&nbsp;Mat.:</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control border" id="apemat_admision_tutor"
                                   name="apemat_admision_tutor">
                        </div>
                        <div class="form-group col-md-1 text-right">
                            <label class="control-label text-bold">Nomb.:</label>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control border" id="nombres_admision_tutor"
                                   name="nombres_admision_tutor">
                        </div>
                    </div>

                </div>

                <div class="col-md-12 row etiqueta">
                    <h4 class="panel-title"><b>Documentos</b></h4>
                </div>
                <div class="form-group col-md-12 panel-acordeon-seccion">

                    <div class="form-group col-md-6 panel-acordeon-seccion"
                         style="padding-left: 0 !important; padding-right:0  !important; min-width:400px">
                        <div class="form-group col-md-6">
                            <label title="DNI Alumno(a) frente y reverso" class="texto">DNI Alumno(a):</label>
                        </div>
                        <div class="container-input form-group col-md-5">
                            <input type="file" name="doc_dni_alum_admision" id="doc_dni_alum_admision"
                                   class="inputfile inputfile-1" onchange="return validarExt(this.id,1)"/>

                            <label for="doc_dni_alum_admision">
                                <span class="iborrainputfile">Subir</span>
                                <img src="<?= base_url() ?>/template/img/icono-subir2.png" class="imagen_subir">
                            </label>
                            <label id="nombre_archivo1" class="nombre_archivo"></label>
                        </div>
                        <!--<div class="col-md-1" id="seccion_eliminar1">
                            <a style="cursor:pointer"
                               onclick="Delete_Documento_Postulante(<?php echo $get_id[0]['id_admision']; ?>,'doc_dni_alum_admision','doc_nombre_dni_alum_admision',1)"
                               title="Eliminar" class="eliminar <?php if(empty($get_id[0]['doc_nombre_dni_alum_admision'])) echo 'hidden'; ?>">
                                <img src="http://localhost/new_snappy/template/img/x.png">
                            </a>
                        </div>-->
                    </div>

                    <div class="form-group col-md-6 panel-acordeon-seccion responsive"
                         style="display:none; padding-left:0 !important; padding-right:0  !important;"
                         id="campo_dni_apoderado">
                        <div class="form-group col-md-6" style="display: flex; justify-content: flex-end;">
                            <label title="DNI Apoderado(a) frente y reverso" class="texto text-right">DNI
                                Apoderado(a):</label>
                        </div>
                        <div class="container-input form-group col-md-5">
                            <input type="file" name="doc_dni_tuto_admision" id="doc_dni_tuto_admision"
                                   class="inputfile inputfile-1" onchange="return validarExt(this.id,2)"/>
                            <!--data-multiple-caption="{count} archivos seleccionados" multiple-->
                            <label for="doc_dni_tuto_admision">
                                <span class="iborrainputfile">Subir</span>
                                <img src="<?= base_url() ?>/template/img/icono-subir2.png" class="imagen_subir">
                            </label>
                            <label id="nombre_archivo2" class="nombre_archivo"></label>
                        </div>
                       <!-- <div class="col-md-1" id="seccion_eliminar2">
                            <a style="cursor:pointer"
                               onclick="Delete_Documento_Postulante(<?php echo $get_id[0]['id_admision']; ?>,'doc_dni_tuto_admision','doc_nombre_dni_tuto_admision',2)"
                               title="Eliminar" class="eliminar <?php if(empty($get_id[0]['doc_nombre_dni_tuto_admision'])) echo 'hidden'; ?>">
                                <img src="http://localhost/new_snappy/template/img/x.png">
                            </a>
                        </div>-->
                    </div>
                </div>
                <div class="form-group col-md-12 panel-acordeon-seccion">

                    <div class="form-group col-md-6 panel-acordeon-seccion"
                         style="padding-left: 0 !important; padding-right:0 !important; min-width:400px">
                        <div class="form-group col-md-6">
                            <label title="Certificado de Estudio" class="texto">Certificado de Estudio:</label>
                        </div>
                        <div class="container-input form-group col-md-5">
                            <input type="file" name="doc_certificado_admision" id="doc_certificado_admision"
                                   class="inputfile inputfile-1" onchange="return validarExt(this.id,3)"/>
                            <!--data-multiple-caption="{count} archivos seleccionados" multiple-->
                            <label for="doc_certificado_admision">
                                <span class="iborrainputfile">Subir</span>
                                <img src="<?= base_url() ?>/template/img/icono-subir2.png" class="imagen_subir">
                            </label>
                            <label id="nombre_archivo3" class="nombre_archivo"></label>
                        </div>
                       <!-- <div class="col-md-1" id="seccion_eliminar3">
                            <a style="cursor:pointer"
                               onclick="Delete_Documento_Postulante(<?php echo $get_id[0]['id_admision']; ?>,'doc_certificado_admision','doc_nombre_certificado_admision',3)"
                               title="Eliminar" class="eliminar <?php if(empty($get_id[0]['doc_nombre_certificado_admision'])) echo 'hidden'; ?>">
                                <img src="http://localhost/new_snappy/template/img/x.png">
                            </a>
                        </div>-->
                    </div>
                    <div class="form-group col-md-6 panel-acordeon-seccion responsive"
                         style="display:none; padding-left: 0 !important; padding-right:0 !important;">
                        <label class="form-group col-md-3 text-right">
                            <input type="checkbox" id="doc_tramite_admision" name="doc_tramite_admision"
                                   value="1">
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                      pathLength="575.0541381835938" class="path"></path>
                            </svg>
                        </label>
                        <div class="form-group col-md-9">
                            <label class="texto">No tengo. Lo estoy tramitando</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
            </button>
            <button id="boton_obs" type="button" class="btn btn-primary" onclick="Registrar_Datos_Postulante()">
                <i class="glyphicon glyphicon-ok-sign"></i>Guardar
            </button>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#admision_formulario").addClass('active');
            $("#hadmision_formulario").attr('aria-expanded', 'true');
            $("#lista").addClass('active');
            document.getElementById("radmision_formulario").style.display = "block";

            var fechaNacimiento = document.getElementById('fechaNacimiento').value;
            Verificar_Edad(fechaNacimiento);

        });


        function Listar_Modalidad() {
            var url = "<?php echo site_url(); ?>AppIFV/Listar_Modalidad";
            var dataString = new FormData(document.getElementById('formulario_registrar'));

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#div_modalidad').html(data);
                }
            });
        }

        function Listar_Turno() {
            var url = "<?php echo site_url(); ?>AppIFV/Listar_Turno";
            var dataString = new FormData(document.getElementById('formulario_registrar'));

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#div_turno').html(data);
                }
            });
        }

        function Listar_Provincia() {
            Cargando();

            var url = "<?php echo site_url(); ?>AppIFV/Busca_Provincia";
            var id_departamento = $('#admi_departamento_admision').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: {'id_departamento': id_departamento},
                success: function (data) {
                    $('#cod_provincia').html(data);
                    $('#cod_distrito').html('<option value="0">Seleccione</option>');
                }
            });
        }

        function Listar_Provincia_Col() {
            Cargando();

            var url = "<?php echo site_url(); ?>AppIFV/Busca_Provincia";
            var id_departamento = $('#col_departamento_admision').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: {'id_departamento': id_departamento},
                success: function (data) {
                    $('#cod_provincia_col').html(data);
                    $('#cod_distrito_col').html('<option value="0">Seleccione</option>');
                }
            });
        }

        function Listar_Distrito() {
            Cargando();

            var url = "<?php echo site_url(); ?>AppIFV/Busca_Distrito_Edit";
            var id_departamento = $('#admi_departamento_admision').val();
            var id_provincia = $('#cod_provincia').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: {'id_provincia': id_provincia, 'id_departamento': id_departamento},
                success: function (data) {
                    $('#cod_distrito').html(data);
                }
            });
        }

        function Listar_Distrito_Col() {
            Cargando();

            var url = "<?php echo site_url(); ?>AppIFV/Busca_Distrito_Edit";
            var id_departamento = $('#col_departamento_admision').val();
            var id_provincia = $('#cod_provincia_col').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: {'id_provincia': id_provincia, 'id_departamento': id_departamento},
                success: function (data) {
                    $('#cod_distrito_col').html(data);
                }
            });
        }

        function Verificar_Edad(fechaNacimiento) {
            var fechaNac = new Date(fechaNacimiento);
            var hoy = new Date();
            var edad = hoy.getFullYear() - fechaNac.getFullYear();
            var diferenciaMeses = hoy.getMonth() - fechaNac.getMonth();
            if (diferenciaMeses < 0 || (diferenciaMeses === 0 && hoy.getDate() < fechaNac.getDate())) {
                edad--;
            }

            if (edad < 18) {
                document.getElementById("datosTutor").style.display = "block";
            } else {
                document.getElementById("datosTutor").style.display = "none";
                Limpiar_Datos()
            }
        }

        function Limpiar_Datos() {
            $('#parentesco_tut_e').val('5');
            $('#tipo_doc_tutor').val('5');
            $('#num_doc_tutor').val('');
            $('#apepat_admision_tutor').val('');
            $('#apemat_admision_tutor').val('');
            $('#nombres_admision_tutor').val('');
        }

        function Registrar_Datos_Postulante() {
            var id = $('#id_admision').val();
            var fechaNacimiento = $('#fechaNacimiento').val();
            var tutorNombre = $('#nombres_admision_tutor').val();
            var tutorApellidoPaterno = $('#apepat_admision_tutor').val();
            var tutorApellidoMaterno = $('#apemat_admision_tutor').val();
            var tutorTipoDocumento = $('#tipo_doc_tutor').val();
            var tutorNumeroDocumento = $('#num_doc_tutor').val();

            var dataString = new FormData(document.getElementById('formulario_registrar'));
            var url = "<?php echo site_url(); ?>AppIFV/Registrar_Datos_Postulante";

            var fechaActual = new Date();
            var fechaNacimientoObj = new Date(fechaNacimiento);
            var edad = fechaActual.getFullYear() - fechaNacimientoObj.getFullYear();

            // Agregar la edad al  FormData
            dataString.append('edad', edad);

            if (edad < 18) {
                // Si postulante es menor de edad enviar campos del tutor
                dataString.append('tutorNombre', tutorNombre);
                dataString.append('tutorApellidoPaterno', tutorApellidoPaterno);
                dataString.append('tutorApellidoMaterno', tutorApellidoMaterno);
                dataString.append('tutorTipoDocumento', tutorTipoDocumento);
                dataString.append('tutorNumeroDocumento', tutorNumeroDocumento);
            }

            // Eliminar los campos del tutor del objeto FormData si el postulante es mayor de edad
            if (edad >= 18) {
                dataString.delete('tutorNombre');
                dataString.delete('tutorApellidoPaterno');
                dataString.delete('tutorApellidoMaterno');
                dataString.delete('tutorTipoDocumento');
                dataString.delete('tutorNumeroDocumento');
            }

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data) {
                    //window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Postulantes_C/" + id;
                }
            });
        }

        function validarExt(event, nombre) {
            var archivoInput = document.getElementById(event);
            var archivolabel = document.getElementById('nombre_archivo' + nombre);
            var eliminar_secc = document.getElementById( 'seccion_eliminar'+nombre);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf)$/i;
            var archivosSeleccionados = archivoInput.files;
            var nombreArchivo = archivosSeleccionados[0].name;
            if (!extPermitidas.exec(archivoRuta)) {
                //alert('Asegurese de haber seleccionado un archivo .pdf');
                swal({
                    //title: '¡UPS!',
                    html: 'Asegurese de haber seleccionado<br> un archivo .pdf',
                    confirmButtonText: 'CERRAR',
                    padding: '2em'
                })
                document.querySelector(".swal2-header").style.background = "#666666";
                document.querySelector(".swal2-header").style.margin = "-32px 0 40px 0";
                document.querySelector(".swal2-header").style.width = "60%";
                document.querySelector(".swal2-header").style.background = "#ef8903";
                archivoInput.value = '';
                archivolabel.textContent = '';
                return false;
            } else {
                archivolabel.textContent = nombreArchivo;
                eliminar_secc.classList.remove('hidden');
            }

        }

    </script>


<?php $this->load->view('view_IFV/utils/index.php'); ?>