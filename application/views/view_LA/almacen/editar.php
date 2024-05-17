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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Almacén</b></span></h4>
                </div>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group"> 
                    <a type="button" href="<?= site_url('Laleli/Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                    <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Año: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_anio_u" name="id_anio_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?php echo $list['id_anio']; ?>" <?php if($list['id_anio']==$get_id[0]['id_anio']){ echo "selected"; } ?>>
                                <?php echo $list['nom_anio']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Empresa: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_empresa_u" name="id_empresa_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_combo_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                                <?php echo $list['cod_empresa']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Sede: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_sede_u" name="id_sede_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_sede as $list){ ?>
                            <option value="<?php echo $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede']){ echo "selected"; } ?>>
                                <?php echo $list['cod_sede']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Descripción: </label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" maxlength="25" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['descripcion']; ?>" onkeypress="if(event.keyCode == 13){ Update_Almacen(); }">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Responsable: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_responsable_u" name="id_responsable_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_responsable']){ echo "selected"; } ?>>
                                <?php echo $list['usuario_codigo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Supervisor: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_supervisor_u" name="id_supervisor_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_supervisor']){ echo "selected"; } ?>>
                                <?php echo $list['usuario_codigo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Entrega: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_entrega_u" name="id_entrega_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_entrega']){ echo "selected"; } ?>>
                                <?php echo $list['usuario_codigo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1" text-right> 
                    <label class="control-label text-bold margintop">Administrador: </label>
                </div> 
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_administrador_u" name="id_administrador_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_administrador']){ echo "selected"; } ?>>
                                <?php echo $list['usuario_codigo']; ?>
                            </option>
                        <?php } ?>
                    </select> 
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Vendedor(es): </label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control multivalue_u" id="id_vendedor_u" name="id_vendedor_u[]" multiple>
                        <?php $base_array = explode(",",$get_id[0]['id_vendedor']);
                            foreach($list_usuario as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>" <?php if(in_array($list['id_usuario'],$base_array)){ echo "selected=\"selected\""; } ?>>
                                <?php echo $list['usuario_codigo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Observaciones: </label> 
                </div>
                <div class="form-group col-md-5">
                    <input type="text" class="form-control" id="observaciones_u" name="observaciones_u" placeholder="Ingresar Observaciones" value="<?php echo $get_id[0]['observaciones']; ?>" onkeypress="if(event.keyCode == 13){ Update_Almacen(); }">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Principal: </label>
                </div>
                <div class="form-group col-md-1"> 
                    <input type="checkbox" class="tamanio" id="principal_u" name="principal_u" value="1" <?php if($get_id[0]['principal']==1){ echo "checked"; } ?>>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Doc Sunat: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="doc_sunat_u" name="doc_sunat_u" value="1" <?php if($get_id[0]['doc_sunat']==1){ echo "checked"; } ?>>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Trash: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="trash_u" name="trash_u" value="1" <?php if($get_id[0]['trash']==1){ echo "checked"; } ?>>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="form-group col text-bold margintop">Estado:</label>                 
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" name="estado_u" id="estado_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>  
            </div>
            
            <div class="modal-footer">
                <input type="hidden" id="id_almacen" name="id_almacen" value="<?php echo $get_id[0]['id_almacen']; ?>">
                <input type="hidden" id="almacen_principal_u" value="<?php echo $get_id[0]['principal']; ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Almacen();">
                    <i class="glyphicon glyphicon-ok-sign"></i>Guardar
                </button>
                <a type="button" class="btn btn-default" href="<?= site_url('Laleli/Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                    <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
                </a>
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

    var ss = $(".multivalue_u").select2({
        tags: true
    });

    function Update_Almacen(){
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

        var id = $('#id_almacen').val(); 
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Laleli/Update_Almacen";

        var almacen_principal = $('#almacen_principal_u').val(); 

        if (Valida_Update_Almacen()) {
            if(almacen_principal==0 && $('#principal_u').is(':checked')){
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
                                    window.location = "<?php echo site_url(); ?>Laleli/Detalle_Almacen/"+id;
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
                            window.location = "<?php echo site_url(); ?>Laleli/Detalle_Almacen/"+id;
                        }
                    }
                });
            }
        }    
    }
 
    function Valida_Update_Almacen() {
        if($('#id_anio_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_empresa_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sede.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '0') {
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

<?php $this->load->view('view_LA/footer'); ?>