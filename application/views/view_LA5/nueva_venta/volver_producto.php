<?php foreach($list_tipo_producto as $list){ ?> 
    <div class="form-group col-md-4 text-center">
        <a onclick="Traer_Producto_Nueva_Venta('<?php echo $list['id_tipo_producto']; ?>')">
            <img src="<?= base_url().$list['foto']; ?>" width="250" height="250">
        </a> 
    </div>
<?php } ?> 