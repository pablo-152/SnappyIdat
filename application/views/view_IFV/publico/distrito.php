<option value="0">Seleccione</option>
<?php foreach($list_distrito as $list){ ?> 
    <option value="<?php echo $list['id_distrito']; ?>"><?php echo $list['nombre_distrito']; ?></option>
<?php } ?>