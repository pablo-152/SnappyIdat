<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Documento</b></h5> 
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-md-6">
                <select class="form-control" id="id_empresa_u" name="id_empresa_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                            <?php echo $list['cod_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="file" id="documento_u" name="documento_u" onchange="Validar_Extension_U();">
            </div>

            <?php if($get_id[0]['documento']!=""){ ?>
            <div id="i_1" class="col-md-5">
                <label class="text-bold">Descargar/Eliminar:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo_Soporte_Doc('<?php echo $get_id[0]['id_soporte_doc']; ?>')">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
                <a style="cursor:pointer;" class="delete" type="button" onclick="Delete_Archivo_Soporte_Doc('<?php echo $get_id[0]['id_soporte_doc']; ?>');">
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
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Visible:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="visible_u" name="visible_u" value="1" style="width:20px;height:20px;" <?php if($get_id[0]['visible']==1){ echo "checked"; } ?>>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_soporte_doc" name="id_soporte_doc" value="<?php echo $get_id[0]['id_soporte_doc']; ?>">
        <input type="hidden" id="documento_actual" name="documento_actual" value="<?php echo $get_id[0]['documento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Soporte_Doc()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Validar_Extension_U(){
        var archivoInput = document.getElementById('documento_u');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.png|.pdf|.mp4)$/i;

        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivos con extensiones .png, .pdf y .mp4.",
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

    function Update_Soporte_Doc(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>General/Update_Soporte_Doc";
        var tipo_excel=$('#tipo_excel').val();

        if (Valida_Update_Soporte_Doc()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Soporte_Doc(tipo_excel);
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Soporte_Doc() {
        if($('#id_empresa_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
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

    function Descargar_Archivo_Soporte_Doc(id){
        window.location.replace("<?php echo site_url(); ?>General/Descargar_Archivo_Soporte_Doc/"+id);
    }
    
    function Delete_Archivo_Soporte_Doc(id){
        Cargando();

        var image_id = id;
        var file_col = $('#i_1');

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>General/Delete_Archivo_Soporte_Doc',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    }
</script>