<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Mailing</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="codigo_u" name="codigo_u" placeholder="Código" value="<?php echo $get_id[0]['codigo']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno(s):</label> 
            </div>
            <div class="form-group col-md-8">
                <select class="form-control multivalue_u" id="id_alumno_u" name="id_alumno_u[]" multiple="multiple">
                <?php foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['id_alumno']; ?>" <?php if(in_array($list['id_alumno'],array_column($list_envio, 'id_alumno'))){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['nom_alumno']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <input id="alumno_u" name="alumno_u" type="checkbox" value="1" <?php if($get_id[0]['alumno']==1){ echo "checked"; } ?>>
                <label class="control-label text-bold">Todos</label>
            </div>
        </div>

        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="grado_u" name="grado_u" onchange="Traer_Seccion_Mailing_U();">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['nom_grado']; ?>" <?php if($list['nom_grado']==$get_id[0]['grado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_grado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sección:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="seccion_u" name="seccion_u">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_seccion as $list){ ?>
                        <option value="<?php echo $list['nom_seccion']; ?>" <?php if($list['nom_seccion']==$get_id[0]['seccion']){ echo "selected"; } ?>>
                            <?php echo $list['nom_seccion']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>   

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Envío por:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_envio_u" name="tipo_envio_u" onchange="Tipo_Envio_U();">
                    <option value="0">Seleccione</option> 
                    <option value="1" <?php if($get_id[0]['tipo_envio']==1){ echo "selected"; } ?>>Matricula</option> 
                    <option value="2" <?php if($get_id[0]['tipo_envio']==2){ echo "selected"; } ?>>Fecha</option> 
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
                <label class="control-label text-bold">Título mailing:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="titulo_u" name="titulo_u" placeholder="Título" value="<?php echo $get_id[0]['titulo']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Texto mailing:</label>
                <textarea class="form-control" id="texto_u" name="texto_u" placeholder="Texto" rows="5"><?php echo $get_id[0]['texto']; ?></textarea>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="file" id="documento_u" name="documento_u" onchange="Validar_Extension_U();">
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4"> 
                <select class="form-control" id="estado_m_u" name="estado_m_u" onchange="Tipo_Contrato_U();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado_m']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>  
    </div>
    
    <div class="modal-footer">
        <input type="hidden" id="id_mailing" name="id_mailing" value="<?php echo $get_id[0]['id_mailing']; ?>">
        <input type="hidden" id="documento_actual" name="documento_actual" value="<?php echo $get_id[0]['documento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Mailing()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue_u").select2({
        tags: true
    });

    $('.multivalue_u').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    $(document).ready(function() {
        Tipo_Envio_U();
    });

    function Tipo_Envio_U(){
        if($('#tipo_envio_u').val()==2){
            $('.mostrar_u').show();
        }else{
            $('.mostrar_u').hide();
            $('#fecha_envio_u').val('');
        }
    }

    function Traer_Seccion_Mailing_U(){
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

        var url="<?php echo site_url(); ?>BabyLeaders/Traer_Seccion_Mailing";
        var grado = $('#grado_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grado':grado},
            success:function (data) {
                $('#seccion_u').html(data);
            }
        });
    }

    function Validar_Extension_U(){
        var archivoInput = document.getElementById('documento_u'); 
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

    function Update_Mailing(){
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
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Mailing";

        if (Valida_Update_Mailing()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) { 
                    Lista_Mailing();
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }

    function Valida_Update_Mailing() {
        if($('#codigo_u').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_envio_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo de envío.', 
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_envio_u').val()==2){
            if($('#fecha_envio_u').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar fecha de envío.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#titulo_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar título.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#texto_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar texto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_m_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
