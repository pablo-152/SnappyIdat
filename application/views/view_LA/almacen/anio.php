<select class="form-control" id="id_anio_c" name="id_anio_c">
    <option value="0">Seleccione</option>
    <?php foreach($list_anio as $list){ ?>
        <option value="<?php echo $list['id_anio']; ?>" <?php if($list['nom_anio']==$nom_anio){ echo "selected"; } ?>>
            <?php echo $list['nom_anio']; ?>
        </option>
    <?php } ?> 
</select>