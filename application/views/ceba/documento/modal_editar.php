<style>
    .grande_check{
        width: 20px;
        height: 20px;
        margin: 0 10px 0 0 !important;
    }

    .label_check{
        position: relative;
        top: -4px;
    }
</style>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Documento</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_documento_u" name="cod_documento_u" placeholder="Código" maxlength="3" value="<?php echo $get_id[0]['cod_documento']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado_u" id="id_grado_u">
                    <option value="0">Todos</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['nom_grado']){ echo "selected"; } ?>>
                            <?php echo $list['descripcion_grado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>


            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_documento_u" name="nom_documento_u" placeholder="Nombre" value="<?php echo $get_id[0]['nom_documento']; ?>">
            </div>

            <div class="form-group col-md-2">
                <input type="checkbox" class="grande_check" id="digital_u" name="digital_u" value="1" <?php if($get_id[0]['digital']==1){ echo "checked"; } ?>>
                <label class="form-group text-bold label_check">Digital</label>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_documento_u" name="descripcion_documento_u" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion_documento']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Obligatorio:</label>
            </div>
            <div class="form-group col-md-3">
                <select class="form-control" name="obligatorio_u" id="obligatorio_u">
                    <option value="0" <?php if($get_id[0]['obligatorio']==0){ echo "selected"; } ?>>No</option>
                    <option value="1" <?php if($get_id[0]['obligatorio']==1){ echo "selected"; } ?>>Si</option>
                    <option value="2" <?php if($get_id[0]['obligatorio']==2){ echo "selected"; } ?>>Mayores de 4 (>4)</option>
                    <option value="3" <?php if($get_id[0]['obligatorio']==3){ echo "selected"; } ?>>Menores de 18 (<18)</option>
                </select>
            </div>

            <div class="form-group col-md-7">
                <input type="checkbox" class="grande_check" id="aplicar_todos_u" name="aplicar_todos_u" value="1" <?php if($get_id[0]['aplicar_todos']==1){ echo "checked"; } ?>>
                <label class="form-group text-bold label_check">Aplicar a todos los alumnos (pasados y futuros)</label>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_status as $list){?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <input type="checkbox" class="grande_check" id="validacion_u" name="validacion_u" value="1" <?php if($get_id[0]['validacion']=="1"){ echo "checked"; } ?>>
                <label class="form-group text-bold label_check" for="validacion_u">Validación</label>
            </div>
        </div>  		           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_documento" name="id_documento" value="<?php echo $get_id[0]['id_documento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Documento()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Documento(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Ceba/Update_Documento";

        if (Valida_Update_Documento()) {
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
                        Lista_Documento();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Documento() {
        if($('#cod_documento_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_documento_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_documento_u').val().trim() === '') {
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
</script>