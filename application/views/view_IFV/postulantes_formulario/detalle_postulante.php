<?php 
    $sesion =  $_SESSION['usuario'][0];
    $id_nivel = $sesion['id_nivel'];
    defined('BASEPATH') OR exit('No direct script access allowed');
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
    .tabset > input:nth-child(13):checked ~ .tab-panels > .tab-panel:nth-child(7),
    .tabset > input:nth-child(15):checked ~ .tab-panels > .tab-panel:nth-child(8),
    .tabset > input:nth-child(17):checked ~ .tab-panels > .tab-panel:nth-child(9),
    .tabset > input:nth-child(19):checked ~ .tab-panels > .tab-panel:nth-child(10),
    .tabset > input:nth-child(21):checked ~ .tab-panels > .tab-panel:nth-child(11){
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
        text-align: center;
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

    .color_casilla2{
        border-color: #32b732 !important;
        color: #fff;
        background-color: #32b732 !important;
    }
    .label2{
        padding: 15px 25px !important;
    }
    
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #990000;">
                <!--    <?php /*if(count($get_foto)>0){ ?>
                        <a onclick="Descargar_Foto_Matriculados_C('<?php echo $get_foto[0]['id_detalle']; ?>');"><img class="img_class" src="<?php echo base_url().$get_foto[0]['archivo']; ?>"></a>
                    <?php }*/ ?>-->
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
                </div>
    
                <div class="heading-elements"> 
                    <div class="heading-btn-group"> 
                       
                        <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Editar_Postulante')  ?>/<?php echo $get_id[0]['id_admision']; ?>" style="margin-right:5px;"> 
                            <img src="<?= base_url() ?>template/img/editar_grande.png">
                        </a> 
                        <!--
                        <?php /* if($get_id[0]['edad']<18){*/ ?>
                            <a title="Adicionar Tutor" data-toggle="modal" data-target="#acceso_modal_mod" 
                            app_crear_mod="<?= site_url('AppIFV/Modal_Tutor')?>/<?php /*echo $get_id[0]['Id'];*/ ?>" 
                            style="margin-right:5px;"> 
                                <img src="<?= base_url() ?>template/img/adicionar_tutor.png">
                            </a>
                        <?php /*}*/ ?>
                        
                        <a title="Duplicar Documento" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Documento_Duplicado') ?>/<?php /* echo $get_id[0]['Id'];*/ ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/copy.png">
                        </a>

                        <a title="Pagos Pendientes" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?=site_url('AppIFV/Modal_Pago_Snappy') ?>" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/btn_pago_pendiente.png">
                        </a>
                        -->
                        <a type="button" href="<?= site_url('AppIFV/Postulantes_Formulario') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <?php
        $fec_de = new DateTime($get_id[0]['Fecha_Nacimiento']);
        $fec_hasta = new DateTime(date('Y-m-d'));
        $diff = $fec_de->diff($fec_hasta); 
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label title="Código:" class="control-label text-bold margintop">Código:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Codigo']; ?>">
                </div>

                <div class="form-group col-md-1 text-right">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label title="Postulación:" class="control-label text-bold margintop">Postulación:</label>
                </div>
                <div class="form-group col-md-2 text-right">
                    <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Estado_Doc_Postulante']; ?>">
                </div>

                <!-- ACA DEBE IR EL ESTADO DE ADMISION? OSEA COMPLETO, INCOMPLETO? ETC? 

                <div class="form-group col-md-3">
                </div>

                <div class="form-group col-md-1">
                    <input type="text" class="margintop form-control color_casilla <?php if($get_id[0]['Matricula']=='Asistiendo'){ echo 'color_casilla2';} ;?>" disabled value="<?php echo $get_id[0]['Matricula']; ?>">
                </div> -->

            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label title="Apellido Paterno:" class="control-label text-bold">Ap.&nbsp;Pater.:</label>
                </div>
                <div class="form-group col-md-2 text-right">
                    <input type="text" class="form-control" style="background:#fbe5d6; border: 0px solid transparent;" disabled value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
                </div>

                <div class="form-group col-md-1 text-right">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label title="Apellido Materno:" class="control-label text-bold">Ap.&nbsp;Mater.:</label>
                </div>
                <div class="form-group col-md-2 text-right">
                    <input type="text" class="form-control" style="background:#fbe5d6; border: 0px solid transparent;" disabled value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
                </div>

                <div class="form-group col-md-1 text-right">
                </div>
                    
                <div class="form-group col-md-1 text-right">
                    <label title="Nombres:" class="control-label text-bold margintop">Nombres:</label>
                </div>
                <div class="form-group col-md-2 text-right">
                    <input type="text" class="form-control" style="background:#fbe5d6; border: 0px solid transparent;" disabled value="<?php echo $get_id[0]['Nombre']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label title="DNI:" class="control-label text-bold margintop">DNI:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" id="dni_postulante" class="form-control" disabled value="<?php echo $get_id[0]['Nro_Doc_Alumno']; ?>">
                </div>

                <div class="form-group col-md-1 ">
                </div> 

                <div class="form-group col-md-1 text-right">
                    <label title="Celular:" class="control-label text-bold margintop">Celular:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Celular_Alumno']; ?>">
                </div>

                <div class="form-group col-md-1"> 
                </div>

                <div class="form-group col-md-1 text-right">
                    <label title="Correo:" class="control-label text-bold margintop">Correo:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Email_Alumno']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label title="Especialidad:" class="control-label text-bold margintop">Esp.:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Nombre_Especialidad']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label title="Modalidad:" class="control-label text-bold margintop">Modali:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Modalidad']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label title="Turno:" class="control-label text-bold margintop">Turno:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Turno']; ?>">
                </div>
            </div>
        </div>
        <!-- Modulos interactivos--> 
        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked> 
                <label title="Admisión" for="tab1">Adm.</label>

                <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" onclick=""> 
                <label itle="Admisión" for="tab2">Det.</label>

                <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Ingreso();">
                <label title="Ingresos" for="tab3">Ingre.</label>  

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" onclick="Lista_Documentos();">
                <label title="Documentos" for="tab4">Doc.</label>  
                
                <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="Lista_Contratos()">
                <label title="Contratos"for="tab5">Con.</label>

                <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6">
                <label title="EFSRT" for="tab6">EFSRT</label>

                <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7" onclick="Lista_Pagos_Arpay();">
                <label title="Compras (AP)" for="tab7">C.(AP)</label>

                <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8" onclick="Lista_Pagos_Snappy();">
                <label title="Compras (SP)" for="tab8">C.(SP)</label>

                <input type="radio" name="tabset" id="tab9" aria-controls="rauchbier9">
                <label title="Compras (LA)" for="tab9">C.(LA)</label>                    

                <input type="radio" name="tabset" id="tab10" aria-controls="rauchbier10" onclick="Lista_Sms();">
                <label title="SMS" for="tab10">SMS</label>

                <input type="radio" name="tabset" id="tab11" aria-controls="rauchbier11" onclick="Lista_Observacion();">
                <label title="Observaciones" for="tab11">Obs.</label>

                <input type="hidden" id="id_postulante" name="id_postulante" value="<?php echo $get_id[0]['id_admision']; ?>">
                <!--<input type="text" id="dni_postulante" name="dni_postulante" value="<?php /* echo $get_id2[0]['cont_dni_admision']; */?>">
                        -->
                <div class="tab-panels">
                    <!-- ADMISION -->
                    <section id="rauchbier1" class="tab-panel">
                        <div class="box-body table-responsive">
                            <div class="panel panel-flat content-group-lg">
                                <div class="panel-heading">
                                    <div class="heading-elements">
                                        <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                            <li><a data-action="reload"></a></li>
                                            <li><a data-action="close"></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1"> 
                                            <select id="grupo" class="form-control">
                                                <?php foreach ($list_grupo as $list) { ?>
                                                    <option value="<?php echo $list['grupo']; ?>"><?php echo $list['grupo']; ?></option>  
                                                <?php } ?> 
                                            </select>
                                        </div>
                                    </div> 
                                </div>                                
                                
                                <div id="detalle_admision">
                                </div>
                                 
                            </div>
                        </div>
                    </section> 

                    <!-- DETALLE -->
                    <section id="rauchbier2" class="tab-panel">
                        <div class="box-body table-responsive">
                            <div class="panel panel-flat content-group-lg">
                                <div class="panel-heading">
                                    <div class="heading-elements">
                                        <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                            <li><a data-action="reload"></a></li>
                                            <li><a data-action="close"></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Fecha de Nacimiento:" class="control-label text-bold">Fec.&nbsp;Nac.:</label>
                                        </div>
                                        <div class="form-group col-md-2 ">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Fecha_Nacimiento']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Edad:" class="control-label text-bold">Edad:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $diff->y; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Sexo:" class="ontrol-label text-bold">Sexo:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Sexo']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Correo Eléctronico:" class="ontrol-label text-bold">Correo:</label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Email_Alumno']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Institución Proveniencia:" class="control-label text-bold">Inst.&nbsp;Prove.:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Colegio_Procedencia']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Departamento:" class="control-label text-bold">Depa.:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Departamento_Colegio']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Provincia:" class="control-label text-bold">Prov.:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Provincia_Colegio']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Distrito:" class="control-label text-bold">Dist:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Distrito_Colegio']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Domicilio Postulante:" class="control-label text-bold">Dom.&nbsp;Post.:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Domicilio']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="epartamento:" class="control-label text-bold">Depa.:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Departamento']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Provincia:" class="control-label text-bold">Prov.:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Provincia']; ?>">
                                        </div>
                                        <div class="form-group col-md-1 text-right">
                                            <label title="Distrito:" class="control-label text-bold">Dist:</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Distrito']; ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <!-- div tutor --> 
                            <?php if($get_id[0]['edad']<18){ ?>
                                    <div class="panel panel-flat content-group-lg">
                                        <div class="panel-heading">
                                        <h5 class="panel-title"><b>Tutor</b></h5>
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
                                                <div class="form-group col-md-1 text-right">
                                                    <label title="Parentesco:" class="control-label text-bold">Parentesco:</label>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Parentesco_Tutor']; ?>">
                                                </div>
                                                <div class="form-group col-md-1 text-right">
                                                    <label title="DNI:" class="control-label text-bold">DNI:</label>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Nro_Doc_Tutor']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 row">    
                                                <div class="form-group col-md-1 text-right">
                                                    <label title="Apellido Paterno:" class="control-label text-bold">Ap.&nbsp;Pater.:</label>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Paterno_Tutor']; ?>">
                                                </div>
                                                <div class="form-group col-md-1 text-right">
                                                    <label title="Apellido Materno:" class="control-label text-bold">Ap.&nbsp;Mater.:</label>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Materno_Tutor']; ?>">
                                                </div>
                                                <div class="form-group col-md-1 text-right">
                                                    <label title="Nombres:" class="control-label text-bold">Nombres:</label>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Nombre_Tutor']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php } ?>
                        </div> 
                    </section>

                    <!-- INGRESOS -->
                    <section id="rauchbier3" class="tab-panel">
                        <div  class="tabset">
                            <!-- <?php /* foreach($list_modulo as $list){ */?>
                                <input type="radio" name="modulo" id="modulo<?php echo $list['modulo']?>"  style="max-height: 50px !important;" value="<?php echo $list['modulo']?>" onclick="Lista_Ingreso()" checked>
                                <label class="label2" for="modulo<?php echo $list['modulo']?>"><?php echo $list['modulo']?></label>
                            <?php // }?> -->
                            <div class="boton_exportable" style="display: inline-block !important;">
                                <a title="Excel" onclick="Excel_Modulo();">
                                    <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                                </a>
                            </div>
                            <div style="display: inline-block !important;float: right;">
                                <label for="" id="rango_fec_modulo"></label>
                            </div>
                        </div>
                        <div class="modal-content">
                            <div id="lista_ingreso_postulante">
                            </div>
                        </div> 
                    </section>

                    
                    <!--DOCUMENTOS-->
                    <section id="rauchbier4" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" href="<?= site_url('AppIFV/Excel_Documento_Postulante') ?>/<?php echo $get_id[0]['id_admision']; ?>">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a> 
                        </div>
                        <div class="modal-content">
                            <div id="lista_documentos_postulante">
                            </div>
                        </div>
                    </section> 

                    <!-- CONTRATO -->
                    <section id="rauchbier5" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div class="modal-content">
                            <div id="lista_contrato_postulante">
                            </div>
                        </div>
                    </section>

                    <!-- Compras(LA)-->
                    <section id="rauchbier6" class="tab-panel">
                    </section>

                    <!-- Compras(AP) -->
                    <section id="rauchbier7" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                            </a>
                        </div>
                        
                        <div class="modal-content">
                            <div class="heading-btn-group cabecera_pagos">
                                <a onclick="" id="pendientes_btn_ap" style="color:#ffffff;background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
                                <a onclick="" id="todos_btn_ap" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                                <input type="hidden" id="tipo_excel_ap" value="2">
                            </div>

                            <div id="lista_pagos_arpay">
                            </div>
                        </div> 
                    </section>

                    <!-- Compras(SP)-->
                    <section id="rauchbier8" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                            </a>
                        </div>
                        
                        <div class="modal-content">
                            <div class="heading-btn-group cabecera_pagos">
                                <a onclick="" id="pendientes_btn_sp" style="color:#ffffff;background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
                                <a onclick="" id="todos_btn_sp" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                                <input type="hidden" id="tipo_excel_sp" value="2">
                            </div>

                            <div id="lista_pagos_snappy">
                            </div>
                        </div>
                    </section>

                    <!-- Compras(LA)-->
                    <section id="rauchbier9" class="tab-panel">
                    </section>

                    <!-- SMS -->
                    <section id="rauchbier10" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" href="<?= site_url('AppIFV/Excel_Sms_Postulante') ?>/<?php /*echo $get_id[0]['id_admision']; */?>">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a> 
                        </div>
                        <div class="modal-content">
                            <div id="lista_sms_postulante">
                            </div>
                        </div>
                    </section>

                    <!-- OBSERVACIONES -->
                    <section id="rauchbier11" class="tab-panel">
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
    $(document).ready(function(){
        $("#admision_formulario").addClass('active');
        $("#hadmision_formulario").attr('aria-expanded', 'true');
        $("#lista").addClass('active');
        document.getElementById("radmision_formulario").style.display = "block";
        Admision();
        $('#grupo').on('change', function() {
        Admision();
        });
    });

    
    function Admision() {
        //alert('prueba grupo');
        Cargando();
        var dni_postulante = $("#dni_postulante").val();
        var grupo = $("#grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Detalle_Admision_Postulante";

        $.ajax({
            type:"POST",
            url:url,
            data: {'dni_postulante':dni_postulante,'grupo':grupo},
            success:function (data) {
                $('#detalle_admision').html(data);
            }
        });
    }
    
    function Descargar_Foto_Matriculados_C(id){
        Cargando();

        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Matriculados_C/"+id);
    }

    function Delete_Tutor(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Tutor"; 

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
                    type:"POST",
                    url:url,
                    data: {'id_tutor':id},
                    success:function (data) {
                        window.location.reload();
                    }
                });
            }
        })
    }

    function Lista_Ingreso(){ 
        Cargando();
        var id_postulante = $('#id_postulante').val();
        //var modulo = document.querySelector('input[name=modulo]:checked').value;
        var url="<?php echo site_url(); ?>AppIFV/Lista_Ingreso_Postulante";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_ingreso_postulante').html(data);
            }
        });
    }

    //Documentos
    function Lista_Documentos(){
        Cargando();
        var id_postulante = $("#id_postulante").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Documento_Post";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_documentos_postulante').html(data);
            }
        });
    }

    function Delete_Documento_Alumno(id_detalle){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Documento_Alumno";

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
                    data: {'id_detalle':id_detalle},
                    success:function (data) {
                        Lista_Documentos();
                    }
                });
            }
        })
    } 

    function Lista_Pagos_Arpay(){
        Cargando();

        var id_postulante = $('#id_postulante').val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Pago_Arpay_Postulante";

        $.ajax({
            type:"POST", 
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_pagos_arpay').html(data);
               //$('#tipo_excel_ap').val(estado);
            }
        });

        /*
        var pendientes = document.getElementById('pendientes_btn_ap');
        var todos = document.getElementById('todos_btn_ap');

        if(estado==1){
            pendientes.style.color = '#000000';
            todos.style.color = '#FFFFFF';
        }else{
            pendientes.style.color = '#FFFFFF';
            todos.style.color = '#000000';
        }*/
    }

    function Excel_Pago_Arpay_Matriculados(){
        Cargando();

        var id_postulante = $('#id_postulante').val(); 
        var tipo_excel=$('#tipo_excel_ap').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Pago_Arpay_Matriculados/"+id_postulante+"/"+tipo_excel;
    }

    function Lista_Pagos_Snappy(){
        Cargando();
        var id_postulante = $('#id_postulante').val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Pago_Snappy_Postulante";

        $.ajax({
            type:"POST", 
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_pagos_snappy').html(data);
                //$('#tipo_excel_sp').val(estado);
            }
        });

        /*
        var pendientes = document.getElementById('pendientes_btn_sp');
        var todos = document.getElementById('todos_btn_sp');

        if(estado==1){
            pendientes.style.color = '#000000';
            todos.style.color = '#FFFFFF';
        }else{
            pendientes.style.color = '#FFFFFF';
            todos.style.color = '#000000';
        }*/
    }

    function Excel_Pago_Snappy_Matriculados(){
        Cargando();

        var id_postulante = $('#id_postulante').val();
        var tipo_excel=$('#tipo_excel_sp').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Pago_Snappy_Matriculados/"+id_postulante+"/"+tipo_excel;
    }

    // SMS
    function Lista_Sms(){ 
        Cargando();

        var id_postulante = $('#id_postulante').val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Sms_Postulante";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_sms_postulante').html(data);
            }
        });
    }

    function Lista_Observacion(){
        Cargando();

        var id_postulante = $("#id_postulante").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Observacion_Postulante";


        
        $.ajax({
            type:"POST",
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_observacion').html(data);
                Registrar_Observacion_Postulante(id_postulante);
            }
        });
    }

    function Registrar_Observacion_Postulante(id_postulante){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Registrar_Observacion_Postulante";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#div_accion_obs').html(data);
            }
        });
    }

    function Insert_Observacion_Postulante(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Observacion_Postulante";

        var id_postulante = $('#id_postulante').val();
        dataString.append('id_postulante', id_postulante);
        
        if(Valida_Observacion_Alumno()){
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
                        Registrar_Observacion_Postulante(id_postulante);
                        Lista_Observacion();
                    }
                }
            });
        }
    }
    
    function Valida_Observacion_Alumno(){
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
   

    function Editar_Observacion_Alumno(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Editar_Observacion_Postulacion";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_observacion':id},
            success:function (data) {
                $('#div_accion_obs').html(data);
            }
        });
    }

    function Update_Observacion_Alumno(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Observacion_Postulante";

        var id_postulante = $('#id_postulante').val();
        dataString.append('id_postulante', id_postulante);
        
        if(Valida_Observacion_Alumno()){
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Registrar_Observacion_Postulante(id_postulante);
                    Lista_Observacion();
                }
            });
        }
    }

    function Delete_Observacion_Alumno(id){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Observacion_Postulante";

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
                    type:"POST",
                    url:url,
                    data: {'id_observacion':id},
                    success:function (data) {
                        Lista_Observacion();
                    }
                });
            }
        })
    }

    function Excel_Observacion(){
        Cargando();
        var id_postulante = $('#id_postulante').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Observacion_Postulante/"+id_postulante;
    }

    /*function Lista_Modulo2(){
        Cargando();

      var id_postulante = $("#id_postulante").val();
      var url="<?php echo site_url(); ?>AppIFV/Lista_Modulo";

      $.ajax({
          type:"POST",
          url:url,
          data: {'id_postulante':id_postulante},
          success:function (data) {
              $('#lista_modulo').html(data);
          }
      });
    }*/

    function Excel_Modulo(){
        Cargando();

        var id_postulante = $('#id_postulante').val();
        var modulo = document.querySelector('input[name=modulo]:checked').value;
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Modulo/"+id_postulante+"/"+modulo;
    }

    function Lista_Contratos(){
        Cargando();

        var id_postulante = $("#id_postulante").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Contrato_Postulante";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_postulante':id_postulante},
            success:function (data) {
                $('#lista_contrato_postulante').html(data);
            }
        });
    }

    function limpiarFormularioObservacion(){
        $('#id_tipo_o').val('0');
        $('#fecha_o').val(''); //fecha actual llamar 
        $('#usuario_o').val('0');
        $('#observacion_o').val('');
        $('#id_observacion').val('');
    }

</script>

<?php $this->load->view('view_IFV/footer'); ?>
<?php $this->load->view('view_IFV/utils/index.php'); ?>