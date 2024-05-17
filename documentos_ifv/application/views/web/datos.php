<div class="titu4"><label class="position">Código:</label>
    <input id="dni_re" name="dni_re" type="text" maxlength="8" class="input" value="<?php echo $get_id[0]['Codigo']; ?>">
</div>
<div class="titu5"><label class="position">Alumno(a):</label>
    <input id="celu_re" name="celu_re" type="text" maxlength="9" class="" value="<?php echo $get_id[0]['nom_alumno']; ?>">
</div>
<div class="respon-5"><label class="position">Especialidad:</label>
    <input id="corre_re" name="corre_re" type="text" maxlength="50" class="" value="<?php echo $get_id[0]['Especialidad']; ?>">
</div>
<script>
    $('#Codigo').val('<?php echo $get_id[0]['Codigo']; ?>');
    $('#nom_alumno').val('<?php echo $get_id[0]['Nombre']; ?>');
    $('#Apellido_Paterno').val('<?php echo $get_id[0]['Apellido_Paterno']; ?>');
    $('#Apellido_Materno').val('<?php echo $get_id[0]['Apellido_Materno']; ?>');
    $('#Especialidad').val('<?php echo $get_id[0]['Especialidad']; ?>');
    $('#Dni').val('<?php echo $get_id[0]['Dni']; ?>');
    $('#Email').val('<?php echo $get_id[0]['Email']; ?>');
</script>