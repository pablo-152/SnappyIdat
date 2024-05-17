<form method="post" id="formulario_evaluacion_basica" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Evaluación Básica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:650px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Fecha: </label> 
            </div>
            <div class="form-group col-md-4"> 
                <input type="date" class="form-control" id="fec_evaluacion_eb" name="fec_evaluacion_eb" value="<?php echo $get_id[0]['fec_evaluacion']; ?>">
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Evaluador: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_evaluador_eb" name="id_evaluador_eb">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_evaluador as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                    <?php } ?>
                </select>
            </div> 

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Teórico: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_teorico_eb" name="puntaje_teorico_eb" placeholder="Puntaje Teórico" value="<?php echo $get_id[0]['puntaje_teorico']; ?>">
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Practico 1: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_practico_1_eb" name="puntaje_practico_1_eb" placeholder="Puntaje Practico 1" value="<?php echo $get_id[0]['puntaje_practico_1']; ?>">
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Practico 2: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_practico_2_eb" name="puntaje_practico_2_eb" placeholder="Puntaje Practico 2" value="<?php echo $get_id[0]['puntaje_practico_2']; ?>">
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Presentación Personal 1: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_presentacion_personal_1_eb" name="puntaje_presentacion_personal_1_eb" placeholder="Puntaje Presentación Personal 1" value="<?php echo $get_id[0]['puntaje_presentacion_personal_1']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Presentación Personal 2: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_presentacion_personal_2_eb" name="puntaje_presentacion_personal_2_eb" placeholder="Puntaje Presentación Personal 2" value="<?php echo $get_id[0]['puntaje_presentacion_personal_2']; ?>">
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Presentación Personal 3: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_presentacion_personal_3_eb" name="puntaje_presentacion_personal_3_eb" placeholder="Puntaje Presentación Personal 3" value="<?php echo $get_id[0]['puntaje_presentacion_personal_3']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">P. Presentación Personal 4: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="text" class="form-control solo_numeros_punto" id="puntaje_presentacion_personal_4_eb" name="puntaje_presentacion_personal_4_eb" placeholder="Puntaje Presentación Personal 4" value="<?php echo $get_id[0]['puntaje_presentacion_personal_4']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Documento: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="documento_eb" name="documento_eb" onchange="Validar_Extension_Eb();">
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_evaluacion" name="id_evaluacion" value="<?php echo $get_id[0]['id_evaluacion']; ?>">
        <input type="hidden" id="documento_actual_eb" name="documento_actual_eb" value="<?php echo $get_id[0]['documento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Evaluacion_Basica();">
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

    function Validar_Extension_Eb(){
        var archivoInput = document.getElementById('documento_eb');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf)$/i;

        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivos con extensiones .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = ''; 
            return false;
        }else{
            return true;         
        }
    }

    function Update_Evaluacion_Basica(){
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
            })
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
        
        var dataString = new FormData(document.getElementById('formulario_evaluacion_basica'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Evaluacion_Basica_Efsrt";  

        if (Valida_Update_Evaluacion_Basica()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Evaluacion_Basica();
                    $("#acceso_modal .close").click()
                }
            });        
        }  
    }

    function Valida_Update_Evaluacion_Basica() {
        /*if($('#id_alumno_fc').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#contrato_fc').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Contrato.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>