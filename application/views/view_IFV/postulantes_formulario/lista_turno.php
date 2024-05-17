<select class="form-control" id="admi_turno_admision" name="admi_turno_admision">
    <option value="5">Turno de interés</option>
    <?php  foreach ($list_turno as $list) { ?>
        <option value="<?php echo $list['id_confgen']; ?>"><?php echo $list['nom_confgen']; ?>
        </option>
    <?php } ?>
</select>
