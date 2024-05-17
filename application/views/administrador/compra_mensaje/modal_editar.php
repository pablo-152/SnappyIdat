<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Compra Mensaje</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha: </label> 
            </div> 
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_u" name="fecha_u" value="<?php echo $get_id[0]['fecha']; ?>" onkeypress="if(event.keyCode == 13){ Update_Compra_Mensaje(); }">
            </div> 
            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Monto: </label> 
            </div> 
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="monto_u" name="monto_u" placeholder="Monto" value="<?php echo $get_id[0]['monto']; ?>" onkeypress="if(event.keyCode == 13){ Update_Compra_Mensaje(); }">
            </div> 

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad: </label> 
            </div> 
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="cantidad_u" name="cantidad_u" placeholder="Cantidad" value="<?php echo $get_id[0]['cantidad']; ?>" onkeypress="if(event.keyCode == 13){ Update_Compra_Mensaje(); }">
            </div> 

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div> 
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $get_id[0]['id_compra']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Compra_Mensaje();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Compra_Mensaje(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Administrador/Update_Compra_Mensaje";

        if (Valida_Update_Compra_Mensaje()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Compra_Mensaje();
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }

    function Valida_Update_Compra_Mensaje() { 
        /*if($('#fecha_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto_u').val() < '0') {
            Swal(
                'Ups!',
                'Debe ingresar Monto mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if($('#cantidad_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad_u').val() < '0') {
            Swal(
                'Ups!',
                'Debe ingresar Cantidad mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '') {
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