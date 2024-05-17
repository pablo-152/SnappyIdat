<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title"><b>Editar Aviso</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Perfil: </label>
                <select class="form-control" name="id_perfil_u" id="id_perfil_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_perfil as $list){ ?>
                        <option value="<?php echo $list['id_nivel']; ?>" <?php if($list['id_nivel']==$get_id[0]['id_perfil']){ echo "selected"; } ?>>
                            <?php echo $list['nom_nivel']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Fecha: </label>
                <select class="form-control" name="id_fecha_u" id="id_fecha_u">
                    <option value="0" <?php if($get_id[0]['id_fecha']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_fecha']==1){ echo "selected"; } ?>>Diario</option>
                    <option value="2" <?php if($get_id[0]['id_fecha']==2){ echo "selected"; } ?>>Semanal</option>
                    <option value="3" <?php if($get_id[0]['id_fecha']==3){ echo "selected"; } ?>>Quincenal</option>
                    <option value="4" <?php if($get_id[0]['id_fecha']==4){ echo "selected"; } ?>>Mensual</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Tipo: </label>
                <input type="text" class="form-control" id="tipo_u" name="tipo_u" placeholder="Ingresar Tipo" value="<?php echo $get_id[0]['tipo']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Acción: </label>
                <select class="form-control" name="id_accion_u" id="id_accion_u">
                    <option value="0" <?php if($get_id[0]['id_accion']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_accion']==1){ echo "selected"; } ?>>Alerta</option>
                    <option value="2" <?php if($get_id[0]['id_accion']==2){ echo "selected"; } ?>>Aviso</option>
                    <option value="3" <?php if($get_id[0]['id_accion']==3){ echo "selected"; } ?>>Recordatorio</option>
                </select>
            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Mensaje: </label>
                <input type="text" class="form-control" id="mensaje_u" name="mensaje_u" placeholder="Ingresar Mensaje" value="<?php echo $get_id[0]['mensaje']; ?>">
            </div>
            
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Link: </label>
                <input type="text" class="form-control" id="link_u" name="link_u" placeholder="Ingresar Link" value="<?php echo $get_id[0]['link']; ?>">
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer"> 
        <input type="hidden" id="id_aviso" name="id_aviso" value="<?php echo $get_id[0]['id_aviso']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Aviso();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>


<script>
    function Update_Aviso(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>General/Update_Aviso";

        if (Valida_Update_Aviso()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    Cargar_Nav();
                    Lista_Aviso();
                    $("#acceso_modal_mod .close").click()
                }
            });
        }    
    }

    function Valida_Update_Aviso() {
        if($('#id_perfil_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_fecha_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_accion_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Acción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mensaje_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Mensaje.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

