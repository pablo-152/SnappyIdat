<label class="control-label text-bold">Modulo:</label> 
<select class="form-control" id="id_modulo" name="id_modulo" onchange="Grupo_Ciclo();">
    <option value="0">Seleccione</option> 
    <?php foreach($list_modulo as $list){ ?>
        <option value="<?php echo $list['id_modulo']."-".$list['modulo']; ?>"><?php echo $list['modulo']; ?></option>
    <?php } ?>
</select>