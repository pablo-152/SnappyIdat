<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Horario Academico</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="turnoe" name="turnoe">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['turno']==1){echo "selected";}?>>Mañana</option>
                    <option value="2" <?php if($get_id[0]['turno']==2){echo "selected";}?>>Tarde</option>
                    <option value="3" <?php if($get_id[0]['turno']==3){echo "selected";}?>>Noche</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Desde:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="desdee" name="desdee" value="<?php echo $get_id[0]['desde'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
                <input class="form-control" type="time" id="hastae" name="hastae" value="<?php echo $get_id[0]['hasta'] ?>">
            </div>
        </div>     	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_horario_acad" name="id_horario_acad" value="<?php echo $get_id[0]['id_horario_acad']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Horario_Academico()">
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

    function Update_Horario_Academico(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Horario_Academico";

        if (Valida_Update_Horario_Academico()) {
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
                        Lista_Horario_Academico();
                    }
                }
            });
        }
    }

    function Valida_Update_Horario_Academico() {
        if($('#turnoe').val() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Turno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desdee').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Hora de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hastae').val() === '') {
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