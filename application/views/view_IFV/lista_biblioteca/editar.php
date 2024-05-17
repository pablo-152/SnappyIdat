<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .sin_negra{
        font-weight: normal;
    }
    .estilo_boton{
        font-weight:bold;
        height:32px;
        width:150px;
        padding:5px;
    }

    .verde{
        color:#FFF;
        background-color:#92D050;
    }

    .azul{
        color:#FFF;
        background-color:#0070c0;
    }

    .rojo{
        color:#FFF;
        background-color:#C00000;
    }

    .verde:hover{
        color:#FFF;
    }

    .azul:hover{
        color:#FFF;
    }

    .rojo:hover{
        color:#FFF;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Lista Biblioteca <?php echo $get_id[0]['cod_biblioteca']; ?> (Editar)</b></span></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Código:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Código" readonly value="<?php echo $get_id[0]['cod_biblioteca']; ?>">
                </div>

                <div class="form-group col-md-8">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Estado:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Estado" readonly value="<?php echo $get_id[0]['nom_estado']; ?>">
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Especialidad:</label>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" id="id_especialidad" name="id_especialidad" onchange="Modulo();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_especialidad as $list){ ?>
                            <option value="<?php echo $list['id_especialidad']; ?>" <?php if($list['id_especialidad']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>>
                                <?php echo $list['nom_especialidad']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Módulo:</label>
                </div>
                <div id="select_modulo" class="form-group col-md-1">
                    <select class="form-control" id="id_modulo" name="id_modulo" onchange="Ciclo();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_modulo as $list){ ?>
                            <option value="<?php echo $list['id_modulo']; ?>" <?php if($list['id_modulo']==$get_id[0]['id_modulo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_modulo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Ciclo:</label>
                </div>
                <div id="select_ciclo" class="form-group col-md-1">
                    <select class="form-control" id="id_ciclo" name="id_ciclo">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_ciclo as $list){ ?>
                            <option value="<?php echo $list['id_ciclo']; ?>" <?php if($list['id_ciclo']==$get_id[0]['id_ciclo']){ echo "selected"; } ?>>
                                <?php echo $list['nom_ciclo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">U. Didáctica:</label>
                </div>
                <div id="select_unidad_didactica" class="form-group col-md-3">
                    <select class="form-control" id="id_unidad_didactica" name="id_unidad_didactica">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_unidad_didactica as $list){ ?>
                            <option value="<?php echo $list['id_unidad_didactica']; ?>" <?php if($list['id_unidad_didactica']==$get_id[0]['id_unidad_didactica']){ echo "selected"; } ?>>
                                <?php echo $list['nom_unidad_didactica']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Cod. Barra:</label>
                </div>
                <div  class="form-group col-md-2">
                    <input type="text" class="form-control" id="cod_barra" name="cod_barra" placeholder="Código de Barra" value="<?php echo $get_id[0]['cod_barra'] ?>">
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Título:</label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="<?php echo $get_id[0]['titulo']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Sub-Título:</label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="subtitulo" name="subtitulo" placeholder="Sub-Título" value="<?php echo $get_id[0]['subtitulo']; ?>">
                </div>
            </div>
            
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Autor:</label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="autor" name="autor" placeholder="Autor" value="<?php echo $get_id[0]['autor']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Editorial:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="editorial" name="editorial" placeholder="Editorial" value="<?php echo $get_id[0]['editorial']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Año:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros" id="anio" name="anio" placeholder="Año" value="<?php echo $get_id[0]['anio']; ?>">
                </div>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Cant.:</label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros" id="cantidad" name="cantidad" placeholder="Cantidad" value="<?php echo $get_id[0]['cantidad']; ?>">
                </div>

                <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Tipo:</label>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" value="<?php echo $get_id[0]['tipo']; ?>">
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Fecha Compra:</label>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" value="<?php echo $get_id[0]['fecha_compra']; ?>">
                    </div>

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Monto:</label>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="number" class="form-control" id="monto" name="monto" placeholder="Monto" value="<?php echo $get_id[0]['monto']; ?>">
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Observaciones:</label>
                </div>
                <div class="form-group col-md-11">
                    <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" rows="5"><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>

            <!--<div class="col-md-12 row text-center" style="margin-bottom:15px;">
                <a class="btn estilo_boton verde"><span>Requisitar</span></a>
                <a class="btn estilo_boton azul"><span>Devolver</span></a>
                <a class="btn estilo_boton rojo"><span>Perdido</span></a>
            </div>-->

            <div class="modal-footer">
                <input type="hidden" id="id_biblioteca" name="id_biblioteca" value="<?php echo $get_id[0]['id_biblioteca']; ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Lista_Biblioteca();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Lis_Biblioteca') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#bibliotecas").addClass('active');
        $("#hbibliotecas").attr('aria-expanded', 'true');
        $("#listas_biblioteca").addClass('active');
		document.getElementById("rbibliotecas").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Modulo(){
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
        
        var id_especialidad = $('#id_especialidad').val();

        if(id_especialidad>0){
            var url = "<?php echo site_url(); ?>AppIFV/Biblioteca_Especialidad_Modulo";
        
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_especialidad':id_especialidad},
                success:function (resp) {
                    $('#select_modulo').html(resp);
                }
            });
        }else{
            $('#select_modulo').html('<select class="form-control" id="id_modulo" name="id_modulo"><option value="0">Seleccione</option></select>');
        }

        Unidad_Didactica();
    }

    function Ciclo(){
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
        
        var id_especialidad = $('#id_especialidad').val();
        var id_modulo = $('#id_modulo').val();

        if(id_modulo>0){
            var url = "<?php echo site_url(); ?>AppIFV/Biblioteca_Modulo_Ciclo";
        
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_especialidad':id_especialidad,'id_modulo':id_modulo},
                success:function (resp) {
                    $('#select_ciclo').html(resp);
                }
            });
        }else{
            $('#select_ciclo').html('<select class="form-control" id="id_ciclo" name="id_ciclo"><option value="0">Seleccione</option></select>');
        }
    }

    function Unidad_Didactica(){
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
        
        var id_especialidad = $('#id_especialidad').val();

        if(id_especialidad>0){
            var url = "<?php echo site_url(); ?>AppIFV/Unidad_Didactica";
        
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_especialidad':id_especialidad},
                success:function (resp) {
                    $('#select_unidad_didactica').html(resp);
                }
            });
        }else{
            $('#select_unidad_didactica').html('<select class="form-control" id="id_unidad_didactica" name="id_unidad_didactica"><option value="0">Seleccione</option></select>');
        }
    }

    function Update_Lista_Biblioteca(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Lista_Biblioteca";

        if (Valida_Update_Lista_Biblioteca()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Lis_Biblioteca";
                    });
                }
            });
        }
    }

    function Valida_Update_Lista_Biblioteca() {
        if($('#id_especialidad').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#id_modulo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar módulo.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if($('#cod_barra').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar código de barra.',
                'warning'
            ).then(function() { });
            return false;
        }/*if($('#id_unidad_didactica').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar unidad didática.',
                'warning'
            ).then(function() { });
            return false;
        }*/if($('#titulo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar título.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#autor').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar autor.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad').val()<1 ) {
            Swal(
                'Ups!',
                'Debe ingresar cantidad válida.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>