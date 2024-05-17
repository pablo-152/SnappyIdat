<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Tipo Contrato (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_tipo_i" name="nom_tipo_i" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="alumno_i" name="alumno_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Admisión</option>
                    <option value="2">Matriculado</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Envío</label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="fecha_envio_i" name="fecha_envio_i" value="1">
            </div>
        </div>	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Tipo_C_Contrato()"> 
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Tipo_C_Contrato(){
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

        var dataString = new FormData(document.getElementById('formulario_insert')); 
        var url="<?php echo site_url(); ?>AppIFV/Insert_Tipo_C_Contrato";

        if (Valida_Insert_Tipo_C_Contrato()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
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
                        Lista_Tipo_C_Contrato();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Tipo_C_Contrato() {
        if($('#nom_tipo_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alumno_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
