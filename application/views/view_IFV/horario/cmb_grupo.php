<select name="grupo" id="grupo" class="form-control" onchange="Busca_Turno()">
    <option value="0">Seleccione</option>
    <?php foreach($list_grupo as $list){?> 
        <option value="<?php echo $list['id_grupo'] ?>"><?php echo $list['grupo'] ?></option>
    <?php }?>
</select>