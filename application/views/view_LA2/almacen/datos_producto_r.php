<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<form id="formulario_retirar" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="col-md-12 row"> 
        <div class="form-group col-md-12">
            <label class="control-label text-bold">Datos Producto</label> 
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Código: </label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" placeholder="Código" disabled value="<?php echo $get_id[0]['codigo']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Descripción: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" placeholder="Descripción" disabled value="<?php echo $get_id[0]['descripcion']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Stock: </label> 
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" placeholder="Stock" disabled value="<?php echo $stock[0]['stock']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margintop">Cant. a retirar: </label>
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" id="ingresado" name="ingresado" placeholder="Ingresado" value="1" onkeypress="if(event.keyCode == 13){ Insert_Temporal_Retirar_Producto(); }">
        </div>

        <div class="form-group col-md-2">
            <input type="hidden" id="cod_producto" name="cod_producto" value="<?php echo $get_id[0]['codigo']; ?>">
            <input type="hidden" id="id_almacen" name="id_almacen" value="<?php echo $id_almacen; ?>">
            <button type="button" class="btn btn-primary" style="background-color: #0070C0;" onclick="Insert_Temporal_Retirar_Producto();">Guardar</button>
        </div>
    </div> 
</form>

<script>
    $('#ingresado').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
