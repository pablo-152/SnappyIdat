<select name="especialidad" id="especialidad" class="form-control" onchange="Busca_Modulo_Invitar()">
    <option value="0">Seleccione</option>
    <?php foreach($list_especialidad as $list){?>
    <option value="<?php echo $list['id_especialidad'] ?>"><?php echo $list['nom_especialidad'] ?></option>
    <?php }?>
</select>