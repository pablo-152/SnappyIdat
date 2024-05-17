<select class="form-control" name="<?php echo $id_subrubro; ?>" id="<?php echo $id_subrubro; ?>" onchange="Traer_Checkbox();">
    <option value="0">Seleccione</option>
    <?php foreach($list_subrubro as $list){ ?>
        <option value="<?php echo $list['id_subrubro']; ?>"><?php echo $list['nom_subrubro']; ?></option>   
    <?php } ?>
</select>