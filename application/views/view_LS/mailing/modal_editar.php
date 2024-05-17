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
            <div class="form-group col-md-10">
                <select class="form-control multivalue_u" id="id_alumno_u" name="id_alumno_u[]" multiple="multiple">
                <?php foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['id_alumno']; ?>" <?php if(in_array($list['id_alumno'],array_column($list_envio, 'id_alumno'))){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['nom_alumno']; ?>
                        </option>
                    <?php } ?>
                </select>
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
                <label class="control-label text-bold">Día Envío:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control multivaluee" id="dia_envio_u" name="dia_envio_u[]" multiple="multiple">
                    <option value="1" <?php if(strpos($get_id[0]['dia_envio'],'1')!==false){ echo "selected"; } ?>>Lunes</option> 
                    <option value="2" <?php if(strpos($get_id[0]['dia_envio'],'2')!==false){ echo "selected"; } ?>>Martes</option> 
                    <option value="3" <?php if(strpos($get_id[0]['dia_envio'],'3')!==false){ echo "selected"; } ?>>Miércoles</option> 
                    <option value="4" <?php if(strpos($get_id[0]['dia_envio'],'4')!==false){ echo "selected"; } ?>>Jueves</option> 
                    <option value="5" <?php if(strpos($get_id[0]['dia_envio'],'5')!==false){ echo "selected"; } ?>>Viernes</option> 
                    <option value="6" <?php if(strpos($get_id[0]['dia_envio'],'6')!==false){ echo "selected"; } ?>>Sábado</option> 
                    <option value="7" <?php if(strpos($get_id[0]['dia_envio'],'7')!==false){ echo "selected"; } ?>>Domingo</option> 
                </select>
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
                <input type="file" id="documento_u" name="documento_u[]" multiple>
            </div>
        </div>

        <div class="col-md-12 row" style="margin-bottom: 15px !important;">
            <?php foreach($list_documento as $list) {  ?>
                <div id="i_<?php echo $list['id']; ?>" class="form-group col-md-12" style="margin-bottom: 0px !important;">
                    <label class="control-label text-bold"><?php echo $list['nom_documento']; ?></label>
                    <a title="Descargar" type="button" onclick="Descargar_Documento_Mailing('<?php echo $list['id']; ?>')" style="cursor:pointer;">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a title="Eliminar" type="button" onclick="Delete_Documento_Mailing('<?php echo $list['id']; ?>');" style="cursor:pointer;">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php } ?>
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
    $('.multivalue_u').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    $('.multivaluee').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Traer_Seccion_Mailing_U(){
        Cargando();

        var url="<?php echo site_url(); ?>LeadershipSchool/Traer_Seccion_Mailing";
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

    document.getElementById('documento_u').addEventListener('change', function() {
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

    function Descargar_Documento_Mailing(id){
        window.location.replace("<?php echo site_url(); ?>LeadershipSchool/Descargar_Documento_Mailing/"+id);
    }

    function Delete_Documento_Mailing(id){
        Cargando();

        var file_col = $('#i_'+id);

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>LeadershipSchool/Delete_Documento_Mailing',
            data: {'image_id': id},
            success: function (data) {
                file_col.remove();            
            }
        });
    }

    function Update_Mailing(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>LeadershipSchool/Update_Mailing";

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
        if($('#dia_envio_u option:selected').length === 0) {
            Swal(
                'Ups!',
                'Debe seleccionar al menos un día de envío.', 
                'warning'
            ).then(function() { });
            return false;
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
