<option value="0">Seleccione</option>
<?php foreach($list_estado as $list){ ?> 
    <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status']; ?></option>
<?php } ?>