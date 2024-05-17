<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title"><b>Aviso (Nuevo)</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Perfil: </label>
                <select class="form-control" name="id_perfil_i" id="id_perfil_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_perfil as $list){ ?>
                        <option value="<?php echo $list['id_nivel']; ?>"><?php echo $list['nom_nivel']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Fecha: </label>
                <select class="form-control" name="id_fecha_i" id="id_fecha_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Diario</option>
                    <option value="2">Semanal</option>
                    <option value="3">Quincenal</option>
                    <option value="4">Mensual</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Tipo: </label>
                <input type="text" class="form-control" id="tipo_i" name="tipo_i" placeholder="Ingresar Tipo">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Acción: </label>
                <select class="form-control" name="id_accion_i" id="id_accion_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Alerta</option>
                    <option value="2">Aviso</option>
                    <option value="3">Recordatorio</option>
                </select>
            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Mensaje: </label>
                <input type="text" class="form-control" id="mensaje_i" name="mensaje_i" placeholder="Ingresar Mensaje">
            </div>
            
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Link: </label>
                <input type="text" class="form-control" id="link_i" name="link_i" placeholder="Ingresar Link">
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Aviso();"> 
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Aviso(){
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

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>General/Insert_Aviso";

        if (Valida_Insert_Aviso()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    Cargar_Nav();
                    Lista_Aviso();
                    $("#acceso_modal .close").click()
                }
            });
        }    
    }

    function Valida_Insert_Aviso() {
        if($('#id_perfil_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_fecha_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_accion_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Acción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mensaje_i').val().trim() === '') {
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
