
<select class="form-control" name="id_tema" id="id_tema" >
    <option  value="0">Seleccionar</option>
    <?php foreach($list_tema as $list){ ?>
        <option value="<?php echo $list['id_tema']; ?>"><?php echo $list['referencia'];?></option>
    <?php } ?>
</select>