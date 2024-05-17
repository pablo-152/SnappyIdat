<select name="turno" id="turno" class="form-control" onchange="Busca_Seccion_Invitar()">
    <option value="0">Seleccione</option>
    <?php foreach($list_turno as $list){?>
    <option value="<?php echo $list['id_turno'] ?>"><?php 
    if($list['id_turno']!=""){
    $array = explode(",",$list['id_turno']);
    $cantidad = count($array);
    $i = 0;
    $cadena = "";
    while($i < $cantidad){
        $busqueda = in_array($array[$i], array_column($list_turno_bd, 'id_turno'));
        if($busqueda != false){
            $posicion=array_search($array[$i],array_column($list_turno_bd,'id_turno'));
            $cadena = $cadena.$list_turno_bd[$posicion]['nom_turno'].",";
        }
        $i++;
    }
    echo substr($cadena,0,-1);
    }
        
        ?></option>
    <?php }?>
</select>