<form id="formulario_insert" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="tile-title"><b>SMS Automatizado (Nuevo)</b></h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Empresa: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_empresa_i" name="id_empresa_i" onchange="Traer_Sede_I();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                    <?php } ?>
                </select>                
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Sede: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_sede_i" name="id_sede_i">
                    <option value="0">Seleccione</option>
                </select>                
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_i" name="tipo_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Aniversario</option>
                    <option value="2">EFSRT</option>
                </select>                
            </div>

            <div class="form-group col-md-6">
                <input type="checkbox" id="unitario_i" name="unitario_i" value="1">
                <label class="text-bold">Unitario</label>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Motivo: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="motivo_i" name="motivo_i" placeholder="Motivo" onkeypress="if(event.keyCode == 13){ Insert_Sms_Automatizado(); }">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripción" onkeypress="if(event.keyCode == 13){ Insert_Sms_Automatizado(); }">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Regularidad: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="regularidad_i" name="regularidad_i" placeholder="Regularidad" onkeypress="if(event.keyCode == 13){ Insert_Sms_Automatizado(); }">            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_i" name="estado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==2){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>                
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Sms_Automatizado();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </button>
    </div>
</form>

<script>
    function Traer_Sede_I(){
        Cargando();
        
        var url = "<?php echo site_url(); ?>General/Traer_Sede_Sms_Automatizado";
        var id_empresa = $("#id_empresa_i").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#id_sede_i').html(data);
            }
        });
    }

    function Insert_Sms_Automatizado(){
        Cargando();
        
        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>General/Insert_Sms_Automatizado";

        if (Valida_Insert_Sms_Automatizado()) {
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
                        Lista_Sms_Automatizado();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Sms_Automatizado() {
        if($('#id_empresa_i').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_i').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Sede',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_i').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_i').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Estado',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>