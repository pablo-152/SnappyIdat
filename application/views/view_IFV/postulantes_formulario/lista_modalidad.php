<select class="form-control" id="admi_modalidad_admision" name="admi_modalidad_admision" onchange="Listar_Turno();">
    <option value="5">Modalidad:</option>
    <?php foreach ($list_modalidad as $list) { ?>
        <option value="<?php echo $list['id_confgen']; ?>"><?php echo $list['nom_confgen']; ?>
        </option>
    <?php } ?>
</select>
