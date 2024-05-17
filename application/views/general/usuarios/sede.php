<?php if($funciona_array==0){ ?>
    <label id="etiqueta_sede" class="control-label text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>
    <div class="col">
        <?php foreach($list_sede as $list){ ?>
            <label>
                <input type="checkbox" id="<?php echo $id_sede; ?>[]" name="<?php echo $id_sede; ?>[]" value="<?php echo $list['id_sede']; ?>" class="check_sede">
                <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
            </label> 
        <?php } ?>
    </div>
    <input type="hidden" id="cant_sedes" name="cant_sedes" value="<?php echo count($list_sede) ?>">
<?php }else{ ?>
    <input type="hidden" id="cant_sedes" name="cant_sedes" value="0">
<?php } ?>