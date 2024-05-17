<select name="modulo" id="modulo" class="form-control" onchange="Busca_Ciclo_Invitar()">
    <option value="0">Seleccione</option>
    <?php foreach($list_modulo as $list){?>
    <option value="<?php echo $list['id_modulo'] ?>"><?php echo $list['modulo'] ?></option>
    <?php }?>
</select>