<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Donde nos conocio:</label>
        <div class="col">
            <select class="form-control" id="donde_conocio" name="donde_conocio">
                <option value="0">Seleccione</option>
                <?php foreach($list_medio as $list){ ?>
                    <option value="<?php echo $list['id_medios']; ?>" <?php if($list['id_medios']==$get_id[0]['donde_conocio']){ echo "selected"; } ?>>
                        <?php echo $list['nom_medio']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <input type="hidden" id="id_temporal_datos_alumno" name="id_temporal_datos_alumno" value="<?php echo $get_id[0]['id_temporal']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Informacion();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>