<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Tipo Contrato (Editar) </b></h5>
    </div>
 
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_empresae" id="id_empresae" class="form-control" onchange="Traer_Sede_Rrhhe();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?= $list['id_empresa']; ?>" 
                        <?php if($list['id_empresa']==$tipo_contrato[0]['id_empresa']){ echo "selected"; } ?>>
                            <?= $list['cod_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sede:</label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_sedee" id="id_sedee" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_sede as $list){ ?>
                        <option value="<?= $list['id_sede']; ?>" 
                        <?php if($list['id_sede']==$tipo_contrato[0]['id_sede']){ echo "selected"; } ?>>
                            <?= $list['cod_sede']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="codigoe" id="codigoe" placeholder="Ingresar Código" value="<?= $tipo_contrato[0]['codigo']; ?>">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="tipoe" id="tipoe" placeholder="Ingresar Tipo" value="<?= $tipo_contrato[0]['tipo']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sub-Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="subtipoe" id="subtipoe" placeholder="Ingresar Sub-Tipo" value="<?= $tipo_contrato[0]['subtipo']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="nombre_e" name="nombre_e"
                placeholder="Ingresar Nombre" value="<?= $tipo_contrato[0]['nombre']?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_estado_e" id="id_estado_e">
                    <?php foreach($list_estado as $item){ ?>
                        <option value="<?php echo $item['id_status']; ?>" <?php if($item['id_status']==$tipo_contrato[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $item['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_tipo_contrato_e" name="id_tipo_contrato_e" value="<?= $tipo_contrato[0]['id']?>">
        <button type="button" class="btn btn-primary" onclick="Update_Tipo_Contrato_RRHH();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Traer_Sede_Rrhhe(){
        Cargando();

        var id_empresa = $('#id_empresae').val();
        var url="<?php echo site_url(); ?>General/Traer_Sede_Rrhh";
        
        $.ajax({
            url: url,
            data:{'id_empresa':id_empresa},
            type:"POST",
            success:function (data) {
                $('#id_sedee').html(data);
            }
        });
    }

    $(document).ready(function() {
        activateEnterKeyForFunction(Update_Tipo_Contrato_RRHH);
    });

    function Update_Tipo_Contrato_RRHH(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>General/Update_Tipo_Contrato_RRHH";

        if (Valida_Update_Tipo_Contrato_RRHH()) {
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
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Tipo_Contrato_RRHH() {
        if($('#id_empresae').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sedee').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una sede.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombre_e').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_estado_e').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>