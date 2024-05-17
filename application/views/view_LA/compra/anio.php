<select class="form-control" id="<?php echo $id_anio; ?>" name="<?php echo $id_anio; ?>"> 
    <option value="0">Seleccione</option>
    <?php foreach($list_anio as $list){ ?>
        <option value="<?php echo $list['id_anio']; ?>" <?php if($list['nom_anio']==$nom_anio){ echo "selected"; } ?>>
            <?php echo $list['nom_anio']; ?>
        </option>
    <?php } ?> 
</select>