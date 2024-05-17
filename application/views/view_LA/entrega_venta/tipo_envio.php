<?php if($tipo_envio==1){ ?>
    <input type="text" class="form-control" id="correo_sms" name="correo_sms" placeholder="Tipo Envío">
<?php }else{ ?>
    <input type="text" class="form-control solo_numeros_te" id="correo_sms" name="correo_sms" placeholder="Tipo Envío" maxlength="9">
<?php } ?>

<script>
    $('.solo_numeros_te').bind('keyup paste', function(){ 
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
