<select class="form-control multivalue" id="<?php echo $alumnos; ?>" name="<?php echo $alumnos; ?>[]" multiple="multiple">
    <?php foreach($list_alumno as $list){ ?>
        <option value="<?php echo $list['id_alumno']; ?>"><?php echo $list['nom_alumno']; ?></option> 
    <?php } ?>
</select>

<script>
    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        <?php if($alumnos=="alumnos_i"){ ?>
            dropdownParent: $('#acceso_modal')
        <?php }else{ ?>
            dropdownParent: $('#acceso_modal_mod')
        <?php } ?>
    });
</script>