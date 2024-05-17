<label id="etiqueta_asignacion" class="control-label text-bold" ><?php echo $nombre; ?>:&nbsp;&nbsp;&nbsp;</label>
<?php 
    if($id_especialidad==1){
        foreach($list_asignacion as $list){ ?>
            <label>
                <input type="checkbox" id="id_asignacion[]" name="id_asignacion[]" value="<?php echo $list['id_asignacion_ciclo']; ?>" class="check_asignacion">
                <span style="font-weight:normal"><?php echo $list['ciclo']; ?></span>&nbsp;&nbsp;
            </label>
        <?php } ?>
    <?php }else{
        foreach($list_asignacion as $list){ ?>
            <label>
                <input type="checkbox" id="id_asignacion[]" name="id_asignacion[]" value="<?php echo $list['id_asignacion_modulo']; ?>" class="check_asignacion">
                <span style="font-weight:normal"><?php echo $list['modulo']; ?></span>&nbsp;&nbsp;
            </label>
    <?php } ?>
<?php } ?>