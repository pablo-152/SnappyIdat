<label class="control-label text-bold">Distrito: </label>
<select class="form-control" name="id_distrito" id="id_distrito">
    <option value="0">Seleccione</option>
    <?php foreach($list_distrito as $list){ ?>  
        <option value="<?php echo $list['id_distrito']; ?>"><?php echo $list['nombre_distrito']; ?></option> 
    <?php } ?>
</select>  