<?php if($id_producto>0){ ?>
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Tipo" value="<?php echo $get_id[0]['nom_tipo']; ?>" disabled>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Sub-Tipo: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Sub-Tipo" value="<?php echo $get_id[0]['nom_subtipo']; ?>" disabled>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo Producto: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Tipo Producto" value="<?php echo $get_id[0]['descripcion']; ?>" disabled>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Talla/Ref.: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Talla/Ref." value="<?php echo $get_id[0]['talla']; ?>" disabled>
    </div>
<?php }else{ ?>
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Tipo" disabled>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Sub-Tipo: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Sub-Tipo" disabled>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo Producto: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Tipo Producto" disabled>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Talla/Ref.: </label>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" placeholder="Talla/Ref." disabled>
    </div>
<?php } ?>
