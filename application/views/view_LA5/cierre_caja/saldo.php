<div class="form-group col-md-2"> 
    <label class="form-group col text-bold">Saldo Automático:</label>                  
</div>
<div class="form-group col-md-4">
    <input type="text" class="form-control solo_numeros_punto" id="saldo_automatico_i" name="saldo_automatico_i" placeholder="Saldo Automático" value="<?php echo $get_saldo[0]['saldo_automatico']; ?>" readonly>
</div>  

<div class="form-group col-md-2">
    <label class="form-group col text-bold">Monto Entregado:</label>                 
</div>
<div class="form-group col-md-4">
    <input type="text" class="form-control solo_numeros_punto" id="monto_entregado_i" name="monto_entregado_i" placeholder="Monto Entregado" value="<?php echo $get_saldo[0]['saldo_automatico']; ?>" onkeypress="if(event.keyCode == 13){ Insert_Cierre_Caja(); }">
</div>  