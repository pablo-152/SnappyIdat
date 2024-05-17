<form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Colaborador de Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Nombres: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingresar Nombres" value="<?php echo $get_id[0]['nombres']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Apellido Paterno: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="apater" name="apater" placeholder="Ingresar Apellido Paterno" value="<?php echo $get_id[0]['apater']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Apellido Materno: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="amater" name="amater" placeholder="Ingresar Apellido Materno" value="<?php echo $get_id[0]['amater']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Correo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar Correo" value="<?php echo $get_id[0]['email']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Teléfono: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresar Teléfono" value="<?php echo $get_id[0]['telefono']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Fecha Nac.: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento" value="<?php echo $get_id[0]['fec_nacimiento']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado" id="estado">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if (!(strcmp($list['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_status'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 


    <div class="modal-footer">
        <input type="hidden" id="id_mantenimiento" name="id_mantenimiento" value="<?php echo $get_id[0]['id_mantenimiento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Mantenimiento();" data-loading-text="Loading..." autocomplete="off">
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

    function Update_Mantenimiento(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>General/Update_Mantenimiento";
        if (Valida_Mantenimiento()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>General/Mantenimiento";
                    });
                
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
        if($('#estado').val() === '0') {
            msgDate = 'Debe seleccionar estado.';
            inputFocus = '#estado';
            return false;
        }
        return true;
    }
</script>

