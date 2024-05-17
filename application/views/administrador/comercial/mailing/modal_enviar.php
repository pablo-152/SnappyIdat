<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Enviar Mailing</b></h5>
</div>

<div class="modal-body" style="max-height:520px; overflow:auto;">
    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label>Fecha Envío: </label>
        </div>
        <div class="form-group col-md-4">
            <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="form-group col-md-12">
            <label>Observaciones: </label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Observaciones"></textarea>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Enviar_Mailing();">
        <i class="glyphicon glyphicon-ok-sign"></i>Guardar
    </button>
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
    </button>
</div>

<script>
    function Enviar_Mailing() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var tipo_excel = $('#tipo_excel').val();
        var cadena=$('#cadena').val();
        var cantidad=$('#cantidad').val();
        var fecha_envio=$('#fecha_envio').val();
        var observaciones=$('#observaciones').val();

        if (Valida_Enviar_Mailing()) {
            var url = "<?php echo site_url(); ?>Administrador/Insert_Mailing";

            if (cantidad > 0) {
                Swal({
                    title: '¿Realmente desea enviar ' + cantidad + ' mailing(s)?',
                    text: "Los mailing serán actualizados",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({ 
                            type:"POST",
                            url:url,
                            data:{'cadena':cadena,'cantidad':cantidad,'fecha_envio':fecha_envio,'observaciones':observaciones},
                            success: function(data) {
                                Lista_Mailing(tipo_excel);
                                $("#acceso_modal .close").click()
                            }
                        });
                    }
                })
            } else {
                Swal({
                    title: 'Ups!',
                    text: 'Debe seleccionar al menos un registro.', 
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            }
        }
    }

    function Valida_Enviar_Mailing() {
        if ($('#fecha_envio').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Envío.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#observaciones').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Observaciones.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>

