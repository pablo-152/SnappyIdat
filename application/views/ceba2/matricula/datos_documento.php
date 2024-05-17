<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <?php if($get_id[0]['doc_iden_alumno']!=""){ ?>
            <div id="i_1">
                <label class="control-label text-bold">DNI Alumno:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Documento(1)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
            </div>
        <?php }else{ ?>
            <label class="control-label text-bold">DNI Alumno:</label>
        <?php } ?>
        <div class="col">
            <input type="file" id="doc_iden_alumno" name="doc_iden_alumno" onchange="Validar_Extension_Dni_Alumno();">
        </div>
    </div>

    <div class="form-group col-md-3">
        <?php if($get_id[0]['certificado_estudio']!=""){ ?>
            <div id="i_2">
                <label class="control-label text-bold">Certificado de Estudios:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Documento(2)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
            </div>
        <?php }else{ ?>
            <label class="control-label text-bold">Certificado de Estudios:</label>
        <?php } ?>
        <div class="col">
            <input type="file" id="certificado_estudio" name="certificado_estudio" onchange="Validar_Extension_Certificado_Estudio();">
        </div>
    </div>

    <div class="form-group col-md-3">
        <?php if($get_id[0]['foto']!=""){ ?>
            <div id="i_3">
                <label class="control-label text-bold">Foto:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Documento(3)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
            </div>
        <?php }else{ ?>
            <label class="control-label text-bold">Foto:</label>
        <?php } ?>
        <div class="col">
            <input type="file" id="foto" name="foto" onchange="Validar_Extension_Foto();">
        </div>
    </div>

    <div class="form-group col-md-3">
        <?php if($get_id[0]['doc_iden_apoderado']!=""){ ?>
            <div id="i_4">
                <label class="control-label text-bold">DNI Apoderado (si es menor de edad):</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Documento(4)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
            </div>
        <?php }else{ ?>
            <label class="control-label text-bold">DNI Apoderado (si es menor de edad):</label>
        <?php } ?>
        <div class="col">
            <input type="file" id="doc_iden_apoderado" name="doc_iden_apoderado" onchange="Validar_Extension_Dni_Apoderado();">
        </div>
    </div>
</div>

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <input type="hidden" id="id_temporal_datos_documento" name="id_temporal_datos_documento" value="<?php echo $get_id[0]['id_temporal']; ?>">
    <input type="hidden" id="doc_iden_alumno_actual" name="doc_iden_alumno_actual" value="<?php echo $get_id[0]['doc_iden_alumno']; ?>">
    <input type="hidden" id="certificado_estudio_actual" name="certificado_estudio_actual" value="<?php echo $get_id[0]['certificado_estudio']; ?>">
    <input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $get_id[0]['foto']; ?>">
    <input type="hidden" id="doc_iden_apoderado_actual" name="doc_iden_apoderado_actual" value="<?php echo $get_id[0]['doc_iden_apoderado']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Documento();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>