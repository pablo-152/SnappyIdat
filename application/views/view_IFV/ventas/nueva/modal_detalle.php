<form id="formulario_detalle" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Venta (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Tipo Pago: </label>
                <select class="form-control" id="id_tipo_pago" name="id_tipo_pago">
                    <option value="0">Seleccione</option>
                    <option value="1">Cheque</option>
                    <option value="2" selected>Efectivo</option>
                    <option value="3">Transferencia</option>
                </select>
            </div>
            
            <div class="form-group col-md-12">
                <label class="form-group col text-bold">Monto Entregado:</label>                 
                <input type="text" class="form-control solo_numeros_punto" id="monto_entregado" name="monto_entregado" placeholder="Monto Entregado" onkeyup="Cambio();" onkeypress="if(event.keyCode == 13){ Insert_Venta(); }">
            </div>
            
            <div class="form-group col-md-12">
                <label class="form-group col text-bold">Cambio:</label>                 
                <input type="text" class="form-control" id="cambio_v" placeholder="Cambio" readonly>
            </div>  
        </div> 
    </div>

    <div class="modal-footer">
        <input type="hidden" id="subtotal_v" name="subtotal_v" value="<?php echo $subtotal; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Venta();"> 
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

    function Cambio(){
        var monto = $('#monto_entregado').val(); 
        var subtotal = $('#subtotal_v').val(); 
        $('#cambio_v').val((parseFloat(monto)-parseFloat(subtotal)).toFixed(2)); 
    }

    function Insert_Venta(){
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

        var dataString = $("#formulario_detalle").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Insert_Venta"; 

        if (Valida_Insert_Venta()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data.split("*")[0]=="producto"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡No se ha seleccionado ningún producto!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data.split("*")[0]=="alumno"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡No se ha seleccionado Alumno!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data.split("*")[0]=="cierre_caja"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Ya se ha realizado el Cierre de Caja!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.open('<?php echo site_url(); ?>AppIFV/Recibo_Venta/'+data.split("*")[1], '_blank');
                        window.location = "<?php echo site_url(); ?>AppIFV/Nueva_Venta"; 
                    }
                }
            });
        }
    }

    function Valida_Insert_Venta() {
        if($('#id_tipo_pago').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Pago.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(parseFloat($('#monto_entregado').val()) < parseFloat($('#subtotal_v').val())) {
            Swal(
                'Ups!',
                'Debe ingresar Monto Entregado superior a la Venta.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#monto_entregado').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Monto Entregado.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>
