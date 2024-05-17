<select class="form-control" name="id_sede_i" id="id_sede_i" >
    <option value="0">Seleccione</option>
    <?php foreach($list_sede as $list){ ?>
        <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
    <?php } ?>
</select>