<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$usuario_codigo = $sesion['usuario_codigo'];
?>
<div class="form-group col-md-12 div_especilidad">
    <?php foreach($list_especialidad as $list){ 
        $p_esp = array_search($list['id_especialidad'],array_column($v_cen_esp,'id_especialidad')); 
        $p_esp_tot = array_search($list['id_especialidad'],array_column($v_cen_esp_tot,'id_especialidad')); 
        
        if(is_numeric($p_esp)){
            $contador_esp = 1;
        }else{
            $contador_esp = 0;
        }

        if(is_numeric($p_esp_tot)){
            $cantidad_esp = $v_cen_esp_tot[$p_esp_tot]['total'];
        }else{
            $cantidad_esp = "";
        }?>
        <div id="parte_especialidad" >
            <p id="p_especialidad" class="control-label text-bold"><?php echo $list['nom_tipo_especialidad']." ".$list['abreviatura'] ?></p>
            <p><input type="text" class="input_little" id="total_<?php echo $list['id_especialidad']; ?>" name="total_<?php echo $list['id_especialidad']; ?>" 
            <?php if($contador_esp==0){ echo "readonly"; }?> value="<?php echo $cantidad_esp; ?>"></p>
            <?php 
                foreach($list_producto as $prod){
                    if($prod['id_tipo_especialidad']==$list['id_tipo_especialidad'] && $prod['id_especialidad']==$list['id_especialidad']){
                        $posicion = array_search($prod['id_producto'],array_column($v_cen_esp,'id_producto'));

                        if(is_numeric($posicion)){
                            $cantidad = $v_cen_esp[$posicion]['cantidad'];
                        }else{
                            $cantidad = "";
                        }?>
                        <label>
                            <input type="text" class="input_little" id="input_<?php echo $prod['id_producto']; ?>" name="input_<?php echo $prod['id_producto']; ?>"
                            <?php if($prod['id_especialidad_temporal']==""){ echo "readonly"; }?> value="<?php echo $cantidad; ?>">
                            <input type="checkbox" id="id_producto_<?php echo $prod['id_producto']; ?>" name="id_producto_<?php echo $prod['id_producto']; ?>" 
                            <?php if($prod['id_especialidad_temporal']!=""){ echo "checked"; }?>  value="<?php echo $prod['id_producto']."-".$list['id_especialidad']; ?>" class="check_especialidad_<?php echo $list['id_especialidad']; ?>" 
                            onclick="Activar_Cantidad('<?php echo $prod['id_producto']; ?>','<?php echo $list['id_especialidad']; ?>');">
                            <span style="font-weight:normal"><?php echo $prod['nom_producto']; ?></span>&nbsp;&nbsp;
                        </label><br>
                    <?php }  ?>
                <?php }
            ?>
        </div>
    <?php } ?>
</div>

<div class="form-group col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha Firma:</label>
        <input type="date" class="form-control" id="fecha_firma" name="fecha_firma" value="<?php echo $get_general[0]['fecha_firma'] ?>">
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Validad de:</label>
        <input type="date" class="form-control" id="val_de" name="val_de" value="<?php echo $get_general[0]['val_de'] ?>">
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">A:</label>
        <input type="date" class="form-control" id="val_a" name="val_a" onchange="Cambio_Convenio()" value="<?php echo $get_general[0]['val_a'] ?>">
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Documento:</label>
        <input name="documento" id="documento" type="file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg|pdf|gif"]'>
    </div>
    <?php if($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==12){?> 
        <div class="form-group col-md-3">
            <input type="checkbox" id="asf" name="asf" value="1" <?php if($get_general[0]['firmasf']==1){ echo "checked"; }?> onclick="Cambio_Convenio()">
            <span style="font-weight:normal"><b>Activo sin firma&nbsp;&nbsp;&nbsp;&nbsp;</b><?php 
            $mifecha = new DateTime();
            echo $usuario_codigo."&nbsp;".$mifecha->format('d/m/Y') ?></span>
        </div>
    <?php } ?>

    <div class="form-group col-md-12">
        <label class="control-label text-bold">Observaciones:</label>
        <textarea class="form-control" id="observaciones_admin" name="observaciones_admin" rows="5"><?php echo $get_general[0]['observaciones_admin']; ?></textarea></br>
        <button class="btn " onclick="Cancelar_Especialidad()" style="background-color:red;color:white;float: right;" type="button" title="Cancelar" >Cancelar</button>
        <button class="btn " onclick="Guardar_Especialidad()" style="background-color:green;color:white;float: right;margin-right:3px" type="button" title="Guardar" >Guardar</button>
    </div>
</div>

