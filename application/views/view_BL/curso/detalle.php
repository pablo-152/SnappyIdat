<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('view_BL/header'); ?>

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
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6){
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
</style>

<?php $this->load->view('view_BL/nav'); ?>

<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo $get_id[0]['nom_curso']; ?>: </b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <?php if($get_id[0]['estado_cierre']==1){ ?>
                            <a onclick="Curso_Cerrado();" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/editar_grande.png">
                            </a>

                            <a onclick="Curso_Cerrado();" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/asignar_seccion.png">
                            </a>

                            <a onclick="Curso_Cerrado();" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/ceba/crear_requisito.png">
                            </a>

                            <a onclick="Curso_Cerrado();" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar_curso.png">
                            </a>

                            <a href="<?= site_url('BabyLeaders/Curso') ?>">
                                <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                            </a>
                        <?php }else{ ?>
                            <a style="margin-right:5px;" title="Editar Curso" href="<?= site_url('BabyLeaders/Modal_Update_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                                <img class="top" src="<?= base_url() ?>template/img/editar_grande.png">
                            </a>

                            <a title="Asignar Sección" href="<?= site_url('BabyLeaders/Vista_Asignar_Seccion') ?>/<?php echo $get_id[0]['id_curso']; ?>" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/asignar_seccion.png">
                            </a>

                            <a title="Nuevo Requisito" data-toggle="modal" data-target="#acceso_modal" 
                                app_crear_per="<?= site_url('BabyLeaders/Modal_Requisito') ?>/<?php echo $get_id[0]['id_curso']; ?>" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/ceba/crear_requisito.png">
                            </a>

                            <a title="Cerrar Curso" onclick="Cerrar_Curso('<?php echo $get_id[0]['id_curso']; ?>','<?php echo $get_id[0]['nom_curso']; ?>')" style="margin-right:5px;">
                                <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar_curso.png">
                            </a>

                            <a title="Regresar" href="<?= site_url('BabyLeaders/Curso') ?>">
                                <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="datos_cambiantes" class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Nombre:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_curso']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Grado:</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_grado']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Año:</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_anio']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Inicio&nbsp;Matrícula: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['fec_inicio']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Fin&nbsp;Matrícula: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['fec_fin']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>
                    
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Inicio&nbsp;Curso: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['inicio_curso']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Fin&nbsp;Curso: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['fin_curso']; ?>">
                </div>
            </div> 
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                <label for="tab1">Secciones</label>

                <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                <label for="tab2">Requisitos</label>

                <!--<input type="radio" name="tabset" id="tab3" aria-controls="rauchbier1"> 
                <label for="tab3">Salones</label>

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier2">
                <label  for="tab4">Estudiantes</label>                               

                <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier3">
                <label  for="tab5">Matricula </label>-->

                <input type="hidden" id="id_curso" name="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
            
                <div class="tab-panels">
                    <!-- SECCIONES -->
                    <section id="marzen" class="tab-panel">
                        <div id="lista_seccion" class="box-body table-responsive">
                        </div>
                    </section>

                    <!-- REQUISITOS -->
                    <section id="rauchbier" class="tab-panel">
                        <div id="lista_requisito" class="box-body table-responsive">
                        </div>
                    </section>

                    <!-- SALONES -->
                    <section id="rauchbier1" class="tab-panel">
                        <!--<div class="box-body table-responsive">
                            
                            <table id="example3" class="table table-hover table-striped table-bordered text-center" >
                                <thead>
                                    <tr style="background-color: #E5E5E5;">
                                        <th width="1%">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr class="even pointer">
                                        <td  align="left"></td> 
                                        
                                        </tr>
                                </tbody>
                            </table>
                        </div>-->
                    </section>
                    
                    <!-- ESTUDIANTES -->
                    <section id="rauchbier2" class="tab-panel">
                        <div class="box-body table-responsive">
                            <div style="margin-bottom: 15px;">
                            <a title="Nuevo Estudiante en Curso" style="cursor:pointer;" data-toggle="modal" data-target="#acceso_modal_eli" 
                            app_crear_eli="<?= site_url('BabyLeaders/Modal_Alumno_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Alumno" />
                            </a>
                            </div>
                            <div id="lista_alumno">
                            </div>
                        </div>
                    </section>

                    <!-- MATRICULA -->
                    <section id="rauchbier3" class="tab-panel"> 
                        <!--<div class="box-body table-responsive">
                            <table id="example8" class="table table-hover table-striped table-bordered text-center" >
                                <thead>
                                    <tr style="background-color: #E5E5E5;">
                                        <th width="1%">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr class="even pointer">
                                        <td  align="left"></td> 
                                        </tr>
                                </tbody>
                            </table>
                        </div>-->
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#academicos").addClass('active');
        $("#hacademicos").attr('aria-expanded', 'true');
        $("#cursos").addClass('active');
        document.getElementById("racademicos").style.display = "block";

        Lista_Seccion();
        Lista_Requisito();
        Lista_Alumno();
    } );

    function Lista_Seccion(){
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

        var id_curso = $("#id_curso").val();
        var url="<?php echo site_url(); ?>BabyLeaders/Lista_Seccion_Curso";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_curso':id_curso},
            success:function (data) {
                $('#lista_seccion').html(data);
            }
        });
    }

    function Delete_Asignar_Seccion(id){ 
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

        var url="<?php echo site_url(); ?>BabyLeaders/Delete_Asignar_Seccion";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_matricula':id},
            success:function (data) {
                Lista_Seccion();
            }
        });
    }

    function Lista_Requisito(){
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

        var id_curso = $("#id_curso").val();
        var url="<?php echo site_url(); ?>BabyLeaders/Lista_Requisito_Curso";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_curso':id_curso},
            success:function (data) {
                $('#lista_requisito').html(data);
            }
        });
    }

    function Lista_Alumno(){
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

        var id_curso = $("#id_curso").val();
        var url="<?php echo site_url(); ?>BabyLeaders/Lista_Alumno_Curso";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_curso':id_curso},
            success:function (data) {
                $('#lista_alumno').html(data);
            }
        });
    }

    function Cerrar_Curso(id,nombre){
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
            
        var url="<?php echo site_url(); ?>BabyLeaders/Cerrar_Curso";

        Swal({
            title: '¿Realmente quieres cerrar '+ nombre +'?',
            text: "El registro será cerrado permanentemente",
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
                    url: url,
                    data: {'id_curso':id},
                    success:function (data) {
                        if(data=="error"){
                            Swal({
                                title: 'Cierre Denegado',
                                text: "¡Alumnos Matriculados encontrados!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else{
                            Swal(
                                'Cerrado!',
                                'El curso ha sido cerrado satisfactoriamente.',
                                'success'
                            ).then(function() {
                            window.location = "<?php echo site_url(); ?>BabyLeaders/Detalle_Curso/"+id;
                            });
                        }
                    }
                });
            }
        })
    }

    function Curso_Cerrado(){
        Swal({
            title: 'Curso Cerrado!',
            text: "Acción denegada porque el curso está cerrado!",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        });
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>