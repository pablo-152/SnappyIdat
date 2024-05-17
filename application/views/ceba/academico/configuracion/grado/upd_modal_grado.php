
<div class="modal-content">
    <form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Update_Grado')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualización de Grado <b><?php echo $get_id[0]['nom_grado']; ?></b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Descripción: </label>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="descripcion_grado" name="descripcion_grado" value="<?php echo $get_id[0]['descripcion_grado']; ?>" placeholder="Ingresar Descripción" autofocus>
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Status: </label>
                </div>
                
                <div class="form-group col-sm-4">
                    <select class="form-control" name="id_status" id="id_status">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>" 
                        <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>
                        <?php echo $estado['nom_status'];?></option>
                    <?php } ?>
                    </select>
                </div>

            </div>  	           	                	        
        </div> 
        <div class="modal-footer">
            <input name="id_grado" type="hidden" class="form-control" id="id_grado" value="<?php echo $get_id[0]['id_grado']; ?>">
            <button type="button" class="btn btn-primary" onclick="Actualizar_Grado();" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
            
        </div>
    </form>
</div>