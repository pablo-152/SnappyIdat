<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Área (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="codigo_i" name="codigo_i" maxlength="6" placeholder="Ingresar Código">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre_i" name="nombre_i" maxlength="50" placeholder="Ingresar Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Orden: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="orden_i" name="orden_i" maxlength="1" placeholder="Ingresar Orden" onkeypress="return soloNumeros(event)">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $id_especialidad; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Area();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Area(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Area";

        if (Valida_Insert_Area()) {
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
                        Lista_Area();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Area() {
        if($('#codigo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombre_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_i').val()<1) {
            Swal(
                'Ups!',
                'Orden debe ser mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_i').val()>4) {
            Swal(
                'Ups!',
                'Orden debe ser menor o igual a 4.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
