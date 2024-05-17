<option value="0">Seleccione</option>
<?php foreach($list_tipo_contrato as $list){ ?>
    <option value="<?= $list['id']; ?>"><?= $list['nombre']; ?></option>
<?php } ?>