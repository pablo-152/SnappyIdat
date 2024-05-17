<select name="turno" id="turno" class="form-control" onchange="Busca_Seccion_Invitar()">
    <option value="0">Seleccione</option>
    <?php foreach($list_turno as $list){?>
    <option value="<?php echo $list['id_turno'] ?>"><?php echo $list['nom_turno'] ?></option>
    <?php }?>
</select>