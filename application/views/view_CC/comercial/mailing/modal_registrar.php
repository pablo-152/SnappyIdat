<form class="needs-validation" id="formulario" method="POST" enctype="multipart/form-data" action="<?= site_url('Administrador/Insert_Producto_Interes')?>">
    <div class="modal-header">
        <h3 class="tile-title">Producto de Interese (Nuevo)</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Fecha Envío: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group col-md-12">
                <label>Observaciones: </label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="5"></textarea>  
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" id="btninsertproductointeres" class="btn btn-success">Guardar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    $("#btninsertproductointeres").on('click', function(e){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>Administrador/Valida_Producto_Interes";
        if (Valida_Producto_Interes()) {
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
                        bootbox.confirm({
                            title: "Registrar Producto de Interese",
                            message: "¿Desea guardar el Producto de Interese?",
                            buttons: {
                                cancel: {
                                    label: 'Cancelar'
                                },
                                confirm: {
                                    label: 'Confirmar'
                                }
                            },
                            callback: function (result) {
                                if (result) {
                                    $('#formulario').submit();
                                }
                            } 
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

    });

    function Valida_Producto_Interes() {
        if($('#id_empresa').val()=="") { 
            msgDate = 'Dato Obligatorio.';
            inputFocus = '#id_empresa';
            return false;
        }
        if($('#nom_producto_interes').val()=="") { 
            msgDate = 'Dato Obligatorio.';
            inputFocus = '#nom_producto_interes';
            return false;
        }
        if($('#fecha_inicio').val()=="") { 
            msgDate = 'Dato Obligatorio.';
            inputFocus = '#fecha_inicio';
            return false;
        }
        if($('#id_status').val()=="") { 
            msgDate = 'Dato Obligatorio.';
            inputFocus = '#id_status';
            return false;
        }
        return true;
    }
</script>