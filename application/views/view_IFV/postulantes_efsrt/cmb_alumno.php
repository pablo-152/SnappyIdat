<select name="alumno[]" id="alumno" class="form-control select2" multiple="multiple">
    <?php foreach($list_alumno as $list){?>
        <option value="<?php echo $list['Id'] ?>" <?php if($todos==1){echo "selected";}?>><?php echo $list['Apellido_Paterno']." ".$list['Apellido_Materno']." ".$list['Nombre'] ?></option>
    <?php }?>
</select>
<script>
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });
</script>