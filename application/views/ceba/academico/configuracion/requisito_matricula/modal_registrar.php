<div class="modal-content">
    <form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Requisito (Nueva)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Código: </label>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingresar Código" autofocus>
                </div>
                <div class="form-group col-md-2">
                    <label class="col-sm-3 control-label text-bold">Nombre: </label>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar Nombre" autofocus>
                </div>
                
            </div>  	           	                	        
        </div> 
        <div class="modal-footer">
            <input type="hidden" class="form-control" id="modal" name="modal" value="1"  autofocus>
            <button type="button" class="btn btn-primary" onclick="Insert_Requisito_Matricula();" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>    
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>