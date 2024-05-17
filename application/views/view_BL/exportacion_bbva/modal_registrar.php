<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Recaudación (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">T. Operación:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="tipo_operacion_i" id="tipo_operacion_i">
                    <option value="0">Seleccione</option>
                    <option value="1">P: Actualización Parcial</option>
                    <option value="2">T: Actualización Total</option>
                </select>
            </div>   

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Inicio: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_inicio_i" name="fec_inicio_i">
            </div>
            
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Fecha Fin:</label>                 
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_fin_i" name="fec_fin_i">
            </div>           	                	        
        </div> 
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Exportacion_Bbva();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Exportacion_Bbva(){
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

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Exportacion_Bbva";

        if (Valida_Insert_Exportacion_Bbva()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function(){
                        Lista_Exportacion_Bbva();
                        $("#acceso_modal .close").click()
                    });
                }
            });
        }    
    }

    function Valida_Insert_Exportacion_Bbva() {
        if($('#tipo_operacion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tipo Operación.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_inicio_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_fin_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
