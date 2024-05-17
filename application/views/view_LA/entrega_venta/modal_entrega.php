<form id="formulario_entrega" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Venta (Entregada)</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold subir">Tipo Envío: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_envio" name="tipo_envio" onchange="Tipo_Envio();">
                    <option value="1">Correo</option>
                    <option value="2" selected>SMS</option>
                </select>
            </div>

            <div id="div_correo_sms" class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="correo_sms" name="correo_sms" placeholder="Tipo Envío" maxlength="9">
            </div>

            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary btn-sm" onclick="Enviar_Codigo_Verificacion();">Enviar</button>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="codigo_verificacion" name="codigo_verificacion" placeholder="Código" maxlength="4">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $get_id[0]['id_venta']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Venta_Entregada();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Tipo_Envio(){
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

        var tipo_envio = $("#tipo_envio").val();
        var url="<?php echo site_url(); ?>Laleli/Traer_Tipo_Envio";

        $.ajax({
            type:"POST",
            url: url,
            data: {'tipo_envio':tipo_envio},
            success:function (data) {
                $("#div_correo_sms").html(data);
            }
        });  
    }

    function Enviar_Codigo_Verificacion(){
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

        var dataString = new FormData(document.getElementById('formulario_entrega'));
        var url="<?php echo site_url(); ?>Laleli/Enviar_Codigo_Verificacion";

        if (Valida_Enviar_Codigo_Verificacion()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    $('#codigo_verificacion').focus();
                }
            });
        }    
    }

    function Valida_Enviar_Codigo_Verificacion() {
        if($('#correo_sms').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tipo Envío.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Update_Venta_Entregada(){
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

        var dataString = new FormData(document.getElementById('formulario_entrega'));
        var url="<?php echo site_url(); ?>Laleli/Update_Venta_Entregada";

        if (Valida_Update_Venta_Entregada()) {
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
                            text: "¡No coincide el código enviado!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Entrega_Venta(2);
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Update_Venta_Entregada() {
        var codigo = $('#codigo_verificacion').val();

        if($('#codigo_verificacion').val()=='') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(codigo.length!=4) {
            Swal(
                'Ups!',
                'Código debe tener 4 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>