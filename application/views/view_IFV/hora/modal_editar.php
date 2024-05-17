<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Hora</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_especialidad_u" name="id_especialidad_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>" <?php if($list['id_especialidad']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>>
                            <?php echo $list['nom_especialidad']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="text" id="nom_turno_u" name="nom_turno_u" placeholder="Turno" value="<?php echo $get_id[0]['nom_turno']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Desde:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="desde_u" name="desde_u" value="<?php echo $get_id[0]['desde']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="hasta_u" name="hasta_u" value="<?php echo $get_id[0]['hasta']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tolerancia:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control solo_numero" type="text" id="tolerancia_u" name="tolerancia_u" placeholder="Tolerancia" value="<?php echo $get_id[0]['tolerancia']; ?>">
            </div>
        </div>     	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_hora" name="id_hora" value="<?php echo $get_id[0]['id_hora']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_C_Hora()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    $('.solo_numero').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Update_C_Hora(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_C_Hora";

        if (Valida_Update_C_Hora()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actulización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $('#acceso_modal_mod .close').click();
                        Lista_C_Hora();
                    }
                }
            });
        }
    }

    function Valida_Update_C_Hora() {
        if($('#id_especialidad_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_turno_u').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Turno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desde_u').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Desde.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_u').val() === '') {
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