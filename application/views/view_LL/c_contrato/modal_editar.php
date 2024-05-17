<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Contrato</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_u" name="tipo_u" onchange="Tipo_Contrato_U();">
                    <option value="0" <?php if($get_id[0]['tipo']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['tipo']==1){ echo "selected"; } ?>>Contrato (Matricula)</option>
                    <option value="2" <?php if($get_id[0]['tipo']==2){ echo "selected"; } ?>>Contrato (Pago Cuota)</option>
                    <option value="3" <?php if($get_id[0]['tipo']==3){ echo "selected"; } ?>>Contrato (Pago Matricula)</option>
                    <option value="4" <?php if($get_id[0]['tipo']==4){ echo "selected"; } ?>>Contrato (Puntual)</option>
                    <option value="5" <?php if($get_id[0]['tipo']==5){ echo "selected"; } ?>>Mensaje</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ref:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" maxlength="5" placeholder="Ref" value="<?php echo $get_id[0]['referencia']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mes/Año:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="mes_anio_u" name="mes_anio_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ 
                        foreach($list_mes as $mes){ ?>
                            <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>" 
                                <?php if($mes['cod_mes']."/".$list['nom_anio']==$get_id[0]['mes_anio']){ echo "selected"; } ?>>
                                <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 mostrar_u">
                <label class="control-label text-bold">Fec. Envío:</label>
            </div>
            <div class="form-group col-md-4 mostrar_u">
                <input type="date" class="form-control" id="fecha_envio_u" name="fecha_envio_u" value="<?php echo $get_id[0]['fecha_envio']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Asunto:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="asunto_u" name="asunto_u" placeholder="Asunto" value="<?php echo $get_id[0]['asunto']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Enviar a:</label>
            </div>
        </div>

        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_grado_u" name="id_grado_u" onchange="Traer_Seccion_Contrato_U();">
                    <option value="0">Todos</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['Grado']; ?>" <?php if($list['Grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                            <?php echo $list['Grado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 mostrar_u">
                <label class="control-label text-bold">Sección:</label>
            </div>
            <div id="select_seccion_u" class="form-group col-md-4 mostrar_u">
                <select class="form-control" id="id_seccion_u" name="id_seccion_u">
                    <option value="0">Todos</option>
                    <?php foreach($list_seccion as $list){ ?>
                        <option value="<?php echo $list['Seccion']; ?>" <?php if($list['Seccion']==$get_id[0]['id_seccion']){ echo "selected"; } ?>>
                            <?php echo $list['Seccion']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>
        </div>   

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Texto Correo:</label>
                <textarea class="form-control" id="texto_correo_u" name="texto_correo_u" placeholder="Texto Correo" rows="5"><?php echo $get_id[0]['texto_correo']; ?></textarea>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <input type="checkbox" id="sms_u" name="sms_u" value="1" <?php if($get_id[0]['sms']==1){ echo "checked"; } ?> onclick="Habilitar_Sms_U();">
                <label class="control-label text-bold">SMS</label>
                <textarea class="form-control mostrar_sms_u" id="texto_sms_u" name="texto_sms_u" placeholder="SMS" rows="2" maxlength="160"><?php echo $get_id[0]['texto_sms']; ?></textarea>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label> 
            </div>
            <div class="form-group col-md-10">
                <!--<input type="file" id="documento_u" name="documento_u" onchange="validarExt_U();">-->
                <button type="button" onclick="Abrir('documento_u')">Seleccionar archivo</button>
                <input type="file" id="documento_u" name="documento_u" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
                <span id="span_documento"><?php if($get_id[0]['documento']!=""){ echo $get_id[0]['nom_documento']; }else{ echo "No se eligió archivo"; } ?></span>
            </div>  
        </div> 
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>   	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="documento_actual" name="documento_actual" value="<?php echo $get_id[0]['documento']; ?>">
        <input type="hidden" id="id_c_contrato" name="id_c_contrato" value="<?php echo $get_id[0]['id_c_contrato']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_C_Contrato()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Tipo_Contrato_U();
        Habilitar_Sms_U();
    });

    function Tipo_Contrato_U(){
        if($('#tipo_u').val()==5){
            $('.mostrar_u').show();
        }else{
            $('.mostrar_u').hide();
            $('#id_seccion_u').val('0');
        }
    }

    function Traer_Seccion_Contrato_U(){
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

        var url="<?php echo site_url(); ?>LittleLeaders/Traer_Seccion_Contrato_U";
        var id_grado = $('#id_grado_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grado':id_grado},
            success:function (data) {
                $('#select_seccion_u').html(data);
            }
        });
    }

    function Habilitar_Sms_U(){
        if($('#sms_u').is(':checked')) {
            $('.mostrar_sms_u').show();
        }else{
            $('.mostrar_sms_u').hide();
            $('#texto_sms_u').val('');
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

    function Update_C_Contrato(){
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
        var url="<?php echo site_url(); ?>LittleLeaders/Update_C_Contrato";

        if (Valida_Update_C_Contrato()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_C_Contrato();
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }

    function Valida_Update_C_Contrato() {
        if($('#tipo_u').val().trim() === '0') {
            Swal(
                'Ups!', 
                'Debe ingresar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#referencia_u').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Ref.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mes_anio_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Mes/Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_u').val()==5){
            if($('#fecha_envio_u').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Fecha Envío.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#descripcion_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#asunto_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Asunto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#documento_actual').val().trim() === '' && $('#documento_u').val().trim() === '') {
            if($('#documento_u').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Documento.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#estado_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>