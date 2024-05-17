<option  value="0">Seleccione</option>
<?php foreach($list_proyecto as $list){ ?>
    <option value="<?php echo $list['id_proyecto_soporte']; ?>"><?php echo $list['proyecto']; ?></option>
<?php } ?>
