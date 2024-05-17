<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Contrato:</h5> 
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Referencia: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" readonly value="<?php echo $get_id[0]['referencia'] ?>">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cargo: </label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_perfil_u" id="id_perfil_u" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_perfil as $list){?>
                        <option value="<?php echo $list['id_perfil']; ?>" 
                        <?php if($get_id[0]['id_perfil']==$list['id_perfil']){ echo "selected"; } ?>>
                            <?php echo $list['nom_perfil']; ?>
                        </option>    
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Inicio&nbsp;Funciones: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="inicio_funciones_u" name="inicio_funciones_u" value="<?php echo $get_id[0]['inicio_funciones']; ?>">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fin&nbsp;Funciones: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="fin_funciones_u" name="fin_funciones_u" value="<?php echo $get_id[0]['fin_funciones']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Inicio&nbsp;Contrato: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="inicio_contrato_u" name="inicio_contrato_u" value="<?php echo $get_id[0]['inicio_contrato']; ?>">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fin&nbsp;Contrato: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="fin_contrato_u" name="fin_contrato_u" value="<?php echo $get_id[0]['fin_contrato']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo&nbsp;Contrato&nbsp;1: </label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_tipo_contrato1_u" id="id_tipo_contrato1_u" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_contrato as $list){?> 
                        <option value="<?php echo $list['id']; ?>" 
                        <?php if($get_id[0]['id_tipo_contrato1']==$list['id']){ echo "selected"; } ?>>
                            <?php echo $list['nombre']; ?>
                        </option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sueldo: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="sueldo1_u" id="sueldo1_u" class="form-control" value="<?php echo $get_id[0]['sueldo1'] ?>" onkeypress="return soloNumeros(event)">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo&nbsp;Contrato&nbsp;2: </label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_tipo_contrato2_u" id="id_tipo_contrato2_u" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_contrato as $list){?> 
                        <option value="<?php echo $list['id']; ?>" 
                        <?php if($get_id[0]['id_tipo_contrato2']==$list['id']){ echo "selected"; } ?>>
                            <?php echo $list['nombre']; ?>
                        </option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sueldo: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="sueldo2_u" id="sueldo2_u" class="form-control" value="<?php echo $get_id[0]['sueldo2'] ?>" onkeypress="return soloNumeros(event)">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Contrato:
                <?php if($get_id[0]['archivo']!=""){ ?>
                        <a onclick="Descargar_Contrato_Colaborador('<?php echo $get_id[0]['id_contrato']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                <?php } ?>        
                </label>
            </div>
            <div class="form-group col-lg-10">
                <input type="file" id="archivo_u" name="archivo_u" onchange="validarExt_U();">
            </div>
        </div>

        <?php if($_SESSION['usuario'][0]['id_usuario']==1 && $_SESSION['usuario'][0]['id_nivel']==6){ ?>
            <div class="row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Estado: </label>
                </div>
                <div class="form-group col-lg-4">
                    <select name="estado_contrato_u" id="estado_contrato_u" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){?>
                            <option value="<?php echo $list['id_status']; ?>" 
                            <?php if($get_id[0]['estado_contrato']==$list['id_status']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status']; ?>
                            </option>    
                        <?php }?>
                    </select>
                </div>
            </div>
        <?php }else{ ?>
            <input type="hidden" id="estado_contrato_u" name="estado_contrato_u" value="<?= $get_id[0]['estado_contrato']; ?>">
        <?php } ?>
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
        var url="<?php echo site_url(); ?>Colaborador/Update_Contrato_Colaborador";

        var id_colaborador = $('#id_colaborador').val();
        dataString.append('id_colaborador', id_colaborador);

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
                            text: "¡Existe un contrato activo!",
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
        if($('#id_perfil_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Cargo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_contrato_u').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_contrato_u').val() == '3') {
            if($('#fin_contrato_u').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar fecha fin de contrato.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>