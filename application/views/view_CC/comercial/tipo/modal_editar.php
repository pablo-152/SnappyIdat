<form id="formulario_update" class="formulario" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Edición de Datos de <b><?php echo $get_id[0]['nom_informe']; ?></b></h5>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class=" text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" id="nom_informe" name="nom_informe" class="form-control" placeholder="Nombre" maxlength="16" value="<?php echo $get_id[0]['nom_informe']; ?>" onkeypress="if(event.keyCode == 13){ Update_Tipo_Comercial(); }">
            </div>
            
            <div class="form-group col-md-2">
                <label class=" text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_status" id="id_status">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_status as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if (!(strcmp($list['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_status'];?></option>
                    <?php } ?>
                </select>               
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_informe" name="id_informe" class="form-control" value="<?php echo $get_id[0]['id_informe']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Tipo_Comercial();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
</form>

<script>
    function Update_Tipo_Comercial(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>Administrador/Update_Tipo_Comercial";

        if (Valida_Update_Tipo_Comercial()) {
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
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Administrador/Tipo_Comercial";
                        });
                    }
                }
            });
        }
    }

    function Valida_Update_Tipo_Comercial() {
        if($('#nom_informe').val().trim() === "") { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status').val().trim() == "0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>