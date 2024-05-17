<option value="0">Seleccione</option>
<?php foreach($list_anio as $list){ 
    foreach($list_mes as $mes){ ?>
        <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>" 
        <?php if($fecha==$mes['cod_mes']."/".$list['nom_anio']){ echo "selected"; } ?>>
            <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
        </option> 
    <?php } ?>
<?php } ?>