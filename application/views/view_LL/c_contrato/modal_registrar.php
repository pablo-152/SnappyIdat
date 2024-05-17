<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Contrato (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label> 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_i" name="tipo_i" onchange="Tipo_Contrato_I();">
                    <option value="0">Seleccione</option> 
                    <option value="1">Contrato (Matricula)</option>
                    <option value="2">Contrato (Pago Cuota)</option>
                    <option value="3">Contrato (Pago Matricula)</option>
                    <option value="4">Contrato (Puntual)</option>
                    <option value="5">Mensaje</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ref:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="referencia_i" name="referencia_i" maxlength="5" placeholder="Ref">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mes/Año:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="mes_anio_i" name="mes_anio_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ 
                        foreach($list_mes as $mes){ ?>
                            <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>">
                                <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 mostrar_i">
                <label class="control-label text-bold">Fec. Envío:</label>
            </div>
            <div class="form-group col-md-4 mostrar_i">
                <input type="date" class="form-control" id="fecha_envio_i" name="fecha_envio_i">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripción">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Asunto:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="asunto_i" name="asunto_i" placeholder="Asunto">
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
                <select class="form-control" id="id_grado_i" name="id_grado_i" onchange="Traer_Seccion_Contrato_I();">
                    <option value="0">Todos</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['Grado']; ?>"><?php echo $list['Grado']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 mostrar_i">
                <label class="control-label text-bold">Sección:</label>
            </div>
            <div id="select_seccion_i" class="form-group col-md-4 mostrar_i">
                <select class="form-control" id="id_seccion_i" name="id_seccion_i">
                    <option value="0">Todos</option>
                </select>
            </div>
        </div>   

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Texto Correo:</label> 
                <textarea class="form-control" id="texto_correo_i" name="texto_correo_i" placeholder="Texto Correo" rows="5"></textarea> 
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <input type="checkbox" id="sms_i" name="sms_i" value="1" onclick="Habilitar_Sms_I();">
                <label class="control-label text-bold">SMS</label>
                <textarea class="form-control mostrar_sms_i" id="texto_sms_i" name="texto_sms_i" placeholder="SMS" rows="2" maxlength="160"></textarea>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label>
                <input type="file" id="documento_i" name="documento_i" onchange="validarExt_I();">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_C_Contrato()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.mostrar_i').hide();
        $('.mostrar_sms_i').hide();
    });

    function Tipo_Contrato_I(){
        if($('#tipo_i').val()==5){
            $('.mostrar_i').show();
        }else{
            $('.mostrar_i').hide();
            $('#id_seccion_i').val('0');
        }
    }

    function Traer_Seccion_Contrato_I(){
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

        var url="<?php echo site_url(); ?>LittleLeaders/Traer_Seccion_Contrato_I";
        var id_grado = $('#id_grado_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grado':id_grado},
            success:function (data) {
                $('#select_seccion_i').html(data);
            }
        });
    }

    function Habilitar_Sms_I(){
        if($('#sms_i').is(':checked')) {
            $('.mostrar_sms_i').show();
        }else{
            $('.mostrar_sms_i').hide();
            $('#texto_sms_i').val('');
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

    function Insert_C_Contrato(){
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
        var url="<?php echo site_url(); ?>LittleLeaders/Insert_C_Contrato";

        if (Valida_Insert_C_Contrato()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_C_Contrato();
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_C_Contrato() {
        if($('#tipo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Tipo.', 
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#referencia_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Ref.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mes_anio_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Mes/Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_i').val()==5){
            if($('#fecha_envio_i').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Fecha Envío.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#asunto_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Asunto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#texto_correo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Texto Correo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#documento_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
