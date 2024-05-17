<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Correo (Nuevo)</b></h5> 
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">  
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_tipo_i" name="id_tipo_i" onchange="Tipo_I();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $list){ ?>
                        <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 mostrar_especialidad_i">
                <label class="control-label text-bold">Especialidad: </label>
            </div>
            <div class="form-group col-md-4 mostrar_especialidad_i">
                <select class="form-control" id="id_especialidad_i" name="id_especialidad_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>"><?php echo $list['nom_especialidad']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Asunto: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="asunto_i" name="asunto_i" placeholder="Ingresar Asunto">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Texto: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" id="texto_i" name="texto_i" placeholder="Ingresar Texto" rows="5"></textarea>
            </div>

            <div class="form-group col-md-2 mostrar_documento_i">
                <label class="control-label text-bold">Documento: </label>
            </div>
            <div class="form-group col-md-10 mostrar_documento_i">
                <input type="file" id="documento_i" name="documento_i" onchange="validarExt_I();">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Correo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Tipo_I();
    });

    function Tipo_I(){
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

        var id_tipo = $('#id_tipo_i').val();

        if(id_tipo==1 || id_tipo==2){
            $('.mostrar_especialidad_i').show();
        }else{
            $('.mostrar_especialidad_i').hide();
        }

        if(id_tipo==4){
            $('.mostrar_documento_i').show();
        }else{
            $('.mostrar_documento_i').hide();
        }
    }

    function validarExt_I(){
        var archivoInput = document.getElementById('documento_i'); 
        var archivoRuta = archivoInput.value; 
        var extPermitidas = /(.pdf)$/i;
        if(!extPermitidas.exec(archivoRuta)){
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
        }else{
            return true;
        }
    }

    function Insert_Correo(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Correo_Efsrt";

        if (Valida_Insert_Correo()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
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
                        Lista_Correo(); 
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Insert_Correo() {
        if($('#id_tipo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;  
        }
        if($('#id_tipo_i').val().trim() === '1' || $('#id_tipo_i').val().trim() === '2') {
            if($('#id_especialidad_i').val().trim() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Especialidad.',
                    'warning'
                ).then(function() { });
                return false;  
            }
        }
        if($('#asunto_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Asunto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#texto_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Texto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_i').val().trim() === '4'){
            if($('#documento_i').val().trim() === '') {
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
