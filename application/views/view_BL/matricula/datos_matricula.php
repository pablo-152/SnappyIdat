<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Grado:</label>
        <div class="col">
            <select class="form-control" id="id_grado" name="id_grado" onchange="Traer_Producto();">
                <option value="0">Seleccione</option>
                <?php foreach($list_grado as $list){ ?>
                    <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                        <?php echo $list['nom_grado']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Producto:</label>
        <div class="col">
            <select class="form-control" id="id_producto" name="id_producto">
                <option value="0">Seleccione</option>
                <?php foreach($list_producto as $list){ ?>
                    <option value="<?php echo $list['id_producto']; ?>" <?php if($list['id_producto']==$get_id[0]['id_producto']){ echo "selected"; } ?>>
                        <?php echo $list['nom_producto']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha:</label>
        <div class="col">
            <input type="date" class="form-control" id="fec_matricula" name="fec_matricula" value="<?php echo $get_id[0]['fec_matricula']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-8">
        <label class="control-label text-bold">Observaciones:</label>
        <div class="col">
            <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Observaciones"><?php echo $get_id[0]['observaciones']; ?></textarea>
        </div>
    </div>
</div>

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <input type="hidden" id="id_temporal_datos_matricula" name="id_temporal_datos_matricula" value="<?php echo $get_id[0]['id_temporal']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Matricula();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>