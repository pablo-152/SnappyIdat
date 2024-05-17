
<form  method="post" id="formulario" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pregunta (Nuevo)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
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
            </div>

            
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Orden: </label>
                <div class="col">
                    <input class="form-control" required type="text" id="orden" name="orden"  />
                </div>
            </div>
            

            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Pregunta:</label>
                <div class="col">
                    <textarea name="pregunta" rows="5" class="form-control" id="pregunta"></textarea>
                </div>
            </div>
                
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;1:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa1" name="alternativa1" placeholder= "Ingresar Respuesta"  />
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;2:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa2" name="alternativa2" placeholder= "Ingresar Respuesta"  />
                </div>  
            </div>
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;3:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa3" name="alternativa3" placeholder= "Ingresar Respuesta"  />
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;4:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa4" name="alternativa4" placeholder= "Ingresar Respuesta"  />
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Respuesta&nbsp;Correcta:</label>
                <div class="col">
                    <input class="form-control" required type="text" id="alternativa5" name="alternativa5" placeholder= "Ingresar Respuesta"  />
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Cargar Imagen: </label>
                <div class="col" align="left">
                    <input name="img" id="img" type="file" class="file" onchange="return validarExt()" size="100" required data-allowed-file-extensions='["png"]'  >
                </div>
            </div>

            
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_area" name="id_area" value="<?php echo $id_area; ?>"> 
        <input type="hidden" id="id_examen" name="id_examen" value="<?php echo $id_examen; ?>"> 
        <button type="button" class="btn btn-primary" onclick="Insert_Pregunta();" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>


<script type="text/javascript">
    function validarExt()
    {
        var archivoInput = document.getElementById('foto1');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.png)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            alert('Asegurese de haber seleccionado un archivo .png .');
            archivoInput.value = '';
            return false;
        }
        else
        {   if (archivoRuta.substr(-3) === "png") {
                let img = new Image()
                img.src = window.URL.createObjectURL(event.target.files[0])
                img.onload = () => {
                    if(img.width === 220 && img.height === 410){
                        //alert(`Agradable, la imagen tiene el tamaño correcto. Se puede subir.`)
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("visibility", "visible");
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("opacity", "1");
                        $("div.uno div.file-input div.file-preview div.file-drop-zone div.file-preview-thumbnails div.file-preview-frame.krajee-default.kv-preview-thumb").css("visibility", "visible");

                     
                        // upload logic here
                        } else {
                        alert(`Lo sentimos, esta imagen de ${img.width} x ${img.height} de tamaño no se parece a lo que se pide. Se requiere que el tamaño sea 220 x 410.`);
                       // $("img.file-preview-image.kv-preview-data").attr("src", "");
                       // $("img.file-preview-image.kv-preview-data").attr("alt", "");
                       // $("img.file-preview-image.kv-preview-data").attr("title", "");
                       // $("img.file-preview-image.kv-preview-data").css("visibility", "hidden");
				       // $("img.file-preview-image.kv-preview-data").css("opacity", "0");
                       // $('div.file-caption-info').empty();
                       // $('div.file-size-info').empty();
                        //$('div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name').attr("title", "");
                       // $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").val("");
                        $("div.uno div.file-input div.file-preview div.file-drop-zone div.file-preview-thumbnails div.file-preview-frame.krajee-default.kv-preview-thumb").css("visibility", "hidden");
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("visibility", "hidden");
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("opacity", "0");
                        $("div.uno input#foto1").val("");
                        }                
            }
            }else{

            }
 
        }
    }

    function Insert_Pregunta()
    {
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Valida_Pregunta_Adm";

        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>AppIFV/Insert_Pregunta_Admision";

        var id_area = $('#id_area').val();
        var id_examen = $('#id_examen').val();
        if (Valida_Pregunta()) {
            bootbox.confirm({
                title: "Registrar Pregunta para Examen",
                message: "¿Desea registrar pregunta para examen de admsión?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                        //return false;
                    }else{
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:dataString,
                            success:function (data) {
                                if(data=="dup")
                                {
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡La pregunta ya existe para el área seleccionado!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }
                                else if(data=="cant")
                                {
                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡El área seleccionado llegó al límite de preguntas!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                }
                                else
                                {
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function () {
                                            swal.fire(
                                                'Registro Exitoso!',
                                                '',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>AppIFV/Preguntas/"+id_area+"/"+id_examen;
                                                
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                } 
            });

            
        }
    }

    function Valida_Pregunta()
    {
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
        if($('#alternativa4').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 4.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alternativa5').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Alternativa 5.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if (R1==false && R2==false && R3==false)
        {
        msgDate = 'Debe seleccionar la respuesta correcta para la pregunta antes de registrar';
        return false;
        }*/
        return true;
    }
</script>