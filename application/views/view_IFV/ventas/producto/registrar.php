<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?> 

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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Producto (Nuevo)</b></span></h4>
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
        <form id="formulario" method="POST" enctype="multipart/form-data" class="formulario"> 
            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Código: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" id="cod_producto" name="cod_producto" placeholder="Código" maxlength="5">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Tipo: </label>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" id="id_tipo" name="id_tipo">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo as $list){ ?>
                            <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['cod_tipo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Año: </label>
                </div>
                <div class="form-group col-md-1">
                    <select class="form-control" id="id_anio" name="id_anio">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_anio as $list){ ?>
                            <option value="<?php echo $list['id_anio']; ?>"><?php echo $list['nom_anio']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Nombre en Sistema: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="nom_sistema" name="nom_sistema" placeholder="Nombre en Sistema">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Nombre Documento: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="nom_documento" name="nom_documento" placeholder="Nombre Documento">
                </div>

                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Fecha Inicio Pago: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fec_inicio" name="fec_inicio">
                </div>

                <div class="form-group col-md-2 text-right">
                    <label class="control-label text-bold margintop">Fecha Fin Pago: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="fec_fin" name="fec_fin">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Monto: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros_punto" id="monto" name="monto" placeholder="Monto">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Descuento: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros_punto" id="descuento" name="descuento" placeholder="Descuento">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Validado: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control solo_numeros" id="validado" name="validado" placeholder="Validado">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Código: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="codigo" name="codigo" value="1">
                </div>

                <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop" title="Pago Automatizado">Pago Auto.: </label> 
                </div>
                <div class="form-group col-md-1">
                    <input type="checkbox" class="tamanio" id="pago_automatizado" name="pago_automatizado" value="1">
                </div> 
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="Insert_Producto_Venta();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Producto_Venta') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#ventas").addClass('active');
        $("#hventas").attr('aria-expanded', 'true');
        $("#v_productos").addClass('active');
		document.getElementById("rventas").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,-]/g, '');
    });

    function Insert_Producto_Venta(){
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Producto_Venta";

        if (Valida_Insert_Producto_Venta()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
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
                        window.location = "<?php echo site_url(); ?>AppIFV/Producto_Venta";
                    }
                }
            });
        }    
    } 

    function Valida_Insert_Producto_Venta() {
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
</script>

<?php $this->load->view('view_IFV/footer'); ?>