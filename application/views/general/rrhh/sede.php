<option value="0">Seleccione</option>
<?php foreach($list_sede as $list){ ?>
    <option value="<?= $list['id_sede']; ?>"><?= $list['cod_sede']; ?></option>
<?php } ?>