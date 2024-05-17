<label class="control-label text-bold">Salón:</label>
<select class="form-control" id="id_salon" name="id_salon"> 
    <option value="0">Seleccione</option>
    <?php foreach($list_salon as $list){ ?> 
        <option value="<?php echo $list['id_salon']; ?>"><?php echo $list['nom_salon']; ?></option>
    <?php } ?>
</select>