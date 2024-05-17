<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Colaborador</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('CursosCortos/Colaborador') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt=""> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Perfil: </label>
                    <select class="form-control" id="id_perfil" name="id_perfil">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_perfil as $list){ ?> 
                            <option value="<?php echo $list['id_perfil']; ?>" <?php if($get_id[0]['id_perfil']==$list['id_perfil']){ echo "selected"; } ?>>
                                <?php echo $list['nom_perfil']; ?>
                            </option>    
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Apellido Paterno: </label>
                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="<?php echo $get_id[0]['apellido_paterno']; ?>">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Apellido Materno: </label>
                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="<?php echo $get_id[0]['apellido_materno']; ?>">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Nombre(s): </label>
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="<?php echo $get_id[0]['nombres']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">DNI: </label>
                    <input type="text" class="form-control solo_numeros" id="dni" name="dni" placeholder="DNI" maxlength="8" value="<?php echo $get_id[0]['dni']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Correo Personal: </label>
                    <input type="text" class="form-control" id="correo_personal" name="correo_personal" placeholder="Correo Personal" value="<?php echo $get_id[0]['correo_personal']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Correo Corporativo: </label>
                    <input type="text" class="form-control" id="correo_corporativo" name="correo_corporativo" placeholder="Correo Corporativo" value="<?php echo $get_id[0]['correo_corporativo']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Celular: </label>
                    <input type="text" class="form-control solo_numeros" id="celular" name="celular" placeholder="Celular" maxlength="9" value="<?php echo $get_id[0]['celular']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Dirección: </label>
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="<?php echo $get_id[0]['direccion']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Departamento: </label>
                    <select class="form-control" name="id_departamento" id="id_departamento" onchange="Traer_Provincia_Colaborador();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_departamento as $list){ ?>
                            <option value="<?php echo $list['id_departamento']; ?>" <?php if($list['id_departamento']==$get_id[0]['id_departamento']){ echo "selected"; } ?>>
                                <?php echo $list['nombre_departamento'];?>
                            </option>
                        <?php } ?>
                    </select>  
                </div>

                <div id="div_provincia" class="form-group col-md-2">
                    <label class="control-label text-bold">Provincia: </label>
                    <select class="form-control" name="id_provincia" id="id_provincia" onchange="Traer_Distrito_Colaborador();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_provincia as $list){ ?>
                            <option value="<?php echo $list['id_provincia']; ?>" <?php if($list['id_provincia']==$get_id[0]['id_provincia']){ echo "selected"; } ?>>
                                <?php echo $list['nombre_provincia'];?>
                            </option>
                        <?php } ?>
                    </select> 
                </div>

                <div id="div_distrito" class="form-group col-md-2">
                    <label class="control-label text-bold">Distrito: </label>
                    <select class="form-control" name="id_distrito" id="id_distrito">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_distrito as $list){ ?>
                            <option value="<?php echo $list['id_distrito']; ?>" <?php if($list['id_distrito']==$get_id[0]['id_distrito']){ echo "selected"; } ?>>
                                <?php echo $list['nombre_distrito'];?>
                            </option>
                        <?php } ?>
                    </select>  
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Código GLL: </label>
                    <input type="text" class="form-control" id="codigo_gll" name="codigo_gll" placeholder="Código GLL" maxlength="5" value="<?php echo $get_id[0]['codigo_gll']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Inicio Funciones: </label>
                    <input type="date" class="form-control" id="inicio_funciones" name="inicio_funciones" value="<?php echo $get_id[0]['inicio_funciones']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fin Funciones: </label>
                    <input type="date" class="form-control" id="fin_funciones" name="fin_funciones" value="<?php echo $get_id[0]['fin_funciones']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Nickname: </label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname" value="<?php echo $get_id[0]['nickname']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Usuario: </label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo $get_id[0]['usuario']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Clave: </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="¿Cambiar Clave?">
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Foto: </label>
                    <div class="col">
                        <button type="button" onclick="Abrir('foto')">Seleccionar archivo</button>
                        <input type="file" id="foto" name="foto" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
                        <span id="span_documento"><?php if($get_id[0]['foto']!=""){ echo $get_id[0]['nom_documento']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Estado: </label>
                    <select class="form-control" name="estado" id="estado">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status'];?>
                            </option>
                        <?php } ?>
                    </select>  
                </div>

                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Observaciones: </label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Observaciones"><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $get_id[0]['id_colaborador'] ?>">
                <input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $get_id[0]['foto'] ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Colaborador();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('CursosCortos/Colaborador') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#colabores_lista").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Provincia_Colaborador(){
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
        
        var id_departamento = $("#id_departamento").val();
        var url="<?php echo site_url(); ?>CursosCortos/Traer_Provincia_Colaborador";

        $.ajax({
            type:"POST",
            url: url,
            data:{'id_departamento':id_departamento},
            success:function (data) {
                $("#div_provincia").html(data);
                $("#div_distrito").html('<label class="control-label text-bold">Distrito: </label><select class="form-control" name="id_distrito" id="id_distrito"><option value="">Seleccione</option></select>');
            }
        });       
    }

    function Traer_Distrito_Colaborador(){
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
        
        var id_provincia = $("#id_provincia").val();
        var url="<?php echo site_url(); ?>CursosCortos/Traer_Distrito_Colaborador";

        $.ajax({
            type:"POST",
            url: url,
            data:{'id_provincia':id_provincia},
            success:function (data) {
                $("#div_distrito").html(data);
            }
        });       
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
            if(element.files[0].name.substr(-3)=='jpeg' || element.files[0].name.substr(-3)=='png' || element.files[0].name.substr(-3)=='jpg'){
                let img = new Image()
                img.src = window.URL.createObjectURL(event.target.files[0])
                img.onload = () => {
                    if(img.width === 225 && img.height === 225){
                        glosa.innerText = element.files[0].name;
                    }else{
                        Swal({
                            title: 'Registro Denegado',
                            text: "Asegurese de ingresar foto con dimensión de 225x225.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                        archivoInput.value = '';
                        return false;
                    }                
                }  
            }else{
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar foto con extensiones .jpeg, .png y .jpg.",
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

    function Update_Colaborador() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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
        var url = "<?php echo site_url(); ?>CursosCortos/Update_Colaborador";

        if (Valida_Update_Colaborador()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El usuario ya está en uso!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.location = "<?php echo site_url(); ?>CursosCortos/Colaborador";
                    }
                }
            });
        }
    }

    function Valida_Update_Colaborador() {
        if ($('#id_perfil').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#nombres').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#apellido_paterno').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Apellido Paterno.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#apellido_materno').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Apellido Materno.',
                'warning'
            ).then(function() {});
            return false;
        }
        /*if ($('#usuario').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Usuario.',
                'warning'
            ).then(function() {});
            return false;
        }*/
        return true;
    }
</script>

<?php $this->load->view('view_CC/footer'); ?>