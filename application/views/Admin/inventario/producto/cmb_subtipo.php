<select required class="form-control" name="id_subtipo_inventario" id="id_subtipo_inventario" >
<option value="0">Seleccione</option>
<?php foreach($list_subtipo as $list){ ?>
    <option value="<?php echo $list['id_subtipo_inventario']; ?>"><?php echo $list['nom_subtipo_inventario'];?></option>
<?php } ?>
</select>