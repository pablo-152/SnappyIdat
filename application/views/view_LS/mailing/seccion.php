<option value="Todos">Todos</option>
<?php foreach($list_seccion as $list){ ?> 
    <option value="<?php echo $list['nom_seccion']; ?>"><?php echo $list['nom_seccion']; ?></option>
<?php } ?> 