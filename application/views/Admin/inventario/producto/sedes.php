<label id="etiqueta_sede" class="control-label text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>
<?php foreach($list_sede as $list){ ?>
    <label>
        <input type="checkbox" id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" class="check_sede">
        <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
    </label>
    
<?php } ?>
<input type="hidden" id="cant_sedes" name="cant_sedes" value="<?php echo count($list_sede) ?>" >