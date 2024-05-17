<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Impuesto (Nuevo) </b></h5>
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
                <select name="id_sede" id="id_sede" class="form-control" onchange="Traer_Tipo_Contrato_Rrhh();">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo Contrato:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_contrato" id="id_tipo_contrato">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresar Código">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Ingresar Tipo">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sub-Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="subtipo" id="subtipo" placeholder="Ingresar Sub-Tipo">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">De:</label>
            </div>
            <div class="form-group col-lg-9">
                <input type="text"
                pattern="^\d+(\.\d{1,2})?$"
                oninput="this.value = this.value.replace(/[^\d.]/g, '');"
                value="0"
                onblur="if(this.value=='') this.value='0';"
                onfocus="if(this.value=='0') this.value='';"
                class="form-control"
                id="de"
                name="de"
                placeholder="Ingresar monto"
                style="text-align:right; padding-right:20px;"
                autocomplete="off">
                <span style="position: absolute; left: 30px; top: 9px;">S/.</span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">A:</label>
            </div>
            <div class="form-group col-lg-9">
                <input type="text"
                pattern="^\d+(\.\d{1,2})?$"
                oninput="this.value = this.value.replace(/[^\d.]/g, '');"
                value="0"
                onblur="if(this.value=='') this.value='0';"
                onfocus="if(this.value=='0') this.value='';"
                class="form-control"
                id="a"
                name="a"
                placeholder="Ingresar monto"
                style="text-align:right; padding-right:20px;"
                autocomplete="off">
                <span style="position: absolute; left: 30px; top: 9px;">S/.</span>

            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">Porcentaje de impuesto:</label>
            </div>
            <div class="form-group col-lg-9">
                <input type="text"
                pattern="^\d+(\.\d{1,2})?$"
                oninput="this.value = this.value.replace(/[^\d.]/g, '');"
                value="0"
                onblur="if(this.value=='') this.value='0';"
                onfocus="if(this.value=='0') this.value='';"
                class="form-control"
                id="porcentaje_impuesto"
                name="porcentaje_impuesto"
                placeholder="0"
                style="text-align:right; padding-right:35px;"
                autocomplete="off">
                <span style="position: absolute; right: 20px; top: 9px;">%</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-3">
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
        <button type="button" class="btn btn-primary" onclick="Insert_Impuesto_RRHH();">
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
                $('#id_tipo_contrato').html('<option value="0">Seleccione</option>');
            }
        });
    }

    function Traer_Tipo_Contrato_Rrhh(){
        Cargando();

        var id_sede = $('#id_sede').val();
        var url="<?php echo site_url(); ?>General/Traer_Tipo_Contrato_Rrhh";
        
        $.ajax({
            url: url,
            data:{'id_sede':id_sede},
            type:"POST",
            success:function (data) {
                $('#id_tipo_contrato').html(data);
            }
        });
    }

    $(document).ready(function() {
        activateEnterKeyForFunction(Insert_Impuesto_RRHH);
    });

    function Insert_Impuesto_RRHH(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>General/Insert_Impuesto_RRHH";

        if (Valida_Insert_Impuesto_RRHH()) {
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
                        List_Impuesto();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Impuesto_RRHH() {
        if($('#id_tipo_contrato').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo de contrato.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#de').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#a').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#porcentaje_impuesto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el porcentaje.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
