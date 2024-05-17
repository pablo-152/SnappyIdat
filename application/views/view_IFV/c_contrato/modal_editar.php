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
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo as $list){ ?>
                        <option value="<?php echo $list['id_tipo']."-".$list['alumno']."-".$list['fecha_envio']; ?>" <?php if($list['id_tipo']==$get_id[0]['tipo']){ echo "selected"; } ?>>
                            <?php echo $list['nom_tipo']; ?>
                        </option> 
                    <?php } ?>
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
            <div class="form-group col-md-4">
                <select class="form-control" id="enviar_u" name="enviar_u" onchange="Tipo_Contrato_U();">
                    <option value="1" <?php if($get_id[0]['enviar']==1){ echo "selected"; } ?>>Alumno</option> 
                    <option value="2" <?php if($get_id[0]['enviar']==2){ echo "selected"; } ?>>Filtro</option> 
                </select>
            </div>
        </div>

        <div id="div_alumno_u" class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno:</label>
            </div>
            <div id="select_alumno_u" class="form-group col-md-10">
                <select class="form-control multivalue_u" id="alumnos_u" name="alumnos_u[]" multiple="multiple">
                    <?php $base_array = explode(",",$get_id[0]['alumnos']);
                    foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['id_alumno']; ?>"<?php if(in_array($list['id_alumno'],$base_array)){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['nom_alumno']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>   

        <div id="div_filtro_u" class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grupo:</label>
            </div>
            <div id="select_grupo_u" class="form-group col-md-4">
                <select class="form-control" id="id_grupo_u" name="id_grupo_u" onchange="Traer_Especialidad_Contrato_U();">
                    <option value="0">Todos</option>
                    <?php foreach($list_grupo as $list){ ?>
                        <option value="<?php echo $list['Grupo']; ?>" <?php if($list['Grupo']==$get_id[0]['id_grupo']){ echo "selected"; } ?>>
                            <?php echo $list['Grupo']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div id="select_especialidad_u" class="form-group col-md-4">
                <select class="form-control" id="id_especialidad_u" name="id_especialidad_u" onchange="Traer_Turno_Contrato_U();">
                    <option value="0">Todos</option>
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['Especialidad']; ?>" <?php if($list['Especialidad']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>>
                            <?php echo $list['Especialidad']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div id="select_turno_u" class="form-group col-md-4">
                <select class="form-control" id="id_turno_u" name="id_turno_u" <?php if($get_id[0]['alumno']==2){ ?> onchange="Traer_Modulo_Contrato_U();" <?php } ?>>
                    <option value="0">Todos</option>
                    <?php foreach($list_turno as $list){ ?>
                        <option value="<?php echo $list['Turno']; ?>" <?php if($list['Turno']==$get_id[0]['id_turno']){ echo "selected"; } ?>>
                            <?php echo $list['Turno']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Módulo:</label>
            </div>
            <div id="select_modulo_u" class="form-group col-md-4">
                <select class="form-control" id="id_modulo_u" name="id_modulo_u" <?php if($get_id[0]['alumno']==2){ ?> onchange="Traer_Seccion_Contrato_U();" <?php } ?>>
                    <option value="0">Todos</option>
                    <?php foreach($list_modulo as $list){ ?>
                        <option value="<?php echo $list['Modulo']; ?>" <?php if($list['Modulo']==$get_id[0]['id_modulo']){ echo "selected"; } ?>>
                            <?php echo $list['Modulo']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sección:</label>
            </div>
            <div id="select_seccion_u" class="form-group col-md-4">
                <select class="form-control" id="id_seccion_u" name="id_seccion_u">
                    <option value="0">Todos</option>
                    <?php foreach($list_seccion as $list){ ?>
                        <option value="<?php echo $list['Seccion']; ?>" <?php if($list['Seccion']==$get_id[0]['id_seccion_fv']){ echo "selected"; } ?>>
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
                            <?php if($list['id_status']==2){ echo $list['nom_status']." (Envía correo)"; }else{ echo $list['nom_status']; } ?>
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
        var tipo = $('#tipo_u').val().split('-');

        if(tipo[2]==1){
            $('.mostrar_u').show();
        }else{
            $('.mostrar_u').hide();
            $('#fecha_envio_u').val('');
        }

        Habilitar_Sms_U();

        <?php if($get_id[0]['enviar']==1){ ?>
            $('#div_filtro_u').hide();
        <?php }else{ ?>
            $('#div_alumno_u').hide();
        <?php } ?>
    });

    var ss = $(".multivalue_u").select2({
        tags: true
    });

    $('.multivalue_u').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Tipo_Contrato_U(){
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

        var enviar = $('#enviar_u').val();

        if(enviar==1){
            var url="<?php echo site_url(); ?>AppIFV/Traer_Alumno_Contrato_U"; 
            var tipo = $('#tipo_u').val().split('-');

            $.ajax({
                type:"POST",
                url:url,
                data:{'alumno':tipo[1]},
                success:function (data) {
                    $('#div_alumno_u').show();
                    $('#select_alumno_u').html(data);
                    $('#div_filtro_u').hide();
                    $('#select_grupo_u').html('<select class="form-control" id="id_grupo_u" name="id_grupo_u"><option value="0">Todos</option></select>');
                    $('#select_especialidad_u').html('<select class="form-control" id="id_especialidad_u" name="id_especialidad_u"><option value="0">Todos</option></select>');
                    $('#select_turno_u').html('<select class="form-control" id="id_turno_u" name="id_turno_u"><option value="0">Todos</option></select>');
                    $('#select_modulo_u').html('<select class="form-control" id="id_modulo_u" name="id_modulo_u"><option value="0">Todos</option></select>');
                    $('#select_seccion_u').html('<select class="form-control" id="id_seccion_u" name="id_seccion_u"><option value="0">Todos</option></select>');
                }
            });
        }else{
            var url="<?php echo site_url(); ?>AppIFV/Traer_Grupo_Contrato_U"; 
            var tipo = $('#tipo_u').val().split('-');

            $.ajax({
                type:"POST",
                url:url,
                data:{'alumno':tipo[1]},
                success:function (data) {
                    $('#div_filtro_u').show();
                    $('#select_grupo_u').html(data);
                    $('#select_especialidad_u').html('<select class="form-control" id="id_especialidad_u" name="id_especialidad_u"><option value="0">Todos</option></select>');
                    $('#select_turno_u').html('<select class="form-control" id="id_turno_u" name="id_turno_u"><option value="0">Todos</option></select>');
                    $('#select_modulo_u').html('<select class="form-control" id="id_modulo_u" name="id_modulo_u"><option value="0">Todos</option></select>');
                    $('#select_seccion_u').html('<select class="form-control" id="id_seccion_u" name="id_seccion_u"><option value="0">Todos</option></select>');
                    $('#div_alumno_u').hide();
                    $('#select_alumno_u').html('<select class="form-control" id="alumnos_u" name="alumnos_u"></select>');
                }
            });
        }

        if(tipo[2]==1){
            $('.mostrar_u').show();
        }else{
            $('.mostrar_u').hide();
            $('#fecha_envio_u').val('');
        }
    }

    function Traer_Especialidad_Contrato_U(){ 
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

        var url="<?php echo site_url(); ?>AppIFV/Traer_Especialidad_Contrato_U"; 
        var id_grupo = $('#id_grupo_u').val();
        var tipo = $('#tipo_u').val().split('-');

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grupo':id_grupo,'alumno':tipo[1]},
            success:function (data) {
                $('#select_especialidad_u').html(data);
                $('#select_turno_u').html('<select class="form-control" id="id_turno_u" name="id_turno_u"><option value="0">Todos</option></select>');
                $('#select_modulo_u').html('<select class="form-control" id="id_modulo_u" name="id_modulo_u"><option value="0">Todos</option></select>');
                $('#select_seccion_u').html('<select class="form-control" id="id_seccion_u" name="id_seccion_u"><option value="0">Todos</option></select>');
            }
        });
    }

    function Traer_Turno_Contrato_U(){
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

        var url="<?php echo site_url(); ?>AppIFV/Traer_Turno_Contrato_U"; 
        var id_grupo = $('#id_grupo_u').val();
        var id_especialidad = $('#id_especialidad_u').val();
        var tipo = $('#tipo_u').val().split('-'); 

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grupo':id_grupo,'id_especialidad':id_especialidad,'alumno':tipo[1]},
            success:function (data) {
                $('#select_turno_u').html(data);
                $('#select_modulo_u').html('<select class="form-control" id="id_modulo_u" name="id_modulo_u"><option value="0">Todos</option></select>');
                $('#select_seccion_u').html('<select class="form-control" id="id_seccion_u" name="id_seccion_u"><option value="0">Todos</option></select>');
            }
        });
    }

    function Traer_Modulo_Contrato_U(){
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

        var url="<?php echo site_url(); ?>AppIFV/Traer_Modulo_Contrato_U";
        var id_grupo = $('#id_grupo_u').val();
        var id_especialidad = $('#id_especialidad_u').val();
        var id_turno = $('#id_turno_u').val();
        var tipo = $('#tipo_u').val().split('-');

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grupo':id_grupo,'id_especialidad':id_especialidad,'id_turno':id_turno,'alumno':tipo[1]},
            success:function (data) {
                $('#select_modulo_u').html(data);
                $('#select_seccion_u').html('<select class="form-control" id="id_seccion_u" name="id_seccion_u"><option value="0">Todos</option></select>');
            }
        });
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

        var url="<?php echo site_url(); ?>AppIFV/Traer_Seccion_Contrato_U";
        var id_grupo = $('#id_grupo_u').val();
        var id_especialidad = $('#id_especialidad_u').val();
        var id_turno = $('#id_turno_u').val();
        var id_modulo = $('#id_modulo_u').val();
        var tipo = $('#tipo_u').val().split('-');

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grupo':id_grupo,'id_especialidad':id_especialidad,'id_turno':id_turno,'id_modulo':id_modulo,'alumno':tipo[1]},
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
        var url="<?php echo site_url(); ?>AppIFV/Update_C_Contrato";

        if (Valida_Update_C_Contrato()) { 
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if($('#estado_u').val()==2){
                        swal.fire(
                            '¡ATENCIÓN!',
                            'Si deseas enviar correos de inmediato usa la pantalla Contratos y haz “Actualizar lista”. Caso contrario el sistema envía automáticamente 3 veces al día en horario pre definido.',
                            'warning'
                        ).then(function() {
                            Lista_C_Contrato();
                            $("#acceso_modal_mod .close").click()
                        });
                    }else{
                        Lista_C_Contrato();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_C_Contrato() {
        var tipo = $('#tipo_u').val().split('-');

        if($('#tipo_u').val().trim() === '0') {
            Swal(
                'Ups!', 
                'Debe seleccionar Tipo.',
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
                'Debe seleccionar Mes/Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(tipo[2]==1){
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
        if($('#documento_actual').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Documento.',
                'warning'
            ).then(function() { });
            return false;
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