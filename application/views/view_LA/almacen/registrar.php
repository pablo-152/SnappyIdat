<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA/header'); ?>
<?php $this->load->view('view_LA/nav'); ?>

<style>
    .margintop{
      margin-top:5px ;
    }

    .tamanio{
        height: 20px;
        width: 20px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Almacén (Nuevo)</b></span></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Año: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_anio_i" name="id_anio_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?php echo $list['id_anio']; ?>"><?php echo $list['nom_anio']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Empresa: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_empresa_i" name="id_empresa_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_combo_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Sede: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_sede_i" name="id_sede_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_sede as $list){ ?>
                            <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Descripción: </label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" maxlength="25" placeholder="Ingresar Descripción" onkeypress="if(event.keyCode == 13){ Insert_Almacen(); }">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Responsable: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_responsable_i" name="id_responsable_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Supervisor: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_supervisor_i" name="id_supervisor_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Entrega: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_entrega_i" name="id_entrega_i"> 
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?> 
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Administrador: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_administrador_i" name="id_administrador_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Vendedor(es): </label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control multivalue_i" id="id_vendedor_i" name="id_vendedor_i[]" multiple>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Observaciones: </label> 
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="observaciones_i" name="observaciones_i" placeholder="Ingresar Observaciones" onkeypress="if(event.keyCode == 13){ Insert_Almacen(); }">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Principal: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="principal_i" name="principal_i" value="1">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Doc Sunat: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="doc_sunat_i" name="doc_sunat_i" value="1">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Trash: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="trash_i" name="trash_i" value="1">
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="hidden" id="almacen_principal_i" value="<?php echo $almacen_principal; ?>">
                <button type="button" class="btn btn-primary" onclick="Insert_Almacen();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('Laleli/Almacen') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#almacen").addClass('active');
        $("#halmacen").attr('aria-expanded', 'true');
        $("#a_listas_almacenes").addClass('active');
		document.getElementById("ralmacen").style.display = "block";
    });

    var ss = $(".multivalue_i").select2({
        tags: true
    });

    function Insert_Almacen(){
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
        var url="<?php echo site_url(); ?>Laleli/Insert_Almacen";

        var almacen_principal = $('#almacen_principal_i').val();
  
        if (Valida_Insert_Almacen()) {
            if(almacen_principal>0 && $('#principal_i').is(':checked')){ 
                Swal({
                    title: '¿Realmente desea convertir en principal este almacén?',
                    text: "Este será el nuevo almacén principal",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            data: dataString,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="punto_venta"){
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡Ya existe Punto de Venta para esta sede!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }else{
                                    window.location = "<?php echo site_url(); ?>Laleli/Almacen";
                                }
                            }
                        });
                    }
                })
            }else{
                $.ajax({
                    url: url,
                    data: dataString,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success:function (data) {
                        if(data=="almacen"){
                            Swal({
                                title: 'Registro Denegado',
                                text: "¡Ya existe Almacén para esta sede!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else if(data=="punto_venta"){
                            Swal({
                                title: 'Registro Denegado',
                                text: "¡Ya existe Punto de Venta para esta sede!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else{
                            window.location = "<?php echo site_url(); ?>Laleli/Almacen";
                        }
                    }
                });
            }
        }    
    } 

    function Valida_Insert_Almacen() {
        if($('#id_anio_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_empresa_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sede.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('view_LA/footer'); ?>