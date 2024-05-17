<form id="formulario_update_pago_pendiente" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Pagar Producto</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Pago: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_tipo_pago_p" name="id_tipo_pago_p">
                    <option value="0">Seleccione</option>
                    <option value="1">Cheque</option>
                    <option value="2" selected>Efectivo</option>
                    <option value="3">Transferencia</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Monto Entregado:</label>
            </div>        
            <div class="form-group col-md-4">   
                <input type="text" class="form-control solo_numeros_punto" id="monto_entregado_p" name="monto_entregado_p" placeholder="Monto Entregado" onkeyup="Cambio();">
            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Cambio:</label> 
            </div>   
            <div class="form-group col-md-4">            
                <input type="text" class="form-control" id="cambio_p" placeholder="Cambio" readonly>
            </div>  
        </div> 
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $id_venta; ?>">
        <input type="hidden" id="subtotal_p" name="subtotal_p" value="<?php echo $subtotal; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Pago_Snappy();"> 
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
        var monto = $('#monto_entregado_p').val(); 
        var subtotal = $('#subtotal_p').val(); 
        $('#cambio_p').val((parseFloat(monto)-parseFloat(subtotal)).toFixed(2)); 
    }

    function Update_Pago_Snappy(){
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

        var tipo_excel = $('#tipo_excel_sp').val();
        var dataString = new FormData(document.getElementById('formulario_update_pago_pendiente'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Pago_Snappy"; 

        if (Valida_Update_Pago_Snappy()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data.split("*")[0]=="cierre_caja"){
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
                        Lista_Pagos_Snappy(tipo_excel);
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Pago_Snappy() {
        if($('#id_tipo_pago_p').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Pago.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(parseFloat($('#monto_entregado_p').val()) < parseFloat($('#subtotal_p').val())) {
            Swal(
                'Ups!',
                'Debe ingresar Monto Entregado superior a la Venta.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
