<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Contrato (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Referencia: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="referencia_i" name="referencia_i" readonly value="<?php echo $get_colab[0]['codigo_gll']."_".$get_cant[0]['cantidad'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cargo: </label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_perfil_i" id="id_perfil_i" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_perfil as $list){?>
                    <option value="<?php echo $list['id_perfil'] ?>"><?php echo $list['nom_perfil'] ?></option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold" title="Inicio de Funciones">Ini&nbsp;Func: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_funciones_i" name="inicio_funciones_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold" title="Fin de Funciones">Fin&nbsp;Func: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_funciones_i" name="fin_funciones_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo&nbsp;Contrato&nbsp;1: </label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_tipo_contrato1_i" id="id_tipo_contrato1_i" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_contrato as $list){?> 
                    <option value="<?php echo $list['id'] ?>"><?php echo $list['nombre'] ?></option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sueldo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="sueldo1_i" id="sueldo1_i" class="form-control" onkeypress="return soloNumeros(event)">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo&nbsp;Contrato&nbsp;2: </label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_tipo_contrato2_i" id="id_tipo_contrato2_i" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_contrato as $list){?> 
                    <option value="<?php echo $list['id'] ?>"><?php echo $list['nombre'] ?></option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sueldo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="sueldo2_i" id="sueldo2_i" class="form-control" onkeypress="return soloNumeros(event)">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Contrato: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="file" id="archivo_i" name="archivo_i" onchange="validarExt_I();">
            </div>

            <div class="form-group col-md-12">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select name="estado_contrato_i" id="estado_contrato_i" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){?>
                    <option value="<?php echo $list['id_status'] ?>" ><?php echo $list['nom_status'] ?></option>    
                    <?php }?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_colaborador_i" name="id_colaborador_i" value="<?php echo $id_colaborador; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Contrato_Colaborador();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function validarExt_I(){
        var archivoInput = document.getElementById('archivo_i'); 
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

    function Insert_Contrato_Colaborador(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Contrato_Colaborador";

        if (Valida_Insert_Contrato_Colaborador()) {
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
                            text: "¡Existe un contrato activo!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Contrato();  
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Contrato_Colaborador() {
        if($('#id_perfil_i').val()== '0') {
            Swal(
                'Ups!',
                'Debe seleccionar cargo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_contrato_i').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_contrato_i').val() == '3') {
            if($('#fin_funciones_i').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar fecha fin de funciones.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>
