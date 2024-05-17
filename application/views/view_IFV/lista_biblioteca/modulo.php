<select class="form-control" id="id_modulo" name="id_modulo" onchange="Ciclo();">
    <option value="0">Seleccione</option>
    <?php foreach ($list_modulo as $list) { ?>
        <option value="<?php echo $list['id_modulo']; ?>"><?php echo $list['nom_modulo']; ?></option>
    <?php } ?>
</select>