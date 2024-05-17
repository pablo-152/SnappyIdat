<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>

<form id="formulario_archi_reg" method="POST" enctype="multipart/form-data"   class="formulario">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel" ><b>Subir Archivo</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="text-bold">Nombre del documento: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_documento" maxlength="20" name="nom_documento" placeholder="Nombre de Documento" onkeypress="if(event.keyCode == 13){ Agregar_Documento(); }">
                </div> 
            </div>
              

            <div class="form-group col-md-4">
                <label class="text-bold">Archivo: </label>
                <div class="col">
                    <div class="col">
                        <input id="documento" name="documento" type="file" size="100" required data-allowed-file-extensions='["JPG|jpg|png|PNG|jpeg|JPEG|xls|xlsx|pdf"]' onkeypress="if(event.keyCode == 13){ Agregar_Documento(); }">
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Agregar_Documento()" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>


