<select class="form-control" name="id_asignatura" id="id_asignatura" onchange="Varios_Tema();">
    <option value="0">Seleccione</option>
    <?php foreach($list_asignatura as $list){ ?>
        <option value="<?php echo $list['id_asignatura']; ?>"><?php echo $list['descripcion_asignatura']; ?></option>
    <?php } ?>
</select>