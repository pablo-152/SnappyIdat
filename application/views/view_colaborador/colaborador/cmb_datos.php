<div class="form-group col-lg-2 text-right">
    <label class="control-label text-bold">Código: </label>
</div>
<div class="form-group col-lg-4">
    <input type="text" class="form-control" id="referencia_u" name="referencia_u" readonly value="<?php echo $get_doc[0]['cod_documento'] ?>">
</div>
<div class="form-group col-lg-2 text-right">
    <label class="control-label text-bold">Obligatorio: </label>
</div>
<div class="form-group col-lg-4">
    <input type="text" class="form-control" id="referencia_u" name="referencia_u" readonly value="<?php echo $get_doc[0]['obligatorio'] ?>">
</div>
<input type="hidden" id="id_documento" name="id_documento" value="<?php echo $get_doc[0]['id_documento'] ?>">
<input type="hidden" id="id_empresa" name="id_empresa" value="<?php echo $get_doc[0]['id_empresa'] ?>">