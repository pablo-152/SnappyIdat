<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Tipo Contrato (Nuevo) </b></h5>
    </div>
 
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_empresa" id="id_empresa" class="form-control" onchange="Traer_Sede_Rrhh();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?= $list['id_empresa']; ?>"><?= $list['cod_empresa']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sede:</label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_sede" id="id_sede" class="form-control">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresar Código">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Ingresar Tipo">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sub-Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="subtipo" id="subtipo" placeholder="Ingresar Sub-Tipo">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-lg-5">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar Nombre">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-3">
                <select class="form-control" name="id_tipo" id="id_tipo">
                    <option value="0">Seleccione</option>    
                    <option value="1">Fijo</option>
                    <option value="2">Por Horas</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_estado" id="id_estado">
                    <?php foreach($list_estado as $item) {?>
                        <option value="<?php echo $item['id_status']; ?>" <?php if ($item['id_status'] == 2) echo 'selected'; ?>>
                            <?php echo $item['nom_status']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>
        </div>	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Tipo_Contrato_RRHH();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Traer_Sede_Rrhh(){
        Cargando();

        var id_empresa = $('#id_empresa').val();
        var url="<?php echo site_url(); ?>General/Traer_Sede_Rrhh";
        
        $.ajax({
            url: url,
            data:{'id_empresa':id_empresa},
            type:"POST",
            success:function (data) {
                $('#id_sede').html(data);
            }
        });
    }

    $(document).ready(function() {
        activateEnterKeyForFunction(Insert_Tipo_Contrato_RRHH);
    });  
    function Insert_Tipo_Contrato_RRHH(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>General/Insert_Tipo_Contrato_RRHH";

        if (Valida_Insert_Tipo_Contrato_RRHH()) {
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
                        List_Tipo_Contrato();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Tipo_Contrato_RRHH() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una sede.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_estado').val().trim() === '0') {
            $('#id_estado').val('2');
        }
        if($('#id_tipo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombre').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
