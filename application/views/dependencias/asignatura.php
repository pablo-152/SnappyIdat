<!--<select class="form-control" name="id_provincia" id="id_provincia" onchange="distrito()">
<option  value="0">Seleccionar</option>
<?php foreach($list_provincia as $list){ ?>
    <option value="<?php echo $list['id_provincia']; ?>">
    <?php echo $list['nombre_provincia'];?></option>
<?php } ?>
</select>-->

<select class="form-control" name="id_asignatura" id="id_asignatura">
    <option value="0">Seleccione</option>
        <?php foreach($list_asignatura as $nivel){ ?>
        <option value="<?php echo $nivel['id_asignatura'] ; ?>">
        <?php echo $nivel['descripcion_asignatura'];?></option>
        <?php } ?>
</select>