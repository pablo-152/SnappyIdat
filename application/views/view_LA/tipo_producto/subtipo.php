<select class="form-control" id="<?php echo $id_subtipo; ?>" name="<?php echo $id_subtipo; ?>">
    <option value="0">Seleccione</option>
    <?php foreach($list_subtipo as $list){ ?>
        <option value="<?php echo $list['id_subtipo']; ?>"><?php echo $list['nom_subtipo']; ?></option>
    <?php } ?>
</select>