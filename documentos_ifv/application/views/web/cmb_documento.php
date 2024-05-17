

<label class="descrp5">Documentos a enviar:</label>
<select class="select-css cmb5" id="cod_documento1" name="cod_documento1" onchange="TipoDoc_Enviar()">
    <option value="0">Seleccione</option>
    <?php if($m==1){
        foreach($list_documento as $list){?> 
        <option value="<?php echo $list['cod_documento']."-".$list['nom_documento'] ?>"><?php echo $list['nom_documento'] ?></option> 
    <?php }}?>
</select>
<div class="dni5" id="divcampos" >
    <label id="textos"class="descrip5-2"></label>
    <label id="textodoc"class="img-dni-2"></label>
</div>
<!--<div class="dni5">
    <label class="descrip5-2">Se ha subido 1 documento</label>
    <label class="img-dni-2"><img src="<?= base_url() ?>template/img/img_check.png">&nbsp;DNI.pdf</label>
</div>-->