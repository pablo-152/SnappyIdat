<?php if(count($list_temporal)>0){?>
    <div class="form-group col-md-1  text-right" id="div_verificar">
        <label class="control-label text-bold label_tabla">Archivos:</label>
    </div> 
    <?php foreach($list_temporal as $list){?>
        <div id="i_<?php echo  $list['id_temporal_c']?>" class="form-group col-sm-2">
            <div id="lista_escogida">
            <?php echo $list['nombre'] ?> 
            
            <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $list['id_temporal_c']?>">
                <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
            </a>
            <a style="cursor:pointer;" class="delete" type="button" id="delete_file_temporal" data-image_id="<?php echo  $list['id_temporal_c']?>">
                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
            </a>
        </div>
    </div>
<?php } } ?>