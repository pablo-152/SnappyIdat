<select class="form-control" id="<?php echo $id_grupo; ?>" name="<?php echo $id_grupo; ?>" onchange="<?php echo $onchange; ?>">
    <option value="0">Todos</option>
    <?php foreach($list_grupo as $list){ ?>
        <option value="<?php echo $list['Grupo']; ?>"><?php echo $list['Grupo']; ?></option>   
    <?php } ?>  
</select> 