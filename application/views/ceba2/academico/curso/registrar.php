<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('ceba2/header'); ?>
<?php $this->load->view('ceba2/nav'); ?>

<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Curso (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="margin-right:5px;" type="button" href="<?= site_url('Ceba2/Curso') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="curso_copiado" class="container-fluid">
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class=" control-label text-bold margintop">Curso&nbsp;a&nbsp;Copiar: </label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" id="id_copiar" name="id_copiar" onchange="Curso_Copiar();">
                        <option  value="0">Seleccione</option>
                        <?php foreach($list_curso_copiar as $list){ ?>
                            <option value="<?php echo $list['id_curso']; ?>"><?php echo $list['nom_curso']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Grupo:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Unidad:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Turno:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" id="turno" name="turno">
                        <option value="0">Seleccione</option>
                        <option value="1">L-M-V</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Grado:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="id_grado" id="id_grado">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_grado as $list){ ?>
                            <option value="<?php echo $list['id_grado'] ; ?>"><?php echo $list['descripcion_grado'];?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Año:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="id_anio" id="id_anio">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?php echo $list['id_anio'] ; ?>"><?php echo $list['nom_anio'];?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Inicio Matrícula: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fec_inicio" name="fec_inicio">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Fin Matrícula: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fec_fin" name="fec_fin">
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Inicio Curso: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="inicio_curso" name="inicio_curso">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Fin Curso: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fin_curso" name="fin_curso">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="Insert_Curso();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('Ceba2/Curso') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#academico").addClass('active');
        $("#hcurso").attr('aria-expanded','true');
        $("#curso").addClass('active');
        document.getElementById("rcurso").style.display = "block";
    });

    function Curso_Copiar(){
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

        var id_copiar = $("#id_copiar").val();
        var url="<?php echo site_url(); ?>Ceba2/Curso_Copiar";

        $.ajax({
            type:"POST",
            url: url,
            data: {'id_copiar':id_copiar},
            success:function (data) {
                $("#curso_copiado").html(data);
            }
        });   
    }

    function Insert_Curso(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Ceba2/Insert_Curso";

        if (Valida_Insert_Curso()) {
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
                        window.location = "<?php echo site_url(); ?>Ceba2/Curso";
                    });
                }
            }); 
        }    
    }

    function Valida_Insert_Curso() {
        if($('#id_anio').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_grado').val().trim() === '0') { 
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_inicio').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_fin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_fin').val().trim() < $('#fec_inicio').val().trim()) {
            Swal(
                'Ups!',
                'Fecha Fin debe ser despues de Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('ceba2/validaciones'); ?>
<?php $this->load->view('ceba2/footer'); ?>