<?php
    $sesion =  $_SESSION['usuario'][0];
    defined('BASEPATH') or exit('No direct script access allowed');
    $id_nivel = $_SESSION['usuario'][0]['id_nivel']; 
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .fondo_ref{
        background-color: #715d74 !important;
        color: white;
    }

    .grande_check{
        width: 20px;
        height: 20px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Público (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('AppIFV/Publico') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Referencia:</label>
                    <input type="text" class="form-control fondo_ref" value="<?php echo $codigo ?>" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Tipo:</label>
                    <select class="form-control" id="id_tipo" name="id_tipo">
                        <option value="0" >Seleccione</option>
                        <?php foreach($list_tipo as $list){ ?>
                            <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Usuario:</label><br>
                    <input name="" type="text" class="form-control" id="" value ="<?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>" readonly>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-6">
                    <label class="control-label text-bold">Nombres y Apellidos:</label>
                    <input name="nombres_apellidos" type="text" class="form-control" id="nombres_apellidos" placeholder="Nombres y Apellidos" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">DNI:</label>
                    <input type="text" class="form-control solo_numeros" id="n_documento" name="n_documento" placeholder="DNI" maxlength="8" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>

                <div class="form-group col-md-3"> 
                    <label class="control-label text-bold">Contacto 1:</label>
                    <input type="text" class="form-control solo_numeros" id="contacto1" name="contacto1" maxlength="9" placeholder="Contacto Principal" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Contacto 2:</label>
                    <input type="text" class="form-control solo_numeros" id="contacto2" name="contacto2" maxlength="9" placeholder="Contacto 2" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Departamento:</label>
                    <select class="form-control" id="id_departamento" name="id_departamento" onchange="Busca_Provincia();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_departamento as $list){ ?>
                            <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Provincia:</label>
                    <select class="form-control" id="id_provincia" name="id_provincia" onchange="Busca_Distrito();">
                        <option value="0" >Seleccione</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Distrito:</label>
                    <select class="form-control" id="id_distrito" name="id_distrito">
                        <option value="0" >Seleccione</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Correo:</label>
                    <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Facebook:</label>
                    <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold" title="Registros adicionales independientes del actual!">N°&nbsp;Duplicados:</label>
                    <input type="text" class="form-control solo_numeros" id="duplicado" name="duplicado" maxlength="9" placeholder="N° Duplicados" onkeypress="if(event.keyCode == 13){ Insert_Publico(); }">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">No&nbsp;mailing:</label>
                    <div class="col">
                        <input type="checkbox" id="mailing" name="mailing" value="1"> 
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Producto&nbsp;Interese:</label>
                    <select class="form-control" id="id_producto_interes" name="id_producto_interes">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_producto_interes as $list){ ?>
                            <option value="<?php echo $list['id_producto_interes']; ?>"><?php echo $list['nom_producto_interes']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Comentario:</label>
                    <textarea class="form-control" id="comentario" name="comentario" placeholder="Comentario" rows="1" maxlength="35"></textarea>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Observaciones:</label>
                    <textarea class="form-control" id="observacion" name="observacion" placeholder="Observaciones" rows="5"></textarea>
                </div>                           
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="Insert_Publico();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Publico') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#titulacion").addClass('active');
        $("#htitulacion").attr('aria-expanded','true');
        $("#titu_publicos").addClass('active');
        document.getElementById("rtitulacion").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Busca_Provincia(){
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

        var id_departamento = $('#id_departamento').val();
        var url="<?php echo site_url(); ?>AppIFV/Muestra_Provincia";
        
        $.ajax({
            type:"POST",
            url:url,
            data:{'id_departamento':id_departamento},
            success:function (data) { 
                $('#id_provincia').html(data);
                $('#id_distrito').html('<option value="0">Seleccione</option>');
            }
        });
    }

    function Busca_Distrito(){
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

        var id_provincia = $('#id_provincia').val();
        var url="<?php echo site_url(); ?>AppIFV/Muestra_Distrito";
        
        $.ajax({
            type:"POST",
            url:url,
            data:{'id_provincia':id_provincia},
            success:function (data) { 
                $('#id_distrito').html(data);
            }
        });
    }

    function Insert_Publico(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Publico";

        if (Valida_Insert_Publico()) {
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
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Publico";
                        });
                    }
                }
            });
        }
    }

    function Valida_Insert_Publico() {
        emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

        if($('#id_tipo').val()=="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombres_apellidos').val()==""){
            Swal(
                'Ups!',
                'Debe ingresar Nombres y Apellidos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#n_documento').val()!=""){
            var dni = $('#n_documento').val();

            if(dni.length!=8) {
                Swal(
                    'Ups!',
                    'DNI debe tener 8 dígitos.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#contacto1').val()=="" && $('#correo').val()==""){
            Swal(
                'Ups!',
                'Debe ingresar Contacto 1 o Correo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#contacto1').val()!=""){
            var celu = $('#contacto1').val();
            var num = celu.split('');

            if(celu.length!=9) {
                Swal(
                    'Ups!',
                    'Contacto 1 debe tener 9 dígitos.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if(num[0]!=9) {
                Swal(
                    'Ups!',
                    'Contacto 1 debe iniciar con 9.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#correo').val()!=""){
            if(!emailRegex.test($('#correo').val())){
                Swal(
                    'Ups!',
                    'Debe ingresar Correo Válido.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>
