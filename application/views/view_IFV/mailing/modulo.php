<option value="Todos">Todos</option>
<?php foreach($list_modulo as $list){ ?> 
    <option value="<?php echo $list['Modulo']; ?>"><?php echo $list['Modulo']; ?></option> 
<?php } ?>