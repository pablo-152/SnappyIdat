<form id="formulario_facturacion" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="form-group col-md-4 text-center">
        <label class="checkeable">
            <?php if($get_id[0]['id_tipo_documento']==1){ ?>
                <input type="radio" id="id_tipo_documento_1" name="id_tipo_documento" value="1" checked onclick="Update_Facturacion_Nueva_Venta();">
                <img title="Recibo" src="<?= base_url(); ?>template/img/btn_recibo_color.png">
            <?php }else{ ?> 
                <input type="radio" id="id_tipo_documento_1" name="id_tipo_documento" value="1" onclick="Update_Facturacion_Nueva_Venta();">
                <img title="Recibo" src="<?= base_url(); ?>template/img/btn_recibo_gris.png">
            <?php } ?> 
        </label> 
    </div>

    <?php if($_SESSION['usuario'][0]['id_nivel']!=12){ ?> 
        <div class="form-group col-md-4 text-center">
            <label class="checkeable"> 
                <?php if($get_id[0]['id_tipo_documento']==2){ ?>
                    <input type="radio" id="id_tipo_documento_2" name="id_tipo_documento" value="2" checked onclick="Update_Facturacion_Nueva_Venta();">
                    <img title="Boleta" src="<?= base_url(); ?>template/img/btn_boleta_color.png">
                <?php }else{ ?>
                    <input type="radio" id="id_tipo_documento_2" name="id_tipo_documento" value="2" <?php if($get_almacen[0]['doc_sunat']==1){ ?> onclick="Update_Facturacion_Nueva_Venta();" <?php } ?>>
                    <img title="Boleta" src="<?= base_url(); ?>template/img/btn_boleta_gris.png">
                <?php } ?>
            </label>
        </div>

        <div class="form-group col-md-4 text-center">
            <label class="checkeable">
                <?php if($get_id[0]['id_tipo_documento']==3){ ?>
                    <input type="radio" id="id_tipo_documento_3" name="id_tipo_documento" value="3" checked onclick="Update_Facturacion_Nueva_Venta();">
                    <img title="Factura" src="<?= base_url(); ?>template/img/btn_factura_color.png">
                <?php }else{ ?>
                    <input type="radio" id="id_tipo_documento_3" name="id_tipo_documento" value="3" <?php if($get_almacen[0]['doc_sunat']==1){ ?> onclick="Update_Facturacion_Nueva_Venta();" <?php } ?>>
                    <img title="Factura" src="<?= base_url(); ?>template/img/btn_factura_gris.png">
                <?php } ?>
            </label>
        </div>
    <?php } ?>

    <div class="form-group col-md-2 esconder_boleta">
        <label class="control-label text-bold">DNI: </label>
    </div>
    <div class="form-group col-md-8 esconder_boleta">
        <input type="text" class="form-control solo_numeros" placeholder="DNI" id="dni" name="dni" value="<?php echo $get_id[0]['dni']; ?>" maxlength="8" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder_boleta">
        <label class="control-label text-bold">Nombre: </label>
        <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre" value="<?php echo $get_id[0]['nombre']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-2 esconder_factura">
        <label class="control-label text-bold">RUC: </label>
    </div>
    <div class="form-group col-md-8 esconder_factura">
        <input type="text" class="form-control solo_numeros" placeholder="RUC" id="ruc" name="ruc" value="<?php echo $get_id[0]['ruc']; ?>" maxlength="11" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder_factura">
        <label class="control-label text-bold">Nombre / Empresa: </label>
        <input type="text" class="form-control" placeholder="Nombre / Empresa" id="nom_empresa" name="nom_empresa" value="<?php echo $get_id[0]['nom_empresa']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder_factura">
        <label class="control-label text-bold">Dirección: </label>
        <input type="text" class="form-control" placeholder="Dirección" id="direccion" name="direccion" value="<?php echo $get_id[0]['direccion']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder">
        <label class="control-label text-bold">Ubigeo: </label>
        <input type="text" class="form-control" placeholder="Ubigeo" id="ubigeo" name="ubigeo" value="<?php echo $get_id[0]['ubigeo']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder">
        <label class="control-label text-bold">Distrito: </label>
        <input type="text" class="form-control" placeholder="Distrito" id="distrito" name="distrito" value="<?php echo $get_id[0]['distrito']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder">
        <label class="control-label text-bold">Provincia: </label>
        <input type="text" class="form-control" placeholder="Provincia" id="provincia" name="provincia" value="<?php echo $get_id[0]['provincia']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder">
        <label class="control-label text-bold">Departamento: </label>
        <input type="text" class="form-control" placeholder="Departamento" id="departamento" name="departamento" value="<?php echo $get_id[0]['departamento']; ?>" onchange="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder_boleta_factura">
        <label class="control-label text-bold">Fecha Emisión: </label> 
        <input type="date" class="form-control" id="fec_emision" name="fec_emision" value="<?php echo $get_id[0]['fec_emision']; ?>" min="<?php echo date("Y-m-d",strtotime(date('d-m-Y')."- 2 days")) ?>" onblur="Update_Facturacion_Nueva_Venta();">
    </div>

    <div class="form-group col-md-12 esconder_factura">
        <label class="control-label text-bold">Fecha Vencimiento: </label>
        <input type="date" class="form-control" id="fec_vencimiento" name="fec_vencimiento" value="<?php echo $get_id[0]['fec_vencimiento']; ?>" min="<?php echo date('Y-m-d') ?>" onblur="Update_Facturacion_Nueva_Venta();">
    </div>
</form>

<script>
     $(document).ready(function() {
        $('.esconder').hide();

        if($('#id_tipo_documento_1').is(':checked')){ 
            $('.esconder_boleta').hide();
            $('.esconder_boleta_factura').hide();
            $('.esconder_factura').hide();
            $('#dni').val('');
            $('#nombre').val('');
            $('#ruc').val('');
            $('#nom_empresa').val('');
            $('#direccion').val('');
            $('#ubigeo').val('');
            $('#distrito').val('');
            $('#provincia').val('');
            $('#departamento').val('');
            $('#fec_emision').val('');
            $('#fec_vencimiento').val('');
        }else if($('#id_tipo_documento_2').is(':checked')){
            $('.esconder_boleta').show();
            $('.esconder_boleta_factura').show();
            $('.esconder_factura').hide();
            $('#ruc').val('');
            $('#nom_empresa').val('');
            $('#direccion').val('');
            $('#ubigeo').val('');
            $('#distrito').val('');
            $('#provincia').val('');
            $('#departamento').val('');
            $('#fec_vencimiento').val('');
        }else{
            $('.esconder_boleta').hide();
            $('.esconder_boleta_factura').show();
            $('.esconder_factura').show();
            $('#dni').val('');
            $('#nombre').val('');
        }
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>