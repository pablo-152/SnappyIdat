<label>Local:</label>
<div class="col">
    <select required class="form-control" name="id_local" id="id_local" >
    <option value="0">Seleccione</option>
    <?php foreach($list_local as $list){ ?>
        <option value="<?php echo $list['id_inventario_local']; ?>"><?php echo $list['nom_local'];?></option>
    <?php } ?>
    </select>
</div>