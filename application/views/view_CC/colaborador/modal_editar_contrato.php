<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title">Editar Contrato:</h5> 
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label> 
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_contrato_u" name="nom_contrato_u" placeholder="Ingresar Nombre" value="<?php echo $get_id[0]['nom_contrato']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_u" name="fecha_u" value="<?php echo $get_id[0]['fecha']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

         <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Contrato: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="archivo_u" name="archivo_u" onchange="validarExt_U();">
            </div>
        </div>  		           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $get_id[0]['archivo']; ?>">
        <input type="hidden" id="id_contrato" name="id_contrato" value="<?php echo $get_id[0]['id_contrato']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Contrato_Colaborador();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function validarExt_U(){
        var archivoInput = document.getElementById('archivo_u'); 
        var archivoRuta = archivoInput.value; 
        var extPermitidas = /(.pdf)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivo con extensión .pdf.",
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

    function Update_Contrato_Colaborador(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>CursosCortos/Update_Contrato_Colaborador";

        if (Valida_Update_Contrato_Colaborador()) {
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
                        Lista_Contrato();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Contrato_Colaborador() {
        if($('#nom_contrato_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
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