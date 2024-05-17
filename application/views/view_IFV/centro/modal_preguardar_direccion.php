<form id="formulario_direccionr" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" ><b>Nueva Dirección </b></h4>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Departamento:</label>
                <select id="departamento" name="departamento" class="form-control" onchange="Provincia();">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_departamento as $list){ ?>
                        <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="mprovincia" class="form-group col-md-2">
                <label class="control-label text-bold">Provincia:</label>
                <select id="provincia" name="provincia" class="form-control" onchange="Distrito();">
                    <option value="0" >Seleccione</option>
                </select>
            </div>

            <div id="mdistrito" class="form-group col-md-2">
                <label class="control-label text-bold">Distrito:</label>
                <select id="distrito" name="distrito" class="form-control">
                    <option value="0" >Seleccione</option>
                </select>
            </div>
        
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Persona Cont:</label>
                <input type="text" class="form-control"  id="contacto_dir" name="contacto_dir">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
                <input type="text" class="form-control" maxlength="9" id="celular_dir" name="celular_dir">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tel Fijo:</label>
                <input type="text" class="form-control" maxlength="9" id="tel_fijo" name="tel_fijo">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo:</label>
                <input type="text" class="form-control" id="correo_dir" name="correo_dir">
            </div>

            <div class="form-group col-md-1">
                <br>
                <div class="row">
                    &nbsp;&nbsp;
                    <input type="checkbox" id="cp" name="cp" value="1" class="mt-1" onclick="Cambio_Convenio()"> 
                    &nbsp;&nbsp;
                    <label class="control-label text-bold">CP</label>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" onclick="Agregar_Direccion()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('#celular_dir').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#tel_fijo').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    /*$('#contacto_dir').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });*/
</script>