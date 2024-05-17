<form id="formulario_devolucion" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Devolución de Venta</h5> 
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Motivo: </label> 
                <textarea class="form-control" id="motivo_a" name="motivo_a" placeholder="Motivo" rows="8" maxlength="25"></textarea>
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $get_id[0]['id_venta']; ?>">
        <button type="button" class="btn btn-primary" onclick="Anular_Venta();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Anular_Venta(id){
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

        var dataString = $("#formulario_devolucion").serialize();
        var url="<?php echo site_url(); ?>Laleli5/Anular_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data:dataString,
            success:function (data) {
                if(data=="cierre_caja"){
                    Swal({
                        title: 'Anulación Denegada',
                        text: "¡Ya se ha realizado el Cierre de Caja!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="error"){
                    Swal({
                        title: 'Devolución Denegada',
                        text: "¡No tienes el monto a devolver!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Venta();
                    $("#acceso_modal_mod .close").click()
                }
            }
        });
    }
</script>