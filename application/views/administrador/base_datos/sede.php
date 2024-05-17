<label class="control-label text-bold">Sede: </label>
<select class="form-control" id="<?php echo $id_sede; ?>" name="<?php echo $id_sede; ?>">
    <option value="0">Seleccione</option> 
    <?php foreach($list_sede as $list){ ?>
        <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede']; ?></option>
    <?php } ?>
</select>