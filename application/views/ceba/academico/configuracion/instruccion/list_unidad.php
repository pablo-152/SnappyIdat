
<select class="form-control" name="id_unidad" id="id_unidad"  onchange="Tema()">
    <option  value="0">Seleccionar</option>
    <?php foreach($list_unidad as $list){ ?>
        <option value="<?php echo $list['id_unidad']; ?>"><?php echo $list['nom_unidad'];?></option>
    <?php } ?>
</select>