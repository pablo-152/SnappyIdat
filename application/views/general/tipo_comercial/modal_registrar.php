<form id="formulario_insert" class="formulario" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Tipo (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class=" text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_informe_i" name="nom_informe_i" placeholder="Nombre" maxlength="16" onkeypress="if(event.keyCode == 13){ Insert_Tipo_Comercial(); }">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Tipo_Comercial();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Tipo_Comercial(){
        Cargando();

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>General/Insert_Tipo_Comercial";

        if (Valida_Insert_Tipo_Comercial()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
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
                        Lista_Tipo_Comercial();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Tipo_Comercial() {
        if($('#nom_informe_i').val().trim() === "") { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>