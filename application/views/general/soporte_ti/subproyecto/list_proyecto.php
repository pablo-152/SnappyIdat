<select class="form-control" name="id_proyecto_soporte" id="id_proyecto_soporte">
    <option  value="0">Seleccionar</option>
    <?php foreach($list_proyecto as $list){ ?>
        <option value="<?php echo $list['id_proyecto_soporte']; ?>"><?php echo $list['proyecto'];?></option>
    <?php } ?>
</select>