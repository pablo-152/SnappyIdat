<div class="form-group col-md-2">
    <label class="control-label text-bold">Alumno:</label>
</div>
<div class="form-group col-md-10">
    <select class="form-control basic_alumno" name="alumno" id="alumno" onchange="Traer_Pendientes();">
        <option value="0">Seleccione</option>
        <?php foreach($list_alumno as $list){  ?>
            <option value="<?php echo $list['Codigoa']; ?>"><?php echo $list['nombres']; ?></option> 
        <?php } ?>
    </select> 
</div>

<script>
    var ss = $(".basic_alumno").select2({
        tags: true,
    });

    $('.basic_alumno').select2({
        dropdownParent: $('#modal_registro_manual')
    });
</script>