<form id="formulario_estado_fecha" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h3 class="tile-title" style="color: #715d74;font-size: 21px;"><b>Editar Mes Estado Bancario</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="form-group col-md-2">
            <label class="text-bold">Mes/Año:</label>
        </div>
        <div class="form-group col-md-3">
            <select id="mes_anioe2" name="mes_anioe2" class="form-control" onchange="MesRegistro()">
                <option value="0">Seleccione</option>
                <?php foreach($list_mes_anio as $list){ ?>
                    <option value="<?php echo $list['mes_anio']; ?>"><?php echo $list['mes_anio']; ?></option>
                <?php } ?>
            </select>
        </div>

    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Update_Mes()" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>
