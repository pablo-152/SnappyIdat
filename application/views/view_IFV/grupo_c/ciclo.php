<label class="control-label text-bold">Ciclo:</label> 
<select class="form-control" id="id_ciclo" name="id_ciclo" onchange="Esconder();">
    <option value="0">Seleccione</option> 
    <?php foreach($list_ciclo as $list){ ?>
        <option value="<?php echo $list['id_ciclo']."-".$list['ciclo']; ?>"><?php echo $list['ciclo']; ?></option>
    <?php } ?>
</select>