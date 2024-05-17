<select name="ciclo" id="ciclo" class="form-control" onchange="Busca_Turno_Invitar()">
    <option value="0">Seleccione</option>
    <?php foreach($list_ciclo as $list){?>
    <option value="<?php echo $list['id_ciclo'] ?>"><?php echo $list['ciclo'] ?></option>
    <?php }?>
</select>