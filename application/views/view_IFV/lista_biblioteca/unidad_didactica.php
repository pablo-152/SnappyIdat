<select class="form-control" id="id_unidad_didactica" name="id_unidad_didactica">
    <option value="0">Seleccione</option>
    <?php foreach ($list_unidad_didactica as $list) { ?>
        <option value="<?php echo $list['id_unidad_didactica']; ?>"><?php echo $list['nom_unidad_didactica']; ?></option>
    <?php } ?>
</select>