<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Curso (Editar)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="margin-right:5px;" type="button" href="<?= site_url('BabyLeaders/Detalle_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Nombre:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="nom_curso" name="nom_curso" placeholder="Nombre" value="<?php echo $get_id[0]['nom_curso']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Grado:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="id_grado" id="id_grado">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_grado as $list){ ?>
                            <option value="<?php echo $list['id_grado'] ; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_grado']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Año:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="id_anio" id="id_anio">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?php echo $list['id_anio'] ; ?>" <?php if($list['id_anio']==$get_id[0]['id_anio']){ echo "selected"; } ?>>
                                <?php echo $list['nom_anio']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!--<div class="form-group col-md-1">
                    <label class="control-label text-bold">Grupo:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo" value="<?php echo $get_id[0]['grupo']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Unidad:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="<?php echo $get_id[0]['unidad']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Turno:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" id="turno" name="turno">
                        <option value="0" <?php //if($get_id[0]['turno']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php //if($get_id[0]['turno']==1){ echo "selected"; } ?>>L-M-V</option>
                    </select>
                </div>-->
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Inicio Matrícula: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fec_inicio" name="fec_inicio" value="<?php echo $get_id[0]['fec_inicio']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Fin Matrícula: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fec_fin" name="fec_fin" value="<?php echo $get_id[0]['fec_fin']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Inicio Curso: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="inicio_curso" name="inicio_curso" value="<?php echo $get_id[0]['inicio_curso']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Fin Curso: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fin_curso" name="fin_curso" value="<?php echo $get_id[0]['fin_curso']; ?>">
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Estado:</label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" name="estado" id="estado">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status'] ; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="hidden" id="id_curso" name="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Curso();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('BabyLeaders/Detalle_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#academicos").addClass('active');
        $("#hacademicos").attr('aria-expanded', 'true');
        $("#cursos").addClass('active');
		document.getElementById("racademicos").style.display = "block"; 
    }); 

    function Update_Curso(){
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

        var id = $("#id_curso").val();
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Curso";

        if (Valida_Update_Curso()) { 
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
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
                        window.location = "<?php echo site_url(); ?>BabyLeaders/Detalle_Curso/"+id;
                    }
                }
            }); 
        }    
    }

    function Valida_Update_Curso() {
        if($('#nom_curso').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_anio').val().trim() === '0') { 
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_inicio').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_fin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>