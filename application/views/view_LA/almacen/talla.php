<select class="form-control" id="id_talla_c" name="id_talla_c" onchange="Traer_Talla_Precio_Venta_C();">
    <option value="0">Seleccione</option>
    <?php foreach($list_talla as $list){ ?>
        <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['cod_talla']; ?></option>
    <?php } ?>
</select>