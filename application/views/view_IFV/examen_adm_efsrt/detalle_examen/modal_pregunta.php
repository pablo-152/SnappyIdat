
<form  method="post" id="formulario" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pregunta (Nuevo)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <!--<div class="form-group col-md-6">
                <label class=" control-label text-bold">Carrera: </label>
                <div class="col">
                    <?php echo $get_id[0]['carrera'] ?>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Área: </label>
                <div class="col">
                    <?php echo $get_id[0]['nombre'] ?>
                </div>
            </div>-->

            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Orden: </label>
                <div class="col">
                    <input class="form-control" type="text" id="orden" name="orden" placeholder="Orden">
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Pregunta:</label>
                <div class="col">
                    <textarea name="pregunta" rows="2" class="form-control" id="pregunta" placeholder="Pregunta"></textarea>
                </div>
            </div>
                
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa 1:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa1" name="alternativa1" placeholder= "Ingresar Respuesta">
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa 2:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa2" name="alternativa2" placeholder= "Ingresar Respuesta">
                </div>  
            </div>
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa 3:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa3" name="alternativa3" placeholder= "Ingresar Respuesta">
                </div>
            </div>
            <!--<div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa 4:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa4" name="alternativa4" placeholder= "Ingresar Respuesta">
                </div>
            </div>-->
            
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Respuesta Correcta:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa5" name="alternativa5" placeholder= "Ingresar Respuesta">
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Cargar Imagen: </label>
                <div class="col">
                    <input type="file" id="img" name="img" onchange="validarExt_I();">
                </div>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_carrera" name="id_carrera" value="<?php echo $id_carrera; ?>"> 
        <input type="hidden" id="id_examen" name="id_examen" value="<?php echo $id_examen; ?>"> 
        <button type="button" class="btn btn-primary" onclick="Insert_Pregunta_Efsrt();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function validarExt_I(){
        var archivoInput = document.getElementById('img'); 
        var archivoRuta = archivoInput.value; 
        var extPermitidas = /(.png)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar foto con extensiones .png.",
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

    function Insert_Pregunta_Efsrt(){
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Pregunta_Efsrt";

        if (Valida_Insert_Pregunta_Efsrt()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="cant"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡La carrera seleccionada llegó al límite de preguntas!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#acceso_modal .close").click();
                            List_Pregunta_Efsrt('<?php echo $id_carrera ?>','<?php echo $id_examen ?>');
                        });
                    }
                }
            });
        }
    }

    function Valida_Insert_Pregunta_Efsrt(){
        if($('#orden').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#pregunta').val() == '') { 
            Swal(
                'Ups!',
                'Debe ingresar Pregunta.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#alternativa1').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 1.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alternativa2').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 2.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alternativa3').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 3.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#alternativa4').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 4.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if($('#alternativa5').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 4.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    
</script>