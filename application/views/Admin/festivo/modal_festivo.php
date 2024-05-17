<form  id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Festivo & Fecha Importante (Nuevo)</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Año: </label>
                <div class="col">
                    <input type="number" class="form-control" value="<?php echo date('Y'); ?>" id="anio_i" name="anio_i" placeholder="Ingresar Año">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Fecha: </label>
                <div class="col">
                    <input class="form-control" type="date" id="inicio_i" name="inicio_i">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Descripción: </label> 
                <div class="col">
                    <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Ingresar Descripción">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" name="id_tipo_fecha_i" id="id_tipo_fecha_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo_festivo as $tipo_festivo){ ?>
                            <option value="<?php echo $tipo_festivo['id_tipo_fecha']; ?>"><?php echo $tipo_festivo['nom_tipo_fecha'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">F/V: </label>
                <div class="col">
                    <select class="form-control" name="fijo_variable_i" id="fijo_variable_i">
                        <option value="0">Seleccione</option>
                        <option value="1">Fijo</option>
                        <option value="2">Variable</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control multivalue" name="id_empresa_i[]" id="id_empresa_i" multiple="multiple">
                        <?php foreach($list_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Hay&nbsp;Clases: </label>
                <div>
                    <select name="clases_i" id="clases_i" class="form-control">
                        <option value="0">Seleccione</option>
                        <option value="SI">SI</option>
                        <option value="NO" selected>NO</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Laborable: </label>
                <div>
                    <select name="laborable_i" id="laborable_i" class="form-control">
                        <option value="0">Seleccione</option>
                        <option value="SI">SI</option>
                        <option value="NO" selected>NO</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="text-bold">Observaciones: </label>
                <div class="col">
                    <textarea name="observaciones_i" rows="5" class="form-control" id="observaciones_i" placeholder="Observaciones"></textarea>
                </div>
            </div>
        </div>  	           	                	        
    </div> 
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Festivo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    $('.multivalue').select2({
        minimumResultsForSearch: Infinity
    });

    function Insert_Festivo(){
        Cargando();

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>Snappy/Insert_Festivo";

        if (Valida_Insert_Festivo()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    Lista_Festivo(1);
                    $("#modal_form_vertical .close").click()
                }
            });
        }
    }

    function Valida_Insert_Festivo() {
        if($('#anio_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_fecha_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo de Festivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_empresa_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#clases_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar la opción de Hay Clases.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#laborable_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Laborable.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
