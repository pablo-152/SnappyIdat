<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Bono (Editar) </b></h5>
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
                        <?php if($list['id_empresa']==$bono[0]['id_empresa']){ echo "selected"; } ?>>
                            <?= $list['cod_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sede:</label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_sedee" id="id_sedee" class="form-control" onchange="Traer_Tipo_Contrato_Rrhhe();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_sede as $list){ ?>
                        <option value="<?= $list['id_sede']; ?>" 
                        <?php if($list['id_sede']==$bono[0]['id_sede']){ echo "selected"; } ?>>
                            <?= $list['cod_sede']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo Contrato:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_contratoe" id="id_tipo_contratoe">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_contrato as $list){ ?>
                        <option value="<?= $list['id']; ?>" 
                        <?php if($list['id']==$bono[0]['id_tipo_contrato']){ echo "selected"; } ?>>
                            <?= $list['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="codigoe" id="codigoe" placeholder="Ingresar Código" value="<?= $bono[0]['codigo']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="tipoe" id="tipoe" placeholder="Ingresar Tipo" value="<?= $bono[0]['tipo']; ?>">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sub-Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="subtipoe" id="subtipoe" placeholder="Ingresar Sub-Tipo" value="<?= $bono[0]['subtipo']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Tipo de bono:</label>
            </div>
            <div class="form-group col-lg-9">
                <select class="form-control" name="tipo_bono_e" id="tipo_bono_e">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if ($bono[0]['tipo_bono'] == 1) echo "selected"; ?>>Alimentar</option>
                    <option value="2" <?php if ($bono[0]['tipo_bono'] == 2) echo "selected"; ?>>Movilidad</option>
                </select>
            </div>   
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-lg-9">
                <input type="text" class="form-control" id="nombre_e" name="nombre_e" value="<?= $bono[0]['nombre']?>" placeholder="Ingresar Nombre">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Tipo de descuento:</label>
            </div>
            <div class="form-group col-lg-9">
                <select class="form-control tipo-descuento-select" name="tipo_descuento_e" id="tipo_descuento_e">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if ($bono[0]['tipo_descuento'] == 1) echo "selected"; ?>>%</option>
                    <option value="2" <?php if ($bono[0]['tipo_descuento'] == 2) echo "selected"; ?>>Fijo</option>
                </select>
            </div>  	
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Monto:</label>
            </div>
            <div class="form-group col-lg-9">
            <input type="text"
                pattern="^\d+(\.\d{1,2})?$"
                oninput="this.value = this.value.replace(/[^\d.]/g, '');"
                value="<?= $bono[0]['monto']?>"
                onblur="if(this.value=='') this.value='0';"
                onfocus="if(this.value=='0') this.value='';"
                class="form-control monto-input"
                id="monto_e"
                name="monto_e"
                placeholder="Ingresar monto"
                style="text-align:right; padding-right:20px;"
                autocomplete="off">
                <span class="monto-simbolo" style="position: absolute; left: 30px; top: 9px;">
                    <?php echo ($bono[0]['tipo_descuento'] == 1) ? "%" : "S/."; ?>
                </span>
            </div>   
        </div> 

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_estado_e" id="id_estado_e">
                    <?php foreach($list_estado as $item){ ?>
                    <option value="<?php echo $item['id_status']; ?>" <?php if($item['id_status']==$bono[0]['estado']){ echo "selected"; } ?>>
                        <?php echo $item['nom_status']; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>  
        </div>	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" name="id_bono_e" id="id_bono_e" value="<?= $bono[0]['id']?>">
        <button type="button" class="btn btn-primary" onclick="Update_Bono_RRHH();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Retroceder
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
                $('#id_tipo_contratoe').html('<option value="0">Seleccione</option>');
            }
        });
    }

    function Traer_Tipo_Contrato_Rrhhe(){
        Cargando();

        var id_sede = $('#id_sedee').val();
        var url="<?php echo site_url(); ?>General/Traer_Tipo_Contrato_Rrhh";
        
        $.ajax({
            url: url,
            data:{'id_sede':id_sede},
            type:"POST",
            success:function (data) {
                $('#id_tipo_contratoe').html(data);
            }
        });
    }

    $(document).ready(function() {
        activateEnterKeyForFunction(Update_Bono_RRHH);
    });

    function Update_Bono_RRHH(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>General/Update_Bono_RRHH";

        if (Valida_Update_Bono_RRHH()) {
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
                        List_Bonos();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Bono_RRHH() {
        if($('#id_tipo_contratoe').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo de contrato.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_bono_e').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo de bono.',
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
        if($('#tipo_descuento_e').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo de descuento.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('general/rrhh/utils'); ?>