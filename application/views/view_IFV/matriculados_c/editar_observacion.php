<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo:</label>
        <select class="form-control" id="id_tipo_o" name="id_tipo_o">
            <option  value="0">Seleccione</option>
            <?php foreach($list_tipo_obs as $list){ ?>
                <option value="<?php echo $list['id_tipo']; ?>" <?php if($list['id_tipo']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                    <?php echo $list['nom_tipo']; ?>
                </option>
            <?php } ?>
        </select> 
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha:</label>
        <input class="form-control" type="date" id="fecha_o" name="fecha_o" value="<?php echo $get_id[0]['fecha_obs']; ?>"> 
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Usuario:</label>
        <select class="form-control" id="usuario_o" name="usuario_o">
            <option value="0">Seleccione</option>
            <?php foreach($list_usuario as $list){?> 
                <option value="<?php echo $list['id_usuario'] ?>" <?php if($list['id_usuario']==$get_id[0]['usuario_obs']){ echo "selected"; } ?>>
                    <?php echo $list['usuario_codigo']; ?>
                </option>    
            <?php }?>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label class="control-label text-bold">Comentario:</label>
        <div class="">
            <input class="form-control" type="text" id="observacion_o" name="observacion_o" maxlength="150" placeholder="Comentario" value="<?php echo $get_id[0]['observacion']; ?>">
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="hidden" id="id_observacion" name="id_observacion" value="<?php echo $get_id[0]['id_observacion']; ?>">
    <button type="button" class="btn btn-default" onclick="limpiarFormularioObservacion();">
        <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
    </button>
    <button id="boton_obs" type="button" class="btn btn-primary" onclick="Update_Observacion_Alumno();">
        <i class="glyphicon glyphicon-ok-sign"></i>Editar
    </button>
</div>
