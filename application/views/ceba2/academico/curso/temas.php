<select class="form-control" name="id_tema" id="id_tema">
    <option value="0">Seleccione</option>
    <?php foreach($list_tema as $list){ ?>
        <option value="<?php echo $list['id_tema']; ?>"><?php echo $list['desc_tema']; ?></option>
    <?php } ?>
</select>