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
            <div class="form-group col-md-10">
                <select class="form-control multivalue_i" id="id_alumno_i" name="id_alumno_i[]" multiple="multiple">
                    <?php foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['id_alumno']; ?>"><?php echo $list['nom_alumno']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="grado_i" name="grado_i" onchange="Traer_Seccion_Mailing_I();">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['nom_grado']; ?>"><?php echo $list['nom_grado']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold">Sección:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="seccion_i" name="seccion_i">
                    <option value="Todos">Todos</option>
                </select>
            </div>
        </div>   

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Día Envío:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control multivalue" id="dia_envio_i" name="dia_envio_i[]" multiple="multiple">
                    <option value="1">Lunes</option> 
                    <option value="2">Martes</option> 
                    <option value="3">Miércoles</option> 
                    <option value="4">Jueves</option> 
                    <option value="5">Viernes</option> 
                    <option value="6">Sábado</option> 
                    <option value="7">Domingo</option> 
                </select>
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
                <input type="file" id="documento_i" name="documento_i[]" multiple>
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_m_i" name="estado_m_i"><!-- onchange="Tipo_Contrato_I();"-->
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
    $('.multivalue_i').select2({
        dropdownParent: $('#acceso_modal')
    });

    $('.multivalue').select2({
        dropdownParent: $('#acceso_modal')
    });

    function Traer_Seccion_Mailing_I(){ 
        Cargando();

        var url="<?php echo site_url(); ?>LeadershipSchool/Traer_Seccion_Mailing";
        var grado = $('#grado_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grado':grado},
            success:function (data) {
                $('#seccion_i').html(data);
            }
        });
    }

    document.getElementById('documento_i').addEventListener('change', function() {
        var input = this;
        var isValid = true;

        for (var i = 0; i < input.files.length; i++) {
            var fileName = input.files[i].name;
            var extension = fileName.split('.').pop().toLowerCase();

            if (extension !== 'pdf') {
                isValid = false;
                break;
            }
        }

        if (!isValid) {
            Swal({
                title: 'Registro Denegado',
                text: "Por favor, selecciona solo archivos PDF.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });

            input.value = '';
        }
    });

    function Insert_Mailing(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>LeadershipSchool/Insert_Mailing";

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
        if($('#dia_envio_i option:selected').length === 0) {
            Swal(
                'Ups!',
                'Debe seleccionar al menos un día de envío.', 
                'warning'
            ).then(function() { });
            return false;
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
