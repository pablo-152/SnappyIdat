<select name="id_modulo" id="id_modulo" class="form-control">
    <option value="0">Seleccione</option>
    <?php foreach($list_modulo as $list){?> 
        <option value="<?php echo $list['id_modulo'] ?>"><?php echo $list['modulo'] ?></option>
    <?php }?>
</select>