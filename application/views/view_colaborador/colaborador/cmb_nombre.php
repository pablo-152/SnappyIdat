<select name="nombre" id="nombre" class="form-control" onchange="Listar_Datos();">
    <option value="0">Seleccione</option>
    <?php foreach($list_nombre as $list){?>
        <option value="<?php echo $list['nom_documento']; ?>"><?php echo $list['nom_documento'];?></option>    
    <?php }?>
</select>