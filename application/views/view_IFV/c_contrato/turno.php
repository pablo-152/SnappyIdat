<select class="form-control" id="<?php echo $id_turno; ?>" name="<?php echo $id_turno; ?>" <?php if($alumno==2){ ?> onchange="<?php echo $onchange; ?>" <?php } ?>> 
    <option value="0">Todos</option> 
    <?php foreach($list_turno as $list){ ?>
        <option value="<?php echo $list['Turno']; ?>"><?php echo $list['Turno']; ?></option>   
    <?php } ?> 
</select> 