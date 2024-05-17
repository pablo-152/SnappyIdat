<div class="modal-content">
    <form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Insert_Area')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Área (Nueva)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Descripción: </label>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="descripcion_area" name="descripcion_area" placeholder="Ingresar Descripción" autofocus>
                </div>
                <div class="form-group col-md-2">
                    <label class="form-group col text-bold">Estado:</label>
                </div>
                <div class="form-group col-md-4">
                    <select required class="form-control" name="id_status" id="id_status">
                    <option  value="2">Seleccione</option>
                        <?php foreach($list_estado as $list){ 
                            if($list['id_status'] ==2){ ?>
                            <option selected value="<?php echo $list['id_status'] ; ?>">
                            <?php echo $list['nom_status'];?></option>
                            <?php }else
                            {?>
                            <option value="<?php echo $list['id_status']; ?>"><?php echo $list['nom_status'];?></option>
                        <?php }} ?>
                    </select>
                </div> 
            </div>  	           	                	        
        </div> 
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Insert_Area();" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>    
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>