<select required class="form-control" name="id_sede2" id="id_sede2" >
<option value="0">Seleccione</option>
<?php foreach($list_sede as $list){ ?>
    <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
<?php } ?>
</select>