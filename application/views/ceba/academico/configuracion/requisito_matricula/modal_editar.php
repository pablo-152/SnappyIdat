
<div class="modal-content">
    <form class="form-horizontal" id="formulario_actu" method="POST" enctype="multipart/form-data"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualización de Requisito</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Código: </label>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $get_id[0]['codigo']; ?>" placeholder="Ingresar Código" autofocus>
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Nombre: </label>
                </div>

                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $get_id[0]['nombre']; ?>" placeholder="Ingresar Código" autofocus>
                </div>
                
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Estado: </label>
                </div>

                <div class="form-group col-sm-4">
                    <select class="form-control" name="id_status" id="id_status">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>  	           	                	        
        </div> 


        <div class="modal-footer">
            <input type="hidden" class="form-control" id="modal" name="modal" value="2"  autofocus>
            <input name="id_requisito_m" type="hidden" class="form-control" id="id_requisito_m" value="<?php echo $get_id[0]['id_requisito_m']; ?>">
            <button type="button" class="btn btn-primary" onclick="Actualizar_Requisito_Matricula();" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>