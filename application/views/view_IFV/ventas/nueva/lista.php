<table class="table table-hover table-bordered table-striped" id="example" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Código</th> 
            <th class="text-center">Venta</th> 
            <th class="text-center">Descuento</th>
            <th class="text-center">Cantidad</th>  
            <th class="text-center">Sub-Total</th>
            <th class="text-center"></th>
        </tr>
    </thead>

    <tbody>
        <?php $cantidad=0; $subtotal=0; 
            foreach($list_nueva_venta as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_producto']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['precio']; ?></td> 
                <td class="text-right"><?php echo "s./ ".$list['descuento']; ?></td> 
                <td><?php echo $list['cantidad']; ?></td>    
                <td class="text-right"><?php echo "s./ ".number_format(($list['precio']-$list['descuento']),2); ?></td>                                                 
                <td>
                    <a title="Eliminar">
                        <img onclick="Delete_Producto_Nueva_Venta('<?php echo $list['id_nueva_venta_producto']; ?>')" src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php $cantidad=$cantidad+$list['cantidad']; $subtotal=$subtotal+($list['cantidad']*($list['precio']-$list['descuento'])); } ?>
        <tr class="text-center">
            <td colspan="3"></td>
            <td><?php echo $cantidad; ?></td>    
            <td class="text-right"><?php echo "s./ ".number_format($subtotal,2); ?></td>                                                 
            <td></td>
        </tr>
    </tbody>
</table>