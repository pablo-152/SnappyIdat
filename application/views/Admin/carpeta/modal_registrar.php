<form id="formulario_insert_carpeta" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Carpetas (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold" title="Nombre">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_carpeta_i" name="nom_carpeta_i" placeholder="Nombre">
            </div>
        </div>  
        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold" title="Del&nbsp;Número">Del&nbsp;Nro:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="inicio_carpeta_i" name="inicio_carpeta_i" maxlength="5" onKeyPress="permitirSoloNumeros(event)" placeholder="Del&nbsp;Número">
            </div>

            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold" title="Al&nbsp;Número">Al&nbsp;Nro:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="fin_carpeta_i" name="fin_carpeta_i" maxlength="5" onKeyPress="permitirSoloNumeros(event)" placeholder="Al&nbsp;Número">
            </div>
        </div>  
        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold" title="Bloqueado">Bloqueado:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" class="grande_check" id="bloqueo_carpeta_i" name="bloqueo_carpeta_i" value="1">
            </div>

            <div class="form-group col-md-2 text-right">
                <label class="control-label text-bold" title="Estado">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_i" name="estado_i">
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
        <button type="button" class="btn btn-primary" onclick="Insert_Capeta();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Capeta(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert_carpeta'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Carpeta";

        if (Valida_Insert_Capeta()) {
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
                        Lista_Carpetas();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Capeta() {
        if($('#nom_carpeta_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_carpeta_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar el Inicio de la carpeta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#inicio_carpeta_i').val().length > '5'){
            Swal(
                'Ups!',
                'Máximo son 5 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_carpeta_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar el Fin de la carpeta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#fin_carpeta_i').val().length > '5'){
            Swal(
                'Ups!',
                'Máximo son 5 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#fin_carpeta_i').val() < $('#inicio_carpeta_i').val()){
            Swal(
                'Ups!',
                'El campos "Del Nro" tiene que ser menor al campo "Al Nro".',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_i').val().trim() === '0') {
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
