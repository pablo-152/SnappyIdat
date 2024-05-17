<option  value="0">Seleccione</option>
<?php foreach($list_provincia as $list){ ?>
    <option value="<?php echo $list['codigo_provincia']; ?>"><?php echo $list['nombre_provincia']; ?></option>
<?php } ?>
