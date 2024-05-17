<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Configuración (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar Nombre">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo de Descuento: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_descuento" name="tipo_descuento">
                    <option value="0">Seleccione</option>
                    <option value="1">%</option>
                    <option value="2">Fijo</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Monto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" name="monto" id="monto" placeholder="Ingresar Monto">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Rrhh_Configuracion();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,]/g, '');
    });

    function Insert_Rrhh_Configuracion(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Administrador/Insert_Rrhh_Configuracion";

        if (Valida_Insert_Rrhh_Configuracion()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Rrhh_Configuracion();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Insert_Rrhh_Configuracion() {
        if($('#nombre').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_descuento').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo de Descuento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
