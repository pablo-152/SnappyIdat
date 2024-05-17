<select class="form-control" id="<?php echo $id_modulo; ?>" name="<?php echo $id_modulo; ?>" <?php if($alumno==2){ ?> onchange="<?php echo $onchange; ?>" <?php } ?>>
    <option value="0">Todos</option>
    <?php foreach($list_modulo as $list){ ?> 
        <option value="<?php echo $list['Modulo']; ?>"><?php echo $list['Modulo']; ?></option>    
    <?php } ?> 
</select> 