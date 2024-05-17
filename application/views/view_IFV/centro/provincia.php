<label class="control-label text-bold">Provincia:</label>
<select id="provincia" name="provincia" class="form-control" onchange="Distrito();">
    <option value="0" >Seleccione</option>
    <?php foreach($list_provincia as $list){ ?>
        <option value="<?php echo $list['id_provincia']; ?>"><?php echo $list['nombre_provincia'];?></option>
    <?php } ?>
</select>