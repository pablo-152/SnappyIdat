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
                <label class="control-label text-bold">Grupo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="grupo_u" name="grupo_u" onchange="Traer_Especialidad_Mailing_U();"> 
                    <option value="Todos">Todos</option>
                    <?php foreach($list_grupo as $list){ ?>
                        <option value="<?php echo $list['Grupo']; ?>" <?php if($list['Grupo']==$get_id[0]['grupo']){ echo "selected"; } ?>>
                            <?php echo $list['Grupo']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="especialidad_u" name="especialidad_u" onchange="Traer_Turno_Mailing_U();">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_especialidad as $list){ ?> 
                        <option value="<?php echo $list['Especialidad']; ?>" <?php if($list['Especialidad']==$get_id[0]['especialidad']){ echo "selected"; } ?>>
                            <?php echo $list['Especialidad']; ?>
                        </option>
                    <?php } ?> 
                </select>
            </div>
        </div>   

        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="turno_u" name="turno_u" onchange="Traer_Modulo_Mailing_U();">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_turno as $list){ ?> 
                        <option value="<?php echo $list['Turno']; ?>" <?php if($list['Turno']==$get_id[0]['turno']){ echo "selected"; } ?>>
                            <?php echo $list['Turno']; ?>
                        </option>
                    <?php } ?> 
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Módulo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="modulo_u" name="modulo_u">
                    <option value="Todos">Todos</option>
                    <?php foreach($list_modulo as $list){ ?> 
                        <option value="<?php echo $list['Modulo']; ?>" <?php if($list['Modulo']==$get_id[0]['modulo']){ echo "selected"; } ?>>
                            <?php echo $list['Modulo']; ?>
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

    function Traer_Especialidad_Mailing_U(){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Traer_Especialidad_Mailing";
        var grupo = $('#grupo_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grupo':grupo},
            success:function (data) {
                $('#especialidad_u').html(data);
                $('#turno_u').html('<option value="Todos">Todos</option>');
                $('#modulo_u').html('<option value="Todos">Todos</option>');
            }
        });
    }

    function Traer_Turno_Mailing_U(){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Traer_Turno_Mailing";
        var grupo = $('#grupo_u').val();
        var especialidad = $('#especialidad_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grupo':grupo,'especialidad':especialidad},
            success:function (data) {
                $('#turno_u').html(data);
                $('#modulo_u').html('<option value="Todos">Todos</option>');
            }
        });
    }

    function Traer_Modulo_Mailing_U(){ 
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Traer_Modulo_Mailing";
        var grupo = $('#grupo_u').val();
        var especialidad = $('#especialidad_u').val();
        var turno = $('#turno_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'grupo':grupo,'especialidad':especialidad,'turno':turno},
            success:function (data) {
                $('#modulo_u').html(data);
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
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Mailing";

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
