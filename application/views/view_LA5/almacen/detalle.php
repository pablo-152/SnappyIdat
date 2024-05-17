<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA5/header'); ?> 
<?php $this->load->view('view_LA5/nav'); ?>  

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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo $get_id[0]['descripcion']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==$get_id[0]['id_supervisor'] || $_SESSION['usuario'][0]['id_usuario']==$get_id[0]['id_responsable']){ ?>
                            <a title="Transferir Producto" style="margin-right:5px;" href="<?= site_url('Laleli5/Detalle_Transferir_Producto') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                                <img src="<?= base_url() ?>template/img/transferir_producto.png" alt="Transferir Producto" />
                            </a>
                        <?php } ?>

                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                            <a title="Retirar Producto" style="margin-right:5px;" href="<?= site_url('Laleli5/Detalle_Retirar_Producto') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                                <img src="<?= base_url() ?>template/img/retirar_producto.png" alt="Retirar Producto" />
                            </a>
                        <?php } ?>

                        <a type="button" href="<?= site_url('Laleli5/Almacen') ?>" style="margin-right:5px;">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt=""> 
                        </a>

                        <a href="<?= site_url('Laleli5/Excel_Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Año: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" disabled>
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
                    <select class="form-control" disabled>
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
                    <select class="form-control" disabled>
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
                    <input type="text" class="form-control" maxlength="25" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['descripcion']; ?>" disabled>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Responsable: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" disabled>
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
                    <select class="form-control" disabled>
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
                    <select class="form-control" disabled>
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
                    <select class="form-control" disabled>
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
                    <select class="form-control multivalue_u" disabled multiple>
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
                    <input type="text" class="form-control" placeholder="Ingresar Observaciones" value="<?php echo $get_id[0]['observaciones']; ?>" disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Principal: </label>
                </div>
                <div class="form-group col-md-1"> 
                    <input type="checkbox" class="tamanio" value="1" <?php if($get_id[0]['principal']==1){ echo "checked"; } ?> disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Doc Sunat: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" value="1" <?php if($get_id[0]['doc_sunat']==1){ echo "checked"; } ?> disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Trash: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" value="1" <?php if($get_id[0]['trash']==1){ echo "checked"; } ?> disabled>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="form-group col text-bold margintop">Estado:</label>                 
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>  
            </div>
        </div>

        <div class="row">
            <input type="hidden" id="id_almacen" value="<?php echo $get_id[0]['id_almacen']; ?>">
            <div id="lista_detalle_almacen" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#almacen").addClass('active');
        $("#halmacen").attr('aria-expanded', 'true');
        $("#a_listas_almacenes").addClass('active');
		document.getElementById("ralmacen").style.display = "block"; 

        Lista_Detalle_Almacen();
    });

    var ss = $(".multivalue_u").select2({
        tags: true
    });

    function Lista_Detalle_Almacen(){
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

        var url="<?php echo site_url(); ?>Laleli5/Lista_Detalle_Almacen";
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_almacen':id_almacen},
            success:function (resp) {
                $('#lista_detalle_almacen').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('view_LA5/footer'); ?>