<option value="0">Seleccione</option>
<?php foreach($list_provincia as $list){ ?> 
    <option value="<?php echo $list['id_provincia']; ?>"><?php echo $list['nombre_provincia']; ?></option>
<?php } ?>