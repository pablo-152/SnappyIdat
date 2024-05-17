<div class="col-md-12 row">
    <?php foreach($list_documento as $list){ ?>
        <div class="form-group col-md-3">
            <?php $busqueda = in_array($list['id_documento'], array_column($get_id, 'id_documento'));
            if($busqueda != false){ 
                $posicion = array_search($list['id_documento'], array_column($get_id, 'id_documento')); ?>
                <div id="i_1">
                    <label class="control-label text-bold"><?php echo $list['nom_documento']; ?>:</label>
                    <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Documento('<?php echo $list['id_documento']; ?>')">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <input type="hidden" id="id_temporal_datos_documento_<?php echo $list['id_documento']; ?>" name="id_temporal_datos_documento_<?php echo $list['id_documento']; ?>" value="<?php echo $get_id[$posicion]['id_temporal']; ?>">
                </div>
            <?php }else{ ?>
                <label class="control-label text-bold"><?php echo $list['nom_documento']; ?>:</label>
            <?php } ?>
            <div class="col">
                <input type="file" id="documento_<?php echo $list['id_documento']; ?>" name="documento_<?php echo $list['id_documento']; ?>" onchange="Validar_Extension_Documento('<?php echo $list['id_documento']; ?>');">
            </div>
        </div>
    <?php } ?>
</div>

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Documento();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>