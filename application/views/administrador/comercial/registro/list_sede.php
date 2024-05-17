<label class="control-label text-bold">Sede:</label>
<select class="form-control" name="id_sede" id="id_sede" onchange="Producto_Interese();">
    <option  value="0">Seleccione</option>
    <?php foreach($get_sede as $list){ ?>
        <option <?php if(count($get_sede)==1){echo "selected"; }?> value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
    <?php } ?>
</select>

<script>
    var cant=<?php echo count($get_sede); ?>;
    
        Producto_Interese();
    
</script>