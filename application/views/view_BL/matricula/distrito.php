<?php 
    if($tipo==1){
        $nombre = "alum";
    }elseif($tipo==2){
        $nombre = "inst_alum";
    }elseif($tipo==3){
        $nombre = "prin";
    }elseif($tipo==4){
        $nombre = "secu";
    }
?>
<select class="form-control" id="id_distrito_<?php echo $nombre; ?>" name="id_distrito_<?php echo $nombre; ?>">
    <option value="0">Seleccione</option>
    <?php foreach($list_distrito as $list){ ?>
        <option value="<?php echo $list['id_distrito']; ?>"><?php echo $list['nombre_distrito']; ?></option>
    <?php } ?>
</select>