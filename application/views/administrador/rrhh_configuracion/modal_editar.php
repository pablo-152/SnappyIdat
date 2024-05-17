<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Configuración</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nombree" name="nombree" placeholder="Ingresar Nombre" value="<?php echo $get_id[0]['nombre']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo de Descuento: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_descuentoe" name="tipo_descuentoe">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['tipo_descuento']==1){ echo "selected"; } ?>>%</option>
                    <option value="2" <?php if($get_id[0]['tipo_descuento']==2){ echo "selected"; } ?>>Fijo</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Monto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" name="montoe" id="montoe" placeholder="Ingresar Monto" value="<?php echo $get_id[0]['monto']; ?>">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id" value="<?php echo $get_id[0]['id']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Rrhh_Configuracion();">
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

    function Update_Rrhh_Configuracion(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Administrador/Update_Rrhh_Configuracion";

        if (Valida_Update_Rrhh_Configuracion()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Rrhh_Configuracion();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Update_Rrhh_Configuracion() {
        if($('#nombree').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_descuentoe').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo de Descuento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#montoe').val().trim() === '') {
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