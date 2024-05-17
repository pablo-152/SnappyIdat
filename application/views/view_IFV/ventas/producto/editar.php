<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Código: </label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" id="cod_producto" name="cod_producto" placeholder="Código" maxlength="5" value="<?php echo $get_id[0]['cod_producto']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Tipo: </label>
        </div>
        <div class="form-group col-md-2">
            <select class="form-control" id="id_tipo" name="id_tipo">
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
            <select class="form-control" id="id_anio" name="id_anio">
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
            <input type="text" class="form-control" id="nom_sistema" name="nom_sistema" placeholder="Nombre en Sistema" value="<?php echo $get_id[0]['nom_sistema']; ?>">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2 text-right">
            <label class="control-label text-bold margintop">Nombre Documento: </label> 
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" id="nom_documento" name="nom_documento" placeholder="Nombre Documento" value="<?php echo $get_id[0]['nom_documento']; ?>">
        </div>

        <div class="form-group col-md-2 text-right">
            <label class="control-label text-bold margintop">Fecha Inicio Pago: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="date" class="form-control" id="fec_inicio" name="fec_inicio" value="<?php echo $get_id[0]['fec_inicio']; ?>">
        </div>

        <div class="form-group col-md-2 text-right">
            <label class="control-label text-bold margintop">Fecha Fin Pago: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="date" class="form-control" id="fec_fin" name="fec_fin" value="<?php echo $get_id[0]['fec_fin']; ?>">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Monto: </label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control solo_numeros_punto" id="monto" name="monto" placeholder="Monto" value="<?php echo $get_id[0]['monto']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Descuento: </label> 
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control solo_numeros_punto" id="descuento" name="descuento" placeholder="Descuento" value="<?php echo $get_id[0]['descuento']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Validado: </label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control solo_numeros" id="validado" name="validado" placeholder="Validado" value="<?php echo $get_id[0]['validado']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Código: </label>  
        </div>
        <div class="form-group col-md-1">
            <input type="checkbox" class="tamanio" id="codigo" name="codigo" value="1" <?php if($get_id[0]['codigo']==1){ echo "checked"; } ?>>
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop" title="Pago Automatizado">Pago Auto.: </label> 
        </div>
        <div class="form-group col-md-1">
            <input type="checkbox" class="tamanio" id="pago_automatizado" name="pago_automatizado" value="1" <?php if($get_id[0]['pago_automatizado']==1){ echo "checked"; } ?>>
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Estado: </label> 
        </div>
        <div class="form-group col-md-1">
            <select class="form-control" id="estado" name="estado">
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
        <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['id_producto']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Producto_Venta();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Detalle_Producto_Venta') ?>/<?php echo $get_id[0]['id_producto']; ?>">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </a>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,-]/g, '');
    });
</script>