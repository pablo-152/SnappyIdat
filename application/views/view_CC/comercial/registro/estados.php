<?php if($id_historial==""){ ?>
    <select class="form-control" id="id_status_i" name="id_status_i">
        <option value="0">Seleccione</option>
        <?php foreach ($list_status as $list) {
            if ($list['id_status_general'] == 19) { ?>
                <option selected value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status']; ?></option>
            <?php } else { ?>
                <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status']; ?></option>
        <?php }
        } ?>
    </select>
<?php }else{ ?>
    <select class="form-control" id="id_status_u" name="id_status_u">
        <option value="0">Seleccione</option>
        <?php foreach ($list_status as $list) {
            if ($list['id_status_general'] == 19) { ?>
                <option selected value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status']; ?></option>
            <?php } else { ?>
                <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status']; ?></option>
        <?php }
        } ?>
    </select>
<?php } ?>