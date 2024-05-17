<select class="form-control" id="id_producto" name="id_producto">
    <option value="0">Seleccione</option>
    <?php foreach($list_producto as $list){ ?>
        <option value="<?php echo $list['id_producto']; ?>"><?php echo $list['nom_producto']; ?></option>
    <?php } ?>
</select>