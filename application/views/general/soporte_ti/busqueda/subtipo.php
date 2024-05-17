<select class="form-control" id="id_subtipo_d" name="id_subtipo_d">
    <option value="0">Seleccione</option>
    <?php foreach($list_subtipo as $list){ ?>
        <option value="<?php echo $list['id_subtipo']; ?>"><?php echo $list['nom_subtipo']; ?></option>
    <?php } ?>
</select> 