<select class="form-control" id="<?php echo $id_especialidad; ?>" name="<?php echo $id_especialidad; ?>" onchange="<?php echo $onchange; ?>">
    <option value="0">Todos</option>
    <?php foreach($list_especialidad as $list){ ?> 
        <option value="<?php echo $list['Especialidad']; ?>"><?php echo $list['Especialidad']; ?></option>   
    <?php } ?> 
</select> 