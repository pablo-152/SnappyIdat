<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Especialidad (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Licenciamiento: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="licenciamiento_i" id="licenciamiento_i">
                    <option value="0">Seleccione</option>
                    <option value="1">L14</option>
                    <option value="2">L20</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="abreviatura_i" name="abreviatura_i" placeholder="Ingresar Código" maxlength="2">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_especialidad_i" name="nom_especialidad_i" placeholder="Ingresar Nombre" maxlength="50">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Módulo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nmodulo_i" name="nmodulo_i" value="4" onkeypress="return soloNumeros(event)" maxlength="1" placeholder="Ingresar N° Módulo">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Especialidad();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Especialidad(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Especialidad";

        if (Valida_Insert_Especialidad()) {
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
                        window.location = "<?php echo site_url(); ?>AppIFV/Especialidad";
                    }
                }
            });
        }
    }

    function Valida_Insert_Especialidad() {
        if($('#licenciamiento_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#abreviatura_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar referencia corta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_especialidad_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre de especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nmodulo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar N° Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nmodulo_i').val()<1) {
            Swal(
                'Ups!',
                'Debe ingresar al menos un Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nmodulo_i').val()>4) {
            Swal(
                'Ups!',
                'Solo puede ingresar hasta 4 Módulos',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
