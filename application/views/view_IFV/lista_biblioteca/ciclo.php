<select class="form-control" id="id_ciclo" name="id_ciclo">
    <option value="0">Seleccione</option>
    <?php foreach ($list_ciclo as $list) { ?>
        <option value="<?php echo $list['id_ciclo']; ?>"><?php echo $list['nom_ciclo']; ?></option>
    <?php } ?>
</select>