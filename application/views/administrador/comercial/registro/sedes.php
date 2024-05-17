<label id="etiqueta_sede" class="control-label text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>

<?php
if(count($list_sede)==1){
    foreach($list_sede as $list){ ?>
        <label>
            <input type="checkbox" checked id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" class="check_sede">
            <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
        </label>
    <?php }
}else{
    foreach($list_sede as $list){ ?>
    <label>
        <input type="checkbox" id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" class="check_sede">
        <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
    </label>
<?php }
}
 ?>