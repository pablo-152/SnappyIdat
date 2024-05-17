<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Horario Academico (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="turno" name="turno">
                    <option value="0">Seleccione</option>
                    <option value="1">Mañana</option>
                    <option value="2">Tarde</option>
                    <option value="3">Noche</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Desde:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="desde" name="desde">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="hasta" name="hasta">
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Horario_Academico()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    
    function Insert_Horario_Academico(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Horario_Academico";

        if (Valida_Insert_Horario_Academico()) {
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
                        $('#acceso_modal .close').click();
                        Lista_Horario_Academico();
                    }
                }
            });
        }
    }

    function Valida_Insert_Horario_Academico() {
        if($('#turno').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Turno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desde').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Hora de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Hora de Termino.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
