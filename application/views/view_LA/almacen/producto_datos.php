<div class="form-group col-md-2">
    <label class="control-label text-bold">Empresa: </label>
</div>
<div class="form-group col-md-4">
    <input type="text" class="form-control" placeholder="Empresa" value="<?php echo $get_id[0]['cod_empresa']; ?>" disabled>
</div>

<div class="form-group col-md-2">
    <label class="control-label text-bold">Tipo: </label>
</div>
<div class="form-group col-md-4">
    <input type="text" class="form-control" placeholder="Tipo" value="<?php echo $get_id[0]['nom_tipo_producto']; ?>" disabled>
</div>

<div class="form-group col-md-2">
    <label class="control-label text-bold">Sub-Tipo: </label>
</div>
<div id="div_subtipo_producto_p" class="form-group col-md-4">
    <input type="text" class="form-control" placeholder="Sub-Tipo" value="<?php echo $get_id[0]['nom_subtipo_producto']; ?>" disabled>
</div>

<div class="form-group col-md-2">
    <label class="control-label text-bold">Descripción: </label>
</div>
<div class="form-group col-md-4">
    <input type="text" class="form-control" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>" disabled>
</div>