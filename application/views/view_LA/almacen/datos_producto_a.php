<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<form id="formulario_anadir" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="col-md-12 row">
        <div class="form-group col-md-12">
            <label class="control-label text-bold">Datos Producto</label>
        </div>
 
        <div class="form-group col-md-1 text-center">
            <label class="control-label text-bold margintop">Código: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" placeholder="Código" disabled value="<?php echo $get_id[0]['codigo']; ?>">
        </div>

        <div class="form-group col-md-1 text-center">
            <label class="control-label text-bold margintop">Tipo Producto: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" placeholder="Tipo Producto" disabled value="<?php echo $get_id[0]['nom_tipo_producto']; ?>">
        </div>

        <div class="form-group col-md-1 text-center">
            <label class="control-label text-bold margintop">Descripción: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" placeholder="Descripción" disabled value="<?php echo $get_id[0]['descripcion']; ?>"> 
        </div>

        <div class="form-group col-md-1 text-center">
            <label class="control-label text-bold margintop">Talla/Ref.: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" placeholder="Talla/Ref." disabled value="<?php echo $get_id[0]['talla']; ?>">
        </div>
    </div> 

    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-center">
            <label class="control-label text-bold margintop">Ingresado: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" id="ingresado" name="ingresado" placeholder="Ingresado" value="1" onkeypress="if(event.keyCode == 13){ Insert_Temporal_Anadir_Producto(); }">
        </div>

        <div class="form-group col-md-2">
            <input type="hidden" id="id_talla" name="id_talla" value="<?php echo $get_id[0]['id_talla']; ?>">
            <input type="hidden" id="id_almacen" name="id_almacen" value="<?php echo $id_almacen; ?>">
            <button type="button" class="btn btn-primary" onclick="Insert_Temporal_Anadir_Producto();">Guardar</button>
        </div>
    </div>
</form>

<script>
    $('#ingresado').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
