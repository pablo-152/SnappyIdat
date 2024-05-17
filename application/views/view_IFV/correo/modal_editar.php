<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Correo</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_tipo']; ?>" disabled>
            </div>
            
            <div class="form-group col-md-2 mostrar_especialidad_u">
                <label class="control-label text-bold">Especialidad: </label>
            </div>
            <div class="form-group col-md-4 mostrar_especialidad_u">
                <select class="form-control" id="id_especialidad_u" name="id_especialidad_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>" <?php if($list['id_especialidad']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>>
                            <?php echo $list['nom_especialidad']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Asunto: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="asunto_u" name="asunto_u" placeholder="Ingresar Asunto" value="<?php echo $get_id[0]['asunto']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Texto: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" id="texto_u" name="texto_u" placeholder="Ingresar Texto" rows="5"><?php echo $get_id[0]['texto']; ?></textarea>
            </div>

            <div class="form-group col-md-2 mostrar_documento_u">
                <label class="control-label text-bold">Documento: </label> 
            </div>
            <div class="form-group col-md-10 mostrar_documento_u">
                <button type="button" onclick="Abrir('documento_u')">Seleccionar archivo</button>
                <input type="file" id="documento_u" name="documento_u" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
                <span id="span_documento"><?php if($get_id[0]['documento']!=""){ echo $get_id[0]['nom_documento']; }else{ echo "No se eligió archivo"; } ?></span>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_correo" name="id_correo" value="<?php echo $get_id[0]['id_correo']; ?>">
        <input type="hidden" id="id_tipo_u" name="id_tipo_u" value="<?php echo $get_id[0]['id_tipo']; ?>">
        <input type="hidden" id="documento_actual" name="documento_actual" value="<?php echo $get_id[0]['documento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Correo();"> 
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Tipo_U();
    });
    
    function Tipo_U(){
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

        var id_tipo = $('#id_tipo_u').val();

        if(id_tipo==1){
            $('.mostrar_especialidad_u').show();
        }else{
            $('.mostrar_especialidad_u').hide();
        }

        if(id_tipo==4){
            $('.mostrar_documento_u').show();
        }else{
            $('.mostrar_documento_u').hide();
        }
    }

    function Abrir(id) {
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
    }

    function Nombre_Archivo(element,glosa) {
        var glosa = document.getElementById(glosa);
        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            if(element.files[0].name.substr(-3)=='pdf' || element.files[0].name.substr(-3)=='PDF'){
                glosa.innerText = element.files[0].name;
            }else{
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar documento con extensión .pdf.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }
        }
    }

    function Update_Correo(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Correo_Efsrt";

        if (Valida_Update_Correo()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false, 
                success:function (data) {
                    if(data=="error"){ 
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Correo(); 
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Update_Correo() {
        if($('#id_tipo_u').val().trim() === '1') {
            if($('#id_especialidad_u').val().trim() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Especialidad.',
                    'warning'
                ).then(function() { });
                return false;  
            }
        }
        if($('#asunto_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Asunto.',
                'warning' 
            ).then(function() { });
            return false;
        }
        if($('#texto_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Texto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_u').val().trim() === '4' && $('#documento_actual').val().trim() === ''){
            if($('#documento_u').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Documento.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>