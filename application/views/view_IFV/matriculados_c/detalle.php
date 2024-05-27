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
        border-color: #3db732 !important;
        color: #fff;
        background-color: #3db732 !important;
    }

    .color_casilla3{
        border-color: #fe0001 !important;
        color: #fff;
        background-color: #fe0001 !important;
    }

    .color_casilla4{
        border-color: #0170c1 !important;
        color: #fff;
        background-color: #0170c1 !important;
    }

    .label2{
        padding: 15px 25px !important;
    }
    
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <?php if(count($get_foto)>0){ ?>
                        <a onclick="Descargar_Foto_Matriculados_C('<?php echo $get_foto[0]['id_detalle']; ?>');"><img class="img_class" src="<?php echo base_url().$get_foto[0]['archivo']; ?>"></a>
                    <?php } ?>
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
                </div>
    
                <div class="heading-elements"> 
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('AppIFV/Matriculados_C') ?>">
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
                    <label class="col-sm-3 control-label text-bold margintop">Código:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Codigo']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Estado:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Alumno']; ?>">
                </div>

                <div class="form-group col-md-3">
                </div>

                <div class="form-group col-md-1">
                    <input type="text" class="margintop form-control color_casilla <?php if($get_id[0]['Matricula']=='Asistiendo'){ echo 'color_casilla2';}
                                                                                        elseif($get_id[0]['Matricula']=='Retirado'){echo 'color_casilla3';}
                                                                                        elseif($get_id[0]['Matricula']=='Sin Matricular'){echo 'color_casilla4';} ;?>" disabled value="<?php echo $get_id[0]['Matricula']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop" >Ap.&nbsp;Paterno: </label>
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
                    <label class="col-sm-3 control-label text-bold margintop">DNI:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Dni']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div> 

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Celular:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Celular']; ?>">
                </div>

                <div class="form-group col-md-1"> 
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Correo&nbsp;Inst.:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Correo_Institucional']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Especialidad: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Especialidad']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Módulo: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Modulo']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Turno: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Turno']; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked> 
                <label for="tab1">Admisión</label>

                <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2"> 
                <label for="tab2">Detalle</label>

                <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $get_id[0]['Id']; ?>">   
            
                <div class="tab-panels">
                    <!-- ADMISION -->
                    <section id="rauchbier1" class="tab-panel">
                        <div class="box-body table-responsive">
                            <div class="panel panel-flat content-group-lg">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><b>Admision</b></h5>
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
                                        <div class="form-group col-md-1"> 
                                            <select class="form-control" disabled>
                                                <option value="<?php echo $get_id[0]['Grupo']; ?>"><?php echo $get_id[0]['Grupo']; ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1">
                                            <label class="control-label text-bold">Creado por:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="Prueba Usuario">
                                        </div>

                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class=" control-label text-bold">Fecha creación:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class=" control-label text-bold">Mayor de edad:</label>
                                        </div>   
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo'];  ?>">
                                        </div>      
                                        
                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class=" control-label text-bold">Codigo:</label>
                                        </div>   
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>                              
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1">
                                            <label class="col-sm-3 control-label text-bold margintop">Especialidad: </label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Especialidad']; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class="col-sm-3 control-label text-bold margintop">Modalidad: </label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class="col-sm-3 control-label text-bold margintop">Turno: </label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-2">
                                            <label class=" control-label text-bold">¿Cómo se enteró de nosotros?:</label>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Certificado de estudios:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                        
                                            <input type="text" class="form-control" disabled value="No">
                                        </div>

                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Declaración Jurada??:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            
                                            <input type="text" class="form-control" disabled value="No">
                                        </div>
                                        
                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Doc DNI postulante:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="No">
                                        </div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Evaluación:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Nota:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>
                                        
                                        <div class="form-group col-md-1">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="control-label text-bold">Estado of.:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section> 

                    <!-- DETALLE -->
                    <section id="rauchbier2" class="tab-panel">
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

                                <div class="panel-body">
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-1">
                                            <label class="control-label text-bold">Fecha Nac.:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Cumpleanos']; ?>">
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class=" control-label text-bold">Edad:</label>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" class="form-control" disabled value="<?php echo $diff->y; ?>">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="sexo" class="col-md-3 col-form-label text-bold">Sexo:</label>
                                            <div class="col-md-9">
                                                <input type="text" id="sexo" class="form-control" disabled value="<?php echo $get_id[0]['nom_sexo']; ?>"
                                                    <?php if ($get_id[0]['nom_sexo'] == "") { echo "style='border-color:#FBE5D6;background-color: #FBE5D6 !important;'"; } ?>>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <div class="form-group col-md-4">
                                                <label class=" control-label text-bold">Institución Proveniencia:</label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nombre_distrito']; ?>">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['institucion']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-4 no-padding">
                                            <label for="sexo" class="col-md-4 text-bold">Correo Personal:</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Email']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($get_id[0]['edad']<18){ ?>
                                <?php $i = 1; 
                                foreach($list_tutor as $list){ ?>
                                    <div class="panel panel-flat content-group-lg">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <b>Tutor <?php echo $i; ?></b>
                                                <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                                                app_crear_mod="<?= site_url('AppIFV/Modal_Update_Tutor') ?>/<?php echo $list['id_tutor']; ?>">
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
                                                    <input type="checkbox" disabled <?php if($list['no_mailing']==1){ echo "checked"; } ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++; } ?>
                            <?php } ?>
                        </div> 
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#calendarizaciones").addClass('active');
        $("#hcalendarizaciones").attr('aria-expanded', 'true');
        $("#matriculados_c").addClass('active');
        document.getElementById("rcalendarizaciones").style.display = "block";
    });
</script>

<?php $this->load->view('view_IFV/footer'); ?>
<?php $this->load->view('view_IFV/utils/index.php'); ?>