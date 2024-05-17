<?php if(count($list_temporal)>0){?>
    <div class="form-group col-lg-12">
        <label class="control-label text-bold label_tabla">Archivos:</label>
    </div> 
    <?php foreach($list_temporal as $list){?>
        <div id="i_<?=  $list['id']; ?>" class="form-group col-lg-3">
            <?= $list['nombre']; ?> 
            <a onclick="Descargar_Archivo_Cargo('<?= $list['id']; ?>');">
                <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
            </a>
            <a onclick="Delete_Archivo_Cargo('<?= $list['id']; ?>')">
                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
            </a>
        </div>
<?php } } ?>