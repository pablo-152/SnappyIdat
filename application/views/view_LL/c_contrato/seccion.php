<select class="form-control" id="<?php echo $id_seccion; ?>" name="<?php echo $id_seccion; ?>">
    <option value="0">Todos</option>
    <?php foreach($list_seccion as $list){ ?>
        <option value="<?php echo $list['Seccion']; ?>"><?php echo $list['Seccion']; ?></option>  
    <?php } ?>
</select>