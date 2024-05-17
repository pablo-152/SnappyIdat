<label id="etiqueta_empresa" class="control-label text-bold">Empresas:&nbsp;&nbsp;&nbsp;</label>
<div class="col">
    <?php foreach ($list_empresa as $list) { ?>
        <label>
            <input type="checkbox" id="id_empresa" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" class="check_empresa" onchange="Empresa(this)">
            <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
        </label>
    <?php } ?>
</div>