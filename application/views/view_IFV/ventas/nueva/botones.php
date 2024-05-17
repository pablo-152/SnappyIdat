<div class="col-md-6">
    <a class="btn btn-primary btn-block btn_pagar letra_grande"> 
        <?php echo "s/ ".number_format($subtotal,2); ?>  
    </a> 
</div>
<div class="col-md-6">
    <button type="button" class="btn btn-primary btn-block letra_grande" <?php if($subtotal>=0){ ?> data-toggle="modal" data-target="#acceso_modal_pequeno" 
    app_crear_peq="<?= site_url('AppIFV/Modal_Venta') ?>" <?php } ?>>PAGAR</button>
</div>