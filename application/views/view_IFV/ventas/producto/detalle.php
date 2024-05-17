<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>

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

<style>
    .margintop{
        margin-top:5px ;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
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

    .tamanio{
        height: 20px;
        width: 20px;
    }
</style>

<?php $this->load->view('view_IFV/nav'); ?>  

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Producto - <?php echo $get_id[0]['cod_producto']; ?></b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('AppIFV/Producto_Venta') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container-fluid">
        <div id="div_editar" class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Código: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Código" maxlength="5" value="<?php echo $get_id[0]['cod_producto']; ?>" disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Tipo: </label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo as $list){ ?>
                            <option value="<?php echo $list['id_tipo']; ?>" <?php if($list['id_tipo']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                                <?php echo $list['cod_tipo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

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

                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Nombre en Sistema: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Nombre en Sistema" value="<?php echo $get_id[0]['nom_sistema']; ?>" disabled>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Nombre Documento: </label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Nombre Documento" value="<?php echo $get_id[0]['nom_documento']; ?>" disabled>
                </div>

                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Fecha Inicio Pago: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" value="<?php echo $get_id[0]['fec_inicio']; ?>" disabled>
                </div>

                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Fecha Fin Pago: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" value="<?php echo $get_id[0]['fec_fin']; ?>" disabled>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Monto: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Monto" value="<?php echo $get_id[0]['monto']; ?>" disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Descuento: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Descuento" value="<?php echo $get_id[0]['descuento']; ?>" disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Validado: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" placeholder="Validado" value="<?php echo $get_id[0]['validado']; ?>" disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Código: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" value="1" <?php if($get_id[0]['codigo']==1){ echo "checked"; } ?> disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop" title="Pago Automatizado">Pago Auto.: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" value="1" <?php if($get_id[0]['pago_automatizado']==1){ echo "checked"; } ?> disabled>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Estado: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <?php if(($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==85 || 
                        $_SESSION['usuario'][0]['id_nivel']==6) && $get_id[0]['id_producto']!=17){ ?>
                    <button type="button" class="btn btn-primary" onclick="Div_Editar();" style="background-color: #000;">
                        <i class="glyphicon glyphicon-ok-sign"></i> Editar
                    </button>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked> 
                <label for="tab1">Ventas</label>

                <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['id_producto']; ?>">
                <input type="hidden" id="cod_producto" name="cod_producto" value="<?php echo $get_id[0]['cod_producto']; ?>">
             
                <!-- VENTAS -->
                <div class="tab-panels">
                    <section id="marzen" class="tab-panel">
                        <div id="lista_venta" class="box-body table-responsive">
                        </div> 
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#ventas").addClass('active');
        $("#hventas").attr('aria-expanded', 'true');
        $("#v_productos").addClass('active');
		document.getElementById("rventas").style.display = "block";

        Lista_Venta_Producto_Venta();
    });

    function Div_Editar(){
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

        var id_producto = $('#id_producto').val();
        var url = "<?php echo site_url(); ?>AppIFV/Editar_Producto_Venta";
    
        $.ajax({
            type:"POST",
            data:{'id_producto':id_producto},
            url: url,
            success:function (resp) {
                $('#div_editar').html(resp);
            }
        });
    }

    function Update_Producto_Venta(){
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

        var id_producto = $('#id_producto').val();
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Producto_Venta";

        if (Valida_Update_Producto_Venta()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Producto_Venta/"+id_producto;
                    }
                }
            });
        }    
    }
 
    function Valida_Update_Producto_Venta() {
        if($('#cod_producto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
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
                'Debe ingresar Fecha Inicio Pago.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_fin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin Pago.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto').val() <= 0) {
            Swal(
                'Ups!',
                'Debe ingresar Monto mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descuento').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descuento.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#descuento').val() <= 0) {
            Swal(
                'Ups!',
                'Debe ingresar Descuento mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    } 

    function Lista_Venta_Producto_Venta(){
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

        var cod_producto = $('#cod_producto').val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Venta_Producto_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data: {'cod_producto':cod_producto},
            success:function (resp) {
                $('#lista_venta').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>