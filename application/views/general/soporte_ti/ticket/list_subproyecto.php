<option value="0">Seleccione</option>
<?php foreach($list_proyecto as $list){ ?>
    <option value="<?php echo $list['id_subproyecto_soporte']; ?>"><?php echo $list['subproyecto']; ?></option>
<?php } ?>