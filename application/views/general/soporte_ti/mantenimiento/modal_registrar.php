<form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Colaborador de Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Nombres: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingresar Nombres" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Apellido Paterno: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="apater" name="apater" placeholder="Ingresar Apellido Paterno" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Apellido Materno: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="amater" name="amater" placeholder="Ingresar Apellido Materno" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Correo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar Correo" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Teléfono: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresar Teléfono" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Fecha Nac.: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento" autofocus>
            </div>
        </div>  	           	                	        
    </div> 


    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Mantenimiento();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>

        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    function Insert_Mantenimiento(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>General/Insert_Mantenimiento";
        if (Valida_Mantenimiento()) {
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
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>General/Mantenimiento";
                        });
                    }
                }
            });
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Mantenimiento() {
        if($('#nombres').val() === '') {
            msgDate = 'Debe ingresar nombres.';
            inputFocus = '#nombres';
            return false;
        }
        if($('#apater').val().trim() === '') {
            msgDate = 'Debe ingresar apellido paterno.';
            inputFocus = '#apater';
            return false;
        }
        if($('#amater').val() === '') {
            msgDate = 'Debe ingresar apellido materno.';
            inputFocus = '#amater';
            return false;
        }
        if($('#email').val().trim() === '') {
            msgDate = 'Debe ingresar correo.';
            inputFocus = '#email';
            return false;
        }
        if($('#telefono').val() === '') {
            msgDate = 'Debe ingresar teléfono.';
            inputFocus = '#telefono';
            return false;
        }
        /*if($('#fec_nacimiento').val().trim() === '') {
            msgDate = 'Debe seleccionar un fecha de nacimiento.';
            inputFocus = '#fec_nacimiento';
            return false;
        }*/
        return true;
    }
</script>
