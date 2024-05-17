<select class="form-control" id="id_cargo_u" name="id_cargo_u">
    <option value="0">Seleccione</option>
    <?php foreach($list_cargo as $list){ ?>
        <option value="<?php echo $list['id_cargo']; ?>"><?php echo $list['cod_cargo']." - ".$list['desc_cargo'];  ?></option>
    <?php } ?>
</select>