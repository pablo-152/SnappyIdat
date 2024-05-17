<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Mailing (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="codigo_i" name="codigo_i" placeholder="Código">
            </div>
        </div>

        <div class="col-md-12 row">            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno(s):</label> 
            </div>
            <div class="form-group col-md-8">
                <select class="form-control multivalue_i" id="id_alumno_i" name="id_alumno_i[]" multiple="multiple">
                    <?php foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['id_alumno']; ?>"><?php echo $list['nom_alumno']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <input id="alumno_i" name="alumno_i" type="checkbox" value="1">
                <label class="control-label text-bold">Todos</label>
            </div>
        </div>

        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grupo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="grupo_i" name="grupo_i" onchange="Traer_Especialidad_Mailing_I();">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_grupo as $list){ ?>
                        <option value="<?php echo $list['Grupo']; ?>"><?php echo $list['Grupo']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="especialidad_i" name="especialidad_i" onchange="Traer_Turno_Mailing_I();">
                    <option value="Todos">Todos</option>
                </select>
            </div>
        </div>   

        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="turno_i" name="turno_i" onchange="Traer_Modulo_Mailing_I();">
                    <option value="Todos">Todos</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Módulo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="modulo_i" name="modulo_i">
                    <option value="Todos">Todos</option>
                </select>
            </div>
        </div>   

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Envío por:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="tipo_envio_i" name="tipo_envio_i" onchange="Tipo_Envio_I();">
                    <option value="0">Seleccione</option> 
                    <option value="1">Matricula</option> 
                    <option value="2">Fecha</option> 
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
                <label class="control-label text-bold">Título mailing:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Título">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Texto mailing:</label>
                <textarea class="form-control" id="texto_i" name="texto_i" placeholder="Texto" rows="5"></textarea>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="file" id="documento_i" name="documento_i" onchange="Validar_Extension_I();">
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_m_i" name="estado_m_i" onchange="Tipo_Contrato_I();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==2){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>  
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Mailing()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue_i").select2({
        tags: true
    });

    $('.multivalue_i').select2({
        dropdownParent: $('#acceso_modal') 
    });

    $(document).ready(function() {
        Tipo_Envio_I();
    });

    function Tipo_Envio_I(){
        if($('#tipo_envio_i').val()==2){
            $('.mostrar_i').show();
        }else{
            $('.mostrar_i').hide();
            $('#fecha_envio_i').val('');
        }
    }

    function Traer_Especialidad_Mailing_I(){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Traer_Especialidad_Mailing";
        var grupo = $('#grupo_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grupo':grupo},
            success:function (data) {
                $('#especialidad_i').html(data);
                $('#turno_i').html('<option value="Todos">Todos</option>');
                $('#modulo_i').html('<option value="Todos">Todos</option>');
            }
        });
    }

    function Traer_Turno_Mailing_I(){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Traer_Turno_Mailing";
        var grupo = $('#grupo_i').val();
        var especialidad = $('#especialidad_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grupo':grupo,'especialidad':especialidad},
            success:function (data) {
                $('#turno_i').html(data);
                $('#modulo_i').html('<option value="Todos">Todos</option>');
            }
        });
    }

    function Traer_Modulo_Mailing_I(){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Traer_Modulo_Mailing";
        var grupo = $('#grupo_i').val();
        var especialidad = $('#especialidad_i').val();
        var turno = $('#turno_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grupo':grupo,'especialidad':especialidad,'turno':turno},
            success:function (data) {
                $('#modulo_i').html(data);
            }
        });
    }

    function Validar_Extension_I(){
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

    function Insert_Mailing(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Mailing";

        if (Valida_Insert_Mailing()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) { 
                    Lista_Mailing();
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_Mailing() {
        if($('#codigo_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_envio_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo de envío.', 
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_envio_i').val()==2){
            if($('#fecha_envio_i').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar fecha de envío.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#titulo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar título.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#texto_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar texto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_m_i').val().trim() === '0') {
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
