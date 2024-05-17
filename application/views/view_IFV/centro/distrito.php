<label class="control-label text-bold">Distrito:</label>
<select id="distrito" name="distrito" class="form-control">
    <option value="0" >Seleccione</option>
    <?php foreach($list_distrito as $list){ ?>
        <option value="<?php echo $list['id_distrito']; ?>"><?php echo $list['nombre_distrito'];?></option>
    <?php } ?>
</select>