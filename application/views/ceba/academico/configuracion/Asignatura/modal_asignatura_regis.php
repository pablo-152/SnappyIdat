
<div class="modal-content">
    <form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Insert_Asignatura')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asignatura (Nueva)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
            <div class="modal-body" style="max-height:300px; overflow:auto;">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="form-group col text-bold">Área: </label>
                    </div>
                    <div class="form-group col-md-4">
                            <select class="form-control" name="id_area" id="id_area">
                                <option value="0">Seleccione</option>
                                    <?php foreach($list_area as $area){ ?>
                                    <option value="<?php echo $area['id_area']; ?>"><?php echo $area['descripcion_area'];?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    <div class="form-group col-md-2">
                        <label class="form-group col text-bold">Referencia: </label>
                    </div>
                    <div class="form-group col-md-4">
                        <input  type="text" required class="form-control" id="referencia" name="referencia" placeholder="Ingresar Referencia" autofocus>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="form-group col text-bold">Descripción: </label>
                    </div>
                    <div class="form-group col-md-10">
                        <input  type="text" required class="form-control" id="descripcion_asignatura" name="descripcion_asignatura" placeholder="Ingresar Descripción de Asignatura" autofocus>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="form-group col text-bold">Estado</label>
                    </div>
                    <div class="form-group col-md-4">
                        <select required class="form-control" name="id_status" id="id_status">
                        <option  value="2">Seleccione</option>
                            <?php foreach($list_estado as $nivel){ 
                                if($nivel['id_status'] ==2){ ?>
                                <option selected value="<?php echo $nivel['id_status'] ; ?>">
                                <?php echo $nivel['nom_status'];?></option>
                                <?php }else
                                {?>
                                <option value="<?php echo $nivel['id_status']; ?>"><?php echo $nivel['nom_status'];?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>  	           	                	        
            </div> 
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Insert_Asignatura();" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>    
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>
