<label class="control-label text-bold">Turno:</label> 
<select class="form-control" id="id_turno" name="id_turno">
    <option value="0">Seleccione</option>
    <?php foreach($list_turno as $list){ ?> 
        <option value="<?php echo $list['id_turno']; ?>"><?php echo $list['nom_turno']; ?></option>
    <?php } ?> 
</select>