<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Confirmar celular Tutor Principal:</label>
        <div class="col">
            <button type="button" class="btn rojo estilo_boton" onclick="Enviar_Sms();">Enviar SMS</button>
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Código:</label>
        <div class="col">
            <input type="text" class="form-control" id="codigo_confirmacion" name="codigo_confirmacion" maxlength="4" placeholder="Código" value="<?php echo $get_id[0]['codigo_confirmacion']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2 text-center">
        <button class="btn verde estilo_boton">Confirmado</button>
    </div>
</div>   

<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Hoja de Matrícula:</label>
        <div class="col">
            <button type="button" class="btn rojo estilo_boton" onclick="Pdf_Hoja_Matricula();">Descargar</button>
        </div>
    </div>

    <div class="form-group col-md-3">
        <?php if($get_id[0]['hoja_matricula']!=""){ ?>
            <label class="control-label text-bold">Descargar:</label>
            <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Matricula(1)">
                <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
            </a>
        <?php } ?>
        <div class="col">
            <input type="file" id="hoja_matricula" name="hoja_matricula" onchange="Validar_Extension_Hoja_Matricula();">
        </div>
    </div>

    <div class="form-group col-md-2 text-center">
        <button class="btn verde estilo_boton">Confirmado</button>
    </div>
</div>   

<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Contrato:</label>
    </div>

    <div class="form-group col-md-3">
        <?php if($get_id[0]['contrato']!=""){ ?>
            <label class="control-label text-bold">Descargar:</label>
            <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Matricula(2)">
                <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
            </a>
        <?php } ?>
        <div class="col">
            <input type="file" id="contrato" name="contrato" onchange="Validar_Extension_Contrato();">
        </div>
    </div>

    <div class="form-group col-md-2 text-center">
        <button class="btn verde estilo_boton">Confirmado</button>
    </div>
</div>  

<div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
    <label class="control-label text-bold">Informado al Apoderado</label>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Reg. Interno:</label>
        <div class="col">
            <select class="form-control" id="reglamento_interno" name="reglamento_interno">
                <option value="0" <?php if($get_id[0]['reglamento_interno']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['reglamento_interno']==1){ echo "selected"; } ?>>Si</option>
                <option value="2" <?php if($get_id[0]['reglamento_interno']==2){ echo "selected"; } ?>>No</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Forma de Pago:</label>
        <div class="col">
            <select class="form-control" id="forma_pago" name="forma_pago">
                <option value="0" <?php if($get_id[0]['forma_pago']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['forma_pago']==1){ echo "selected"; } ?>>Si</option>
                <option value="2" <?php if($get_id[0]['forma_pago']==2){ echo "selected"; } ?>>No</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Cero Efectivo:</label>
        <div class="col">
            <select class="form-control" id="cero_efectivo" name="cero_efectivo">
                <option value="0" <?php if($get_id[0]['cero_efectivo']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['cero_efectivo']==1){ echo "selected"; } ?>>Si</option>
                <option value="2" <?php if($get_id[0]['cero_efectivo']==2){ echo "selected"; } ?>>No</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Contactos:</label>
        <div class="col">
            <select class="form-control" id="contacto" name="contacto">
                <option value="0" <?php if($get_id[0]['contacto']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['contacto']==1){ echo "selected"; } ?>>Si</option>
                <option value="2" <?php if($get_id[0]['contacto']==2){ echo "selected"; } ?>>No</option>
            </select>
        </div>
    </div>
</div>   

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <input type="hidden" id="id_temporal_datos_matricula" name="id_temporal_datos_matricula" value="<?php echo $get_id[0]['id_temporal']; ?>">
    <input type="hidden" id="hoja_matricula_actual" name="hoja_matricula_actual" value="<?php echo $get_id[0]['hoja_matricula']; ?>">
    <input type="hidden" id="contrato_actual" name="contrato_actual" value="<?php echo $get_id[0]['contrato']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Confirmacion();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>