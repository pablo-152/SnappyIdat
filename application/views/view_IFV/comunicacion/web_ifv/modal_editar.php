<form id="formulario_update" method="post" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Web IFV</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" id="flag_referencia_u" name="flag_referencia_u" onchange="Flag_Referencia_U();">
                        <option value="">Seleccione</option>
                        <?php foreach($list_tipo as $list){?> 
                            <option value="<?php echo $list['id'] ?>" <?php if($get_id[0]['flag_referencia']==$list['id']){echo "selected";}?>><?php echo $list['tipo'] ?></option>    
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 mostrar_carrera_u">
                <label class="control-label text-bold">Carrera: </label>
                <div class="col">
                    <select class="form-control" id="id_carrera_u" name="id_carrera_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_carrera as $list){?> 
                            <option value="<?php echo $list['id_carrera'] ?>" <?php if($list['id_carrera']==$get_id[0]['cod_referencia']){ echo "selected"; } ?>>
                                <?php echo $list['nombre'] ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 mostrar_referencia_u">
                <label class="control-label text-bold">Referencia: </label>
                <div class="col">
                    <input type="text" class="form-control" id="refe_comuimg_u" name="refe_comuimg_u" placeholder="Ingresar Referencia" maxlength="25" value="<?php echo $get_id[0]['refe_comuimg']; ?>">
                </div>
            </div>
        </div>
        
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Activo de: </label>
                <div class="col">
                    <input type="date" class="form-control" id="inicio_comuimg_u" name="inicio_comuimg_u" value="<?php echo $get_id[0]['inicio_comuimg']; ?>">
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Hasta: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fin_comuimg_u" name="fin_comuimg_u" value="<?php echo $get_id[0]['fin_comuimg']; ?>">
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Archivo:</label>
                <div class="col">
                    <button type="button" onclick="Abrir('img_comuimg_u')">Seleccionar archivo</button>
                    <input type="file" id="img_comuimg_u" name="img_comuimg_u" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
                    <span id="span_documento"><?php if($get_id[0]['img_comuimg']!=""){ echo $get_id[0]['nom_documento']; }else{ echo "No se eligió archivo"; } ?></span>
                    <p style="color:#867A82;">Maximo 2Mb ó 2048kl</p>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Estado: </label>
                <div class="col">
                    <select class="form-control" id="estado_u" name="estado_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){?> 
                            <option value="<?php echo $list['id_statusav'] ?>" <?php if($list['id_statusav']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status'] ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_comuimg" name="id_comuimg" value="<?php echo $get_id[0]['id_comuimg']; ?>">
        <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $get_id[0]['img_comuimg']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Web_IFV();" >
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Flag_Referencia_U();
    });

    function Flag_Referencia_U(){
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var flag_referencia = $('#flag_referencia_u').val();

        if(flag_referencia==1){
            $('.mostrar_carrera_u').show();
            $('.mostrar_referencia_u').hide();
            $('#refe_comuimg_u').val('');
        }else if(flag_referencia==""){
            $('.mostrar_carrera_u').hide();
            $('.mostrar_referencia_u').hide();
            $('#refe_comuimg_u').val('');
            $('#id_carrera_u').val('0');
        }else{
            $('.mostrar_carrera_u').hide();
            $('.mostrar_referencia_u').show();
            $('#id_carrera_u').val('0');
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
        var flag_referencia = $('#flag_referencia_u').val();
        var glosa = document.getElementById(glosa);

        if(flag_referencia==0 || flag_referencia==1 || flag_referencia==3){
            var texto = "extensión .pdf";
        }else{
            var texto = "extensiones .png, .jpg, .jpeg.";
        }

        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            if(flag_referencia==0 || flag_referencia==1 || flag_referencia==3){
                if(element.files[0].name.substr(-3)=='pdf' || element.files[0].name.substr(-3)=='PDF'){
                    glosa.innerText = element.files[0].name;
                }else{
                    Swal({
                        title: 'Registro Denegado',
                        text: "Asegurese de ingresar archivo con "+texto,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                    archivoInput.value = '';
                    return false;
                }
            }else{
                if(element.files[0].name.substr(-3)=='jpg' || element.files[0].name.substr(-3)=='JPG'){
                    glosa.innerText = element.files[0].name;
                }else{
                    Swal({
                        title: 'Registro Denegado',
                        text: "Asegurese de ingresar archivo con "+texto,
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
    }

    function Update_Web_IFV(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Web_IFV";

        if (Valida_Update_Web_IFV()) {
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
                            text: 'Existe un registro que coincide con las fechas de publicación ingresada, por favor verificar!',
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Web_IFV(1);
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Update_Web_IFV() {
        if ($('#flag_referencia_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#flag_referencia_u').val().trim() === '1') {
            if ($('#id_carrera_u').val().trim() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Carrera.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#flag_referencia_u').val().trim() === '0'  || $('#flag_referencia_u').val().trim() === '2' || $('#flag_referencia_u').val().trim() === '3') {
            if ($('#refe_comuimg_u').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Referencia.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#inicio_comuimg_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin_comuimg_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#estado_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>

