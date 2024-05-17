<?php 
    if($tipo==1){
        $onchange = "Distrito_Prin();";
        $nombre = "prin";
    }elseif($tipo==2){
        $onchange = "Distrito_Secu();";
        $nombre = "secu";
    }
?>
<select class="form-control" id="id_provincia_<?php echo $nombre; ?>" name="id_provincia_<?php echo $nombre; ?>" onchange="<?php echo $onchange; ?>">
    <option value="0">Seleccione</option>
    <?php foreach($list_provincia as $list){ ?>
        <option value="<?php echo $list['id_provincia']; ?>" <?php if($list['id_provincia']==$id_provincia){ echo "selected"; } ?>>
            <?php echo $list['nombre_provincia']; ?>
        </option>
    <?php } ?>
</select>