<label>Sede:</label>
<div class="col">
    <select required class="form-control" name="id_sede" id="id_sede" onchange="Busca_Local()" >
    <option value="0">Seleccione</option>
    <?php foreach($list_sede as $list){ ?>
        <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
    <?php } ?>
    </select>
</div>