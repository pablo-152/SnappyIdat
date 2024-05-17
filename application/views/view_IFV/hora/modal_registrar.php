<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Hora (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_especialidad_i" name="id_especialidad_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>"><?php echo $list['nom_especialidad']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label> 
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="text" id="nom_turno_i" name="nom_turno_i" placeholder="Turno">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Desde:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="desde_i" name="desde_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="hasta_i" name="hasta_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tolerancia:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control solo_numero" type="text" id="tolerancia_i" name="tolerancia_i" placeholder="Tolerancia">
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_C_Hora()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numero').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    function Insert_C_Hora(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_C_Hora";

        if (Valida_Insert_C_Hora()) {
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
                        Lista_C_Hora();
                    }
                }
            });
        }
    }

    function Valida_Insert_C_Hora() {
        if($('#id_especialidad_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_turno_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Turno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desde_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Desde.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Hasta.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
