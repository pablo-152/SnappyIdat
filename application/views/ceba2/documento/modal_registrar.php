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

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Documento (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_documento_i" name="cod_documento_i" placeholder="Código" maxlength="3">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado_i" id="id_grado_i">
                    <option value="0">Todos</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['id_grado']; ?>"><?php echo $list['descripcion_grado']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_documento_i" name="nom_documento_i" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <input type="checkbox" class="grande_check" id="digital_i" name="digital_i" value="1">
                <label class="form-group text-bold label_check">Digital</label>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_documento_i" name="descripcion_documento_i" placeholder="Descripción">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Obligatorio:</label>
            </div>
            <div class="form-group col-md-3">
                <select class="form-control" name="obligatorio_i" id="obligatorio_i">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                    <option value="2">Mayores de 4 (>4)</option>
                    <option value="3">Menores de 18 (<18)</option>
                </select>
            </div>

            <div class="form-group col-md-7">
                <input type="checkbox" class="grande_check" id="aplicar_todos_i" name="aplicar_todos_i" value="1">
                <label class="form-group text-bold label_check">Aplicar a todos los alumnos (pasados y futuros)</label>
            </div>
        </div>  	
        
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <input type="checkbox" class="grande_check" id="validacion_i" name="validacion_i" value="1">
                <label class="form-group text-bold label_check" for="validacion_i">Validación</label>
            </div>
        </div>	
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Documento()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Documento(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Ceba2/Insert_Documento";

        if (Valida_Insert_Documento()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Documento();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Documento() {
        if($('#cod_documento_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_documento_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_documento_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>