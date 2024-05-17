<label class="control-label text-bold">Sub-Tipo:</label>
<select  name="id_subtipo" id="id_subtipo" value="0" Class="form-control" onchange="Cambio_Week()">
    <option value="0">Seleccione</option>
    <?php foreach($list_subtipo as $list){ ?>
<option value="<?php echo $list['id_subtipo']; ?>"><?php echo $list['nom_subtipo'];?></option>
<?php } ?>
</select>
